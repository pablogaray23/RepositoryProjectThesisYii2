<?php

namespace backend\controllers;

use Yii;
use backend\models\Event;
use backend\models\EventSearch;
use backend\models\PrMed;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\DynamicModel;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use kartik\mpdf\Pdf;
use backend\models\BoxGeneral;
use backend\models\BoxAtencion;
use backend\models\EspAtn;
use backend\models\PrEsp;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventSearch();
		
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Event model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($day, $start_time, $end_time, $box)
    {
        $model = new Event();
		
		//$modelDias = [0,0,0,0,0,0];
		//$diasSeleccionados = [0,0,0,0,0,0];
		$modelDias = new DynamicModel([
			'dias','semanas'
		]);
		$modelDias->addRule(['dias','semanas'], 'safe');
		$modelDias->semanas = $day;
		$model->date=$day;
		$model->start_time = $start_time;
		$model->end_time = $end_time;
		$model->id_box = $box;
		$model->estado = "Pendiente";
		$nDia = date( "w", strtotime($day)); //0 Lunes -> 4 Viernes -> 6 Domingo
		//$modelDias[$nDia-1] = 1;
		//$diasSeleccionados[$nDia]=$nDia;
		$modelDias->dias=$nDia;
		
        if ($model->load(Yii::$app->request->post()) && $modelDias->load(Yii::$app->request->post())) {
			$diaAux = $model->date;
			$semanas=0;
			$totalSemanas = strtotime($modelDias->semanas)-strtotime($model->date);
			$totalSemanas = (($totalSemanas/(60*60*24))/7)+1;
			//echo strtotime($model->date)."<br>";
			//echo strtotime($modelDias->semanas)." semanas<br>";
			//echo $totalSemanas;
			
			while($semanas<$totalSemanas){
				
				foreach ($modelDias->dias as $dias){
					$nuevoEvento = new Event();
					$nuevoEvento->load(Yii::$app->request->post());
					$nuevoEvento->date = $model->date;
					$nuevoEvento->start_time = $model->start_time;
					$nuevoEvento->end_time = $model->end_time;
					$nuevoEvento->id_box = $box;
					$nuevoEvento->estado = "Pendiente";
					
					$blocked=0;
					
					$hora_inicio = strtotime($start_time);
					$hora_fin = strtotime($end_time);
					
					$dia = strtotime($model->date);
					$diaActual = ($dias-$nDia)+($semanas*7);
					
					if ($diaActual>0){
						$nuevoEvento->date = date('Y-m-d',strtotime("+$diaActual days",$dia));
					} else {
						$diaActual=$diaActual*-1;
						$nuevoEvento->date = date('Y-m-d',strtotime("-$diaActual days",$dia));
					}
					$eventos = Event::find()->where(['date' => date('Y-m-d',strtotime($nuevoEvento->date))])->andWhere(['id_box'=>$box])->all();
			
					foreach ($eventos as $evento){
					
						$horaInicioEvento = strtotime($evento->start_time);
						$horaFinEvento = strtotime($evento->end_time);
				
						$horaInicioNueva = strtotime($nuevoEvento->start_time);
						$horaFinNueva = strtotime($nuevoEvento->end_time);
					
						while ($horaInicioNueva < $horaFinNueva){
					
							if ($horaInicioNueva>=$horaInicioEvento && $horaInicioNueva<$horaFinEvento){
								$blocked = 1;
								break;
							} else if ($horaFinNueva>$horaInicioEvento && $horaFinNueva<=$horaFinEvento){
								$blocked = 1;
								break;
							}
							$horaInicioNueva = strtotime("+15 minutes",$horaInicioNueva);
						}
						
					}
					
					if ($blocked==1){
						@session_start();
						$_SESSION['choque']=$nuevoEvento;
					}else{
						$nuevoEvento->save(false);
					}
				}
				$semanas++;
			}
				return $this->redirect(['box-general/horario', 'id' => $box]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
				'modelDias' => $modelDias,
            ]);
        }
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$modelOriginal = $this->findModel($id);
		
		$modelIteraciones = new DynamicModel([
			'repetirCambios',
		]);
		
		$modelIteraciones->addRule(['repetirCambios'], 'safe');
		$modelIteraciones->repetirCambios=$model->date;
		
        if ($model->load(Yii::$app->request->post()) && $modelIteraciones->load(Yii::$app->request->post())) {
			//$modelIteraciones->repetirCambios=date('Y-m-d',strtotime($modelIteraciones->repetirCambios));
			$semanas = strtotime($modelIteraciones->repetirCambios)-strtotime($modelOriginal->date);
			//$model->update();
			$semanas = (($semanas/(60*60*24))/7);
			//while($contadorSemanas < $semanas){
			$model->date = date('Y-m-d',strtotime($model->date));
			$model->save();
			if ($modelIteraciones->repetirCambios!=$modelOriginal->date){
				$queryEventos = new Query;
				$fechaTerminoCambios = date('Y-m-d',strtotime($modelIteraciones->repetirCambios));
				$eventos = $queryEventos->select('id_event,estado')->from('event')->where(['rut_profesional'=>$modelOriginal->rut_profesional,'id_box'=>$modelOriginal->id_box,'title'=>$modelOriginal->title,'description'=>$modelOriginal->description,'start_time'=>$modelOriginal->start_time,'end_time'=>$modelOriginal->end_time])->andWhere(['>', 'id_event', $modelOriginal['id_event']])->andWhere(['<=','date',$fechaTerminoCambios])->all();
				$ciclo = 7;
				foreach($eventos as $evento){
					try{
						$newDate = date('Y-m-d',strtotime("+$ciclo days",strtotime($model->date)));
						echo $newDate;
						?><br><?php
						//$event = new Event();
						$event = $this->findModel($evento['id_event']);
						$event->load(Yii::$app->request->post());
						//$model->date = date('Y-m-d', strtotime("+$numDia days",$diaInicioAux));
						$event->id_event = $evento['id_event'];
						$event->rut_profesional = $model['rut_profesional'];
						$event->id_box = $model['id_box'];
						$event->title = $model['title'];
						$event->description = $model['description'];
						$event->date = $newDate;?><br><?php
						$event->start_time = $model['start_time'];
						$event->end_time = $model['end_time'];
						$event->estado=$evento['estado'];
						
						echo $event->date;?><br><?php
						$event->update();
						$ciclo = $ciclo+7;
					}catch(\Exception $e){
						
					}
				}
			}
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
				'modelIteraciones' => $modelIteraciones,
            ]);
        }
    }

    /**
     * Deletes an existing Event model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	public function actionBlock($id)
	{
		$model = $this->findModel($id);
		$model->estado = 'Bloqueado';
		$model->save();
		return $this->redirect(['box-general/horario','id'=>$model->id_box]);
	}
	
	public function actionCreateAll(){ //LA FUNCION PRINCIPAL
		$eventosNoAgregados = 'Los siguientes bloques no pueden ser agregados:<br>';
		$limite = new DynamicModel([
			'semanaInicio','semanaFin',
		]);
		$limite->addRule(['semanaInicio'], 'safe');
		$limite->addRule(['semanaFin'], 'safe');
		
		if ($limite->load(Yii::$app->request->post())) {
			
			$query = new Query; //Obtengo tipos de atencion y las ordeno por cantidad de box que tienen de menor a mayor
			$atenciones = $query->select('id_atn, COUNT(id_atn)')->from('box_atencion')->groupBy('id_atn')->orderBy('COUNT(id_atn)')->all();
			$diaInicio = strtotime($limite['semanaInicio']);
			$diaInicioAux = $diaInicio;
			$diaFin = strtotime($limite['semanaFin']);
			//echo strtotime($limite['semanaInicio']);die();
			
			foreach ($atenciones as $atencion){ //Tomo cada indice de atencion de box que existen
				//echo "Tipo atencion actual: ".$atencion['id_atn'];?><br><?php
				$queryBoxes = new Query; //Obtengo los boxes que tienen la atencion actual
				$listaBoxes = $queryBoxes->select('id_boxAtencion,id_atn')->from('box_atencion')->where(['id_atn'=>$atencion['id_atn']])->all();
				
				$queryEspecialidadesMedicas = new Query; //Busco las especialidades medicas que buscan el tipo de atencion
				$especialidadesMedicas = $queryEspecialidadesMedicas->select('id_esp_gen')->from('esp_atn')->where(['id_atn_gen'=>$atencion['id_atn']])->all();
				
				$listaMedicos = []; 
				$listaHorariosMedicos = [];
				
				foreach ($especialidadesMedicas as $especialidadMedica){
					$queryMedicos = new Query; //Obtengo los medicos ineresados en estos box de esta especialidad
					$listaMedicos = array_merge($listaMedicos,$queryMedicos->select('rut')->from('pr_esp')->where(['codigoEspecialidad'=>$especialidadMedica['id_esp_gen']])->all());
					//$listaMedicos = $queryMedicos->select('rut,codigoEspecialidad')->from('pr_esp')->where(['codigoEspecialidad'=>$especialidadMedica['id_esp_gen']])->all();
				}
				foreach ($listaMedicos as $medico){
					//echo $medico['rut']." | ";
					$queryHorarios = new Query; //Obtengo los horarios de los medicos que estan interesados
					$listaHorariosMedicos = array_merge($listaHorariosMedicos,$queryHorarios->select('rut_profesional,dia_semana,hora_inicio,hora_fin')->from('pr_hor')->where(['rut_profesional'=>$medico['rut']])->all());
				}
				
				foreach($listaHorariosMedicos as $horario){
					$eventoAgregado = false; //Reviso si ingrese el evento o no
					foreach ($listaBoxes as $box){
						$queryNombreMedico = new Query;
						//$queryEspecialidadMedico = new Query;
						$queryEventoHoy = new Query;
						//$eventoHoy = $queryEventoHoy->select('*')->from('event')->where(['date_added'=>date("Y-m-d")],['date'=>$['dia_semana']],['hora_inicio'=>$box['hora_inicio']],['hora_fin'=>$box['hora_fin']]);
						//if (empty($eventoHoy)){
						
						//Ahora viene la generacion del modelo y posterior ingreso
						while($diaInicioAux<=$diaFin){
							try{
								$model = new Event();
								$model->load(Yii::$app->request->post());
			
								$numDia = $horario['dia_semana'];
								//echo "dia: ".$diaInicio;?><br><?php
								
								$model->start_time = $horario['hora_inicio'];
								$model->end_time = $horario['hora_fin'];
								$model->id_box = $box['id_boxAtencion'];
								$model->estado = "Pendiente";
								//$model->date_added = date("Y-m-d");
								$medico = $queryNombreMedico->select('nombre, apellidoPaterno')->from('pr_med')->where(['rut'=>$horario['rut_profesional']])->one();
								
								$model->title = $medico['nombre']." ".$medico['apellidoPaterno'];
								$model->description = "test";
								$model->rut_profesional = $horario['rut_profesional'];
						
								//echo $diaInicioAux." | ".$diaFin;
								
								$model->date = date('Y-m-d', strtotime("+$numDia days",$diaInicioAux));
								//echo $model->date;die();
								$model->save(false);
								
								$diaInicioAux = strtotime("+7 days",$diaInicioAux);
								//echo $diaInicioAux;
								//echo "Modelo guardado";?><br><?php
								$eventoAgregado = true;
								break 3;
								
							}catch(\Exception $e){
								//echo $e;
								//echo "No entro";
								$diaInicioAux = strtotime("+7 days",$diaInicioAux);
							}
							
						}
						
						//Fin ingreso
						
						?><br><?php
					}
					$diaInicioAux = $diaInicio;
				}
				if (!$eventoAgregado){
						
						//Hay que hacer la relacion entre pr_esp y Box atencion entre las variables de atencion. Despues se hace una busqueda del indice mayor
						//y se compara con el actual. Si es igual, se guarda el mensaje de q no se pudo agregar
						$queryMaxEspecialidad = PrEsp::find()->where(['rut'=>$horario['rut_profesional']])->max('codigoEspecialidad');
						$queryMaxAtencion = EspAtn::find()->where(['id_esp_gen'=>$queryMaxEspecialidad])->max('id_atn_gen');
						//echo $queryMaxAtencion;die();
						if ($queryMaxAtencion==$atencion['id_atn']){
							if (!isset($eventosNoAgregados)){
								$eventosNoAgregados = 'Los siguientes bloques no tienen box para ser agregados:<br>';
							}
							$medicoAux = PrMed::find()->where(['rut'=>$horario['rut_profesional']])->one();
							//$queryMaxAtencion = BoxAtn::find()->joinWith('pr_esp');
							//$ultimaAtencion = $queryMaxAtencion->select('MAX(id_atn_gen)')->groupBy('id_atn')->where([''=>''])->one();
							//Algo simple solo para escribir nombre de dia en vez del numero porque siempre esta en inlges aunque le cambie el Locale
							if ($horario['dia_semana']==0){
								$nombreDia='Lunes';
							} else if ($horario['dia_semana']==1){
								$nombreDia='Martes';
							} else if ($horario['dia_semana']==2){
								$nombreDia='Miercoles';
							} else if ($horario['dia_semana']==3){
								$nombreDia='Jueves';
							} else if ($horario['dia_semana']==4){
								$nombreDia='Viernes';
							} else {
								$nombreDia='Sabado';
							}
							$eventosNoAgregados = $eventosNoAgregados."Profesional ".
								$medicoAux->nombre.' '.
								$medicoAux->apellidoPaterno.' ('.
								$horario['rut_profesional'].') en el bloque de '.
								$horario['hora_inicio'].' a '.
								$horario['hora_fin'].' el dia '.
								$nombreDia.'<br>';
							//echo "eventos";
							//var_dump($eventosNoAgregados);
						}
					}
			}
			session_start();
			$_SESSION['eventosNoAgregados'] = $eventosNoAgregados;
			//echo "final";
			return $this->redirect(['box-general/boxs']);
		} else {
			return $this->renderAjax('create-all', [
				'limite' => $limite,
			]);
		}
	}
	
	public function actionReporteIncumplido(){
		$modelMes = new DynamicModel([
			'mes'
		]);
		$modelMes->addRule(['mes'], 'safe'); 
		
		if ($modelMes->load(Yii::$app->request->post())){
			$month = date('m',strtotime($modelMes->mes));
			$year = date('Y',strtotime($modelMes->mes));
			$query = Event::find()->select('*')->where('year(date)="'.$year.'"')->andWhere('month(date)="'.$month.'"')->andWhere(['<>','estado','Pendiente']);
			$provider = new ActiveDataProvider([
				'query' => $query,
			]);
			//return $this->render('view', [
			//	'model' => $this->findModel($id),
			//]);
			return $this->render('reporte-incumplido', [
				'dataProvider' => $provider,
				'fecha' => $modelMes->mes,
			]);
		} else {
			return $this->renderAjax('_form-reporte-incumplido', [
				'modelMes' => $modelMes,
			]);
		}
	}

	public function actionReportepdf($fecha) {
		// get your HTML raw content without any layouts or scripts
		//$content = $this->renderPartial('@backend/views/seed-evaluacion/view',array('id' => 1));
		//$model = new SeedEvaluacion;
		$content = $this->renderPartial('reporte-incumplido-pdf',[
			'fecha' => $fecha,
			'mode'=> Pdf::MODE_UTF8,
			'format'=> Pdf::FORMAT_A4,
			
			'destination'=> Pdf::DEST_BROWSER,
		]);

		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_UTF8, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
        'orientation' => Pdf::ORIENT_LANDSCAPE, 
        // stream to browser inline
        'destination' => Pdf::DEST_BROWSER, 
        // your html content input
        'content' => $content,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:18px}', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Reporte'],
         // call mPDF methods on the fly
        'methods' => [ 
            'SetHeader'=>['Reporte'], 
            'SetFooter'=>['{PAGENO}'],
        ]
    ]);
		$pdf->content = $content;
		return $pdf->render();
		// return the pdf output as per the destination setting
		//return $pdf->render(); 
	} 	

	public function actionReporteRanking(){
		$modelMes = new DynamicModel([
			'mes'
		]);
		$modelMes->addRule(['mes'], 'safe'); 
		
		$count = Yii::$app->db->createCommand('
			SELECT COUNT(*) FROM Event GROUP BY rut_profesional')->queryScalar();
		
		if ($modelMes->load(Yii::$app->request->post())){
			$month = date('m',strtotime($modelMes->mes));
			$year = date('Y',strtotime($modelMes->mes));
			//$rutMedicos = PrMed::find()->all();
			$dataProvider = new SqlDataProvider([
				'sql' => 'SELECT rut_profesional as rut, SEC_TO_TIME(SUM(TIME_TO_SEC(`end_time`)-TIME_TO_SEC(`start_time`))) as horas FROM event GROUP BY rut_profesional' ,
				'pagination' => [
					'pageSize' => 20,
				],
				'totalCount' => $count,
				//'sort' => ['defaultOrder' => ['horas'=>SORT_DESC]],
				//sort' => ['attributes' => ['horas'=>SORT_DESC]],
				'sort' => [
					'attributes' => [
						'rut',
						'horas'
					]
				],
			]);
			//var_dump($dataProvider);
			//die();
			return $this->render('reporte-horas-trabajadas', [
				'dataProvider' => $dataProvider,
				'fecha' => $modelMes->mes,
			]);
		} else {
			return $this->renderAjax('_form-reporte-incumplido', [
				'modelMes' => $modelMes,
			]);
		}
	}
	public function actionReporteRankingpdf($fecha) {
		// get your HTML raw content without any layouts or scripts
		//$content = $this->renderPartial('@backend/views/seed-evaluacion/view',array('id' => 1));
		//$model = new SeedEvaluacion;
		
		
		$count = Yii::$app->db->createCommand('
			SELECT COUNT(*) FROM Event GROUP BY rut_profesional')->queryScalar();
		$dataProvider = new SqlDataProvider([
				'sql' => 'SELECT rut_profesional as rut, SEC_TO_TIME(SUM(TIME_TO_SEC(`end_time`)-TIME_TO_SEC(`start_time`))) as horas FROM event GROUP BY rut_profesional ORDER BY horas DESC' ,
				'pagination' => [
					'pageSize' => 20,
				],
				'totalCount' => $count,
				//'sort' => ['defaultOrder' => ['horas'=>SORT_DESC]],
				//sort' => ['attributes' => ['horas'=>SORT_DESC]],
				'sort' => [
					'attributes' => [
						'rut',
						'horas' => [
							'default' => SORT_DESC,
						],
					]
				],
			]);
		
		
		$content = $this->renderPartial('reporte-horas-trabajadas-pdf',[
			'fecha' => $fecha,
			'dataProvider' => $dataProvider,
			'mode'=> Pdf::MODE_CORE,
			'format'=> Pdf::FORMAT_A4,
			
			'destination'=> Pdf::DEST_BROWSER,
		]);

		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_UTF8, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
        'orientation' => Pdf::ORIENT_LANDSCAPE, 
        // stream to browser inline
        'destination' => Pdf::DEST_BROWSER, 
        // your html content input
        'content' => $content,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:18px}', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Reporte'],
         // call mPDF methods on the fly
        'methods' => [ 
            'SetHeader'=>['Reporte'], 
            'SetFooter'=>['{PAGENO}'],
        ]
    ]);
		$pdf->content = $content;
		return $pdf->render();
		// return the pdf output as per the destination setting
		//return $pdf->render(); 
	} 	
	
	public function actionReportePorcentaje() {
		$modelMes = new DynamicModel([
			'mes'
		]);
		$modelMes->addRule(['mes'], 'safe'); 
		
		$count = Yii::$app->db->createCommand('
			SELECT COUNT(*) FROM Event GROUP BY rut_profesional')->queryScalar();
		
		if ($modelMes->load(Yii::$app->request->post())){
			$month = date('m',strtotime($modelMes->mes));
			$year = date('Y',strtotime($modelMes->mes));
			$dateEnd = date('Y-m-d');
			
			//Hack """rapido""" para el ultimo dia del mes
			$primerDia = mktime(0,0,0,$month,1,$year);
			if ($month==12){
				$month=0;
			} else {
				$month++;
			}
			$ultimoDia = mktime(0,0,0,$month, 0, $year);
			//echo date('Y-m-d',$primerDia);die();
			//echo date('Y-m-d',$ultimoDia);die();
			$lista = array();
			$minutosDia=15*5*60;
			$listaIdBox = BoxGeneral::find()->select('id_box, nombre_box')->all();
			
			foreach($listaIdBox as $box){
				$Eventos = Event::find()->where(['between','date',date('Y-m-d',$primerDia),date('Y-m-d',$ultimoDia)])->andWhere(['id_box'=>$box->id_box])->all();
				$minutosTotales = 0;
				
				foreach($Eventos as $actual)
				{
					$horaInicio = strtotime($actual->start_time);
					$horaFin = strtotime($actual->end_time);
					$diff = ($horaFin-$horaInicio)/60;
					//echo $actual->id_event.": ".$diff."<br>";
					$minutosTotales = $minutosTotales+$diff;
				}
				$promedio = round((100*$minutosTotales)/$minutosDia,0,PHP_ROUND_HALF_DOWN);
				$modelPorcentaje =
				//Nombre | Porcentaje | Total horas
				array_push($lista,array(
					$box->nombre_box,
					$promedio,
					round($minutosTotales/60,0,PHP_ROUND_HALF_DOWN)
					)
				);
			}
			
			
			return $this->render('reporte-porcentaje', [
					'lista' => $lista,
					'month'=> $month,
					'year'=> $year,
				]);
		} else {
			return $this->renderAjax('_form-reporte-incumplido', [
				'modelMes' => $modelMes,
			]);
		}
	} 
	
	public function actionReportePorcentajepdf($month,$year) {
		
		$count = Yii::$app->db->createCommand('
			SELECT COUNT(*) FROM Event GROUP BY rut_profesional')->queryScalar();
		
			$dateEnd = date('Y-m-d');
			
			//Hack """rapido""" para el ultimo dia del mes
			$primerDia = mktime(0,0,0,$month,1,$year);
			if ($month==12){
				$month=0;
			} else {
				$month++;
			}
			$ultimoDia = mktime(0,0,0,$month, 0, $year);
			//echo date('Y-m-d',$primerDia);die();
			//echo date('Y-m-d',$ultimoDia);die();
			$lista = array();
			$minutosDia=15*5*60;
			$listaIdBox = BoxGeneral::find()->select('id_box, nombre_box')->all();
			
			foreach($listaIdBox as $box){
				$Eventos = Event::find()->where(['between','date',date('Y-m-d',$primerDia),date('Y-m-d',$ultimoDia)])->andWhere(['id_box'=>$box->id_box])->all();
				$minutosTotales = 0;
				
				foreach($Eventos as $actual)
				{
					$horaInicio = strtotime($actual->start_time);
					$horaFin = strtotime($actual->end_time);
					$diff = ($horaFin-$horaInicio)/60;
					//echo $actual->id_event.": ".$diff."<br>";
					$minutosTotales = $minutosTotales+$diff;
				}
				$promedio = round((100*$minutosTotales)/$minutosDia,0,PHP_ROUND_HALF_DOWN);
				$modelPorcentaje =
				//Nombre | Porcentaje | Total horas
				array_push($lista,array(
					$box->nombre_box,
					$promedio,
					round($minutosTotales/60,0,PHP_ROUND_HALF_DOWN)
					)
				);
			}
		$content = $this->renderPartial('reporte-porcentaje-pdf',[
			'lista' => $lista,
			'month'=> $month,
			'year'=> $year,
			'mode'=> Pdf::MODE_CORE,
			'format'=> Pdf::FORMAT_A4,
			'destination'=> Pdf::DEST_BROWSER,
		]);

		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
			'mode' => Pdf::MODE_UTF8, 
			// A4 paper format
			'format' => Pdf::FORMAT_LEGAL, 
			// portrait orientation
			'orientation' => Pdf::ORIENT_LANDSCAPE, 
			// stream to browser inline
			'destination' => Pdf::DEST_BROWSER, 
			//'destination' => Pdf::DEST_DOWNLOAD, 
			// your html content input
			'content' => $content,  
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting 
			'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			// any css to be embedded if required
			'cssInline' => '.kv-heading-1{font-size:18px}', 
			 // set mPDF properties on the fly
			'options' => ['title' => 'Reporte'],
			 // call mPDF methods on the fly
			'methods' => [ 
				'SetHeader'=>['Reporte'], 
				'SetFooter'=>['{PAGENO}'],
			]
		]);
		$pdf->content = $content;
		return $pdf->render();
		// return the pdf output as per the destination setting
		//return $pdf->render(); 
		
	}
	
	
    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
