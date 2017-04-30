<?php

namespace backend\controllers;

use Yii;
use backend\models\PrAntecedente;
use backend\models\PrAntecedenteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use kartik\widgets\Alert;
use yii\data\ActiveDataProvider;

use app\mpdf\mpdf\mpdf;
use backend\models\PrEsp;
use backend\models\PrEspSearch;
use backend\models\PrMed;
use backend\models\PrMedSearch;
use backend\models\EspGen;
use backend\models\Event;
use backend\models\BoxGeneral;

use yii\filters\AccessControl;

/**
 * PrAntecedenteController implements the CRUD actions for PrAntecedente model.
 */
class PrAntecedenteController extends Controller
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
			'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','create','delete','update','view','convenios','report','deleteconvenio'],
                        'allow' => Yii::$app->user->can('Funcionario'),
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all PrAntecedente models.
     * @return mixed
     */
    public function actionIndex($rut_med)
    {
        $searchModel = new PrAntecedenteSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$dataProvider = $searchModel->search(['PrAntecedenteSearch'=>['rut_med'=>$rut_med]]);
		
		/*$dataProvider = new ActiveDataProvider([
			'query' => PrAntecedente::find()->where(['rut_med'=>$rut_med])->andWhere(['<>','tipoAntecedente','5']),
		]);*/
		

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'rut_med'=>$rut_med,
        ]);
    }

    /**
     * Displays a single PrAntecedente model.
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
     * Creates a new PrAntecedente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
      
	public function actionCreate($rut_med){
        $model = new PrAntecedente();

        if ($model->load(Yii::$app->request->post()) ) {
			$model->fechaSubida = date('Y-m-d');
            $model->file = UploadedFile::getInstance($model, 'file');
			$model->nombreArchivo = $model->rut_med.$model->file;
			
			$model->save();
			
            $model->file->saveAs('archivos/'.$model->rut_med.''. iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $model->file->baseName ) . '.' . $model->file->extension);
			
			@session_start();
			$_SESSION['archivoCreado'] = $model;
				  
			return $this->redirect(['pr-antecedente/index', 'rut_med' => $rut_med]);

        } else {
            return $this->renderAjax('create', [
                'model' => $model,
				'rut_med'=>$rut_med,
            ]);
        }
    }
	
	
	/* public function actionCreate($id)
    {
        $model = new PrEsp();

        if ($model->load(Yii::$app->request->post()) ) {
           // return $this->redirect(['view', 'id' => $model->id]);	
			$mostrarCodEsp = $model->codigoEspecialidad;
			$mostrarElRut = $model->rut;
			//echo $mostrarRut;
			$exists = PrEsp::find()->where([ 'codigoEspecialidad' => $mostrarCodEsp])->andWhere(['rut' => $mostrarElRut])->exists();
			//echo $exists;
			
			if($exists!=null){
				
				//echo "existe";
				@session_start();
			$_SESSION['especialidadNoCreado'] = $model;
			return $this->redirect(['pr-med/index']);
			}else{
				//echo "no existe";
				$model->save();
			@session_start();
			$_SESSION['especialidadCreado'] = $model;
			return $this->redirect(['pr-med/index']);
				
			}
			
			
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
				'id'=>$id,
            ]);
        }
    }
	*/

    /**
     * Updates an existing PrAntecedente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PrAntecedente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
      public function actionDelete($id)
    {
		//unlink(getcwd().'/archivos/'.$model->nombreArchivo);
		//unlink(getcwd().'/uploads/'.$model->file_id.'/'.$fileModel->file_name.$fileModel->extension);
       @session_start();
	   $model = $this->findModel($id);
	   $rutDelProfesional = $model -> rut_med;
	   $nombreFile = $model -> nombreArchivo;
	   unlink(getcwd().'/archivos/'.iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $nombreFile ));
	   
	           $this->findModel($id)->delete();
			   $_SESSION['deleteAntecedentes'] = $model;
			   
			   return $this->redirect(['pr-antecedente/index', 'rut_med' => $rutDelProfesional]);

    //    return $this->redirect(['pr-med/index']);
	   
		//echo $nombreFile;
    }
	
	public function actionConvenios($rut_med)
    {
		$model = new PrAntecedente();
        $searchModel = new PrAntecedenteSearch();
		//$model = PrAntecedente::find()->where([ 'rut_med' => $rut_med]);
        $dataProvider = $searchModel->searchConvenios(Yii::$app->request->queryParams);
		
		$dataProvider = $searchModel->searchConvenios(['PrAntecedenteSearch'=>['rut_med'=>$rut_med]]);
		//$dataProvider = $searchModel->search(Yii::$app->request->queryParams+['PrAntecedenteSearch' => ['not in', 'tipoAntecedente' =>'convenio']]);

        return $this->render('convenios', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'rut_med'=>$rut_med,
			'model' => $model,
        ]);
    }
	
	
public function actionReport($rut) {
    // get your HTML raw content without any layouts or scripts
	$fecha = date('d-m-Y');
	$valor_arriendo = '12345678';
	 
	$model = PrMed::findOne($rut);	  
	 
	//$exists = PrEsp::find()->where([ 'rut' => $rut])->exists();
	//$exists = PrEsp::find()->where([ 'rut' => $rut])->exists();
	//$exists = PrEsp::find()->where([ 'rut' => $rut])->asArray()->all();
	$exists = PrEsp::find()->where([ 'rut' => $rut])->one();
	$especialidadExiste = $exists->codigoEspecialidad;
	 
	// $unaEspecialidad = EspGen::find()->where([ 'codigoEspecialidad' => $especialidadExiste])->asArray()->one();
	$unaEspecialidad = EspGen::find()->where([ 'codigoEspecialidad' => $especialidadExiste])->asArray()->one();
	 
	//$modelTres = PrEsp::findOne('14752031k');
	//$modelTres = PrEsp::find()->where([ 'rut' => $rut])->asArray()->all();
	   
	$unCodigoH = \yii\helpers\ArrayHelper::getValue($unaEspecialidad, 'nombreEspecialidad');

	//var_dump($unCodigoH);
	  
	//var_dump($unCodigoH);	  


	$numeroDia = date('N', strtotime($fecha));
	
	$monday = new \DateTime($fecha);
	$sunday = new \DateTime($fecha);
	
	$elLunes = $monday->modify('-'.($numeroDia-1).' days')->format('Y-m-d');

	$elDomingo = $sunday->modify('+'.(7-$numeroDia).' days')->format('Y-m-d');

	$Eventos =Event::find()->where(['between','date',$elLunes,$elDomingo])->andWhere(['rut_profesional'=>$rut])->all();
	  	  
	$nombre = "     ".$model->nombre."  ".$model->apellidoPaterno." ".$model->apellidoMaterno;
	$rut = " ".$model->rut;
	$domicilio = " ".$model->direccion;

	$fechaDia = substr($fecha, 0,-8);
	$fechaMes = substr($fecha, 3,-5);
	$fechaAnio = substr($fecha, 6);
	  
	  
	$pdf = new \fpdf\FPDF('P','mm','letter');
	$pdf->Open();
	$pdf->SetMargins(25,25,25);
	$pdf->AddPage();
	
	
	$pdf->Text(77,63,utf8_decode(''.$nombre.''),0,'C', 0);
	
	$pdf->SetFont('times','',12);
	
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	

    $pdf->SetFont('times','',10);
   // $pdf->Cell(0,6, utf8_decode(' En Chillán, a '.utf8_decode($fechaDia)." de ".$meses[(int)$fechaMes - 1]. " de ".utf8_decode($fechaAnio).' '),0,1);
	$pdf->Ln(10);
	

$html='En Chillán, a <b> '.utf8_decode($fechaDia)." de ".$meses[(int)$fechaMes - 1]. " de ".utf8_decode($fechaAnio).' </b> por una parte,<b> CLINICA CHILLAN S.A </b>, sociedad del giro <br> de su denominación, 
rol único tributario número <b> 76.515.070-1 </b> domiciliada en calle Pedro Aguirre <br>
	Cerda N° 35 de la ciudad y comuna de Chillán, representada, según se acreditará, por don Nelson <br>
	Rodrigo Lemarie Barría, Gerente General, del mismo domicilio de su representada, en adelante <br>
	también el <b>"PROPIETARIO"</b> o <b> "PRESTADOR DE SERVICIOS" </b>y, por la otra parte, Don(ña) <br>
<b>	'.utf8_decode(''.$nombre.'').'</b>, ESPECIALIDAD EN '.utf8_decode(''.$unCodigoH.'').'  cédula <br>
	nacional de identidad Nº<b> '.utf8_decode(''.$rut.'').'</b>, domiciliado en <b> '.utf8_decode(''.$domicilio.'').'</b>,  de la <br>
	comuna  de Chillán  en adelante también e indistintamente el <b>"ARRENDADOR"</b>, se ha convenido <br>
	en el siguiente contrato de uso de dependencias y prestación de servicios médicos de administración <br>
	y gestión: ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html),$parsed );
$pdf->MultiCell(169,6, $parsed );	
	
        $pdf->Ln(5);
	
	
$html2='PRIMERO: BIENES OBJETO DEL CONTRATO. ';


$pdf->Ln(5);

  $pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html2),$parsedDos );
$pdf->MultiCell(169,6, $parsedDos );
	
	$pdf->Ln(5);
	
	$html3='Clínica Chillán es una entidad de salud que otorga servicios de atención médica en la ciudad de Chillán, considerada una de las principales instituciones privada de salud de la Provincia de Ñuble, gracias a su moderna infraestructura, equipamiento. ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html3),$parsedTres );
$pdf->MultiCell(169,6, $parsedTres );	
	
	$pdf->Ln(5);
	
	$html4='Según el siguiente instrumento procede a institucionalizar al médico para poder generar atenciones medicas integrales en forma eficaz y eficiente dentro de la empresa antes mencionada, otorgando una atención de calidad.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html4),$parsedCuatro );
$pdf->MultiCell(169,6, $parsedCuatro );


$pdf->Ln(10);
	
	
$html5='SEGUNDO: CONTRATO, CONSENTIMIENTO. ';


  $pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html5),$parsedCinco );
$pdf->MultiCell(169,6, $parsedCinco );

$html6='Por el presente instrumento el PROPIETARIO, por medio de su representante, entrega al ARRENDADOR, quien recibe y acepta  para si, el inmueble singularizado en la cláusula precedente con todos y cada uno de los muebles que se detallan en el referido ANEXO I y que se entiende forma parte del presente contrato ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html6),$parsedSeis );
$pdf->MultiCell(169,6, $parsedSeis );	
	
	$pdf->Ln(10);
	
	$html7=' ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html7),$parsedSiete );
$pdf->MultiCell(169,6, $parsedSiete );	
$pdf->Ln(10);
	
	$html8='El servicio para el cual se entrega el inmueble es el funcionamiento y operación de una consulta médica, de acuerdo a su profesión y especialidad que detenta bajo la modalidad de  ejercicio liberal de su profesión y no en calidad de funcionario de la Clínica, por lo que se hace responsable legalmente de sus actos profesionales, para atención de público y pacientes del ARRENDADOR en los días y horas que comprende el contrato de uso de dependencias, pero no en menos ni en más días ni  en menos ni en más horas que las convenidas. 
	Esta es una cláusula esencial del presente contrato de manera que su incumplimiento acarrea la necesaria e inmediata terminación del mismo. ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html8),$parsedOcho );
$pdf->MultiCell(169,6, $parsedOcho );	

 $pdf->Ln(5);
	
	
$html10='TERCERO: ACREDITACIÓN PROFESIONAL. ';


$pdf->Ln(5);

  $pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html10),$parsedDiez );
$pdf->MultiCell(169,6, $parsedDiez );

$pdf->Ln(5);
	
	$html9='El ARRENDATARIO declara estar suscrito al Registro Nacional de Prestadores Individuales de la Superintendencia de Salud, de acuerdo a la normativa vigente. No obstante estos antecedentes serán revisados y visados por el Director Médico de Clínica Chillán, controladora de Inmobiliaria Collín S.A. ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html9),$parsedNueve );
$pdf->MultiCell(169,6, $parsedNueve );	

 $pdf->Ln(5);
	
	
$html11='CUARTO: HORARIO Y PLAZO DEL USO DE DEPENDENCIAS. ';


$pdf->Ln(5);

  $pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html11),$parsedOnce );
$pdf->MultiCell(169,6, $parsedOnce );

$pdf->Ln(5);
	
	$html12='En virtud del presente contrato  el "ARRENDADOR" podrá y deberá utilizar los bienes entregados por un total de (abajo especifíca tot. hrs) horas semanales, distribuidas estrictamente en el siguiente horario: ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html12),$parsedDoce );
$pdf->MultiCell(169,6, $parsedDoce );	

 $pdf->Ln(5);
	

	
	
	$pdf->SetWidths(array(40, 43, 45, 40));
	$pdf->SetFont('Arial','B',10);
	$pdf->SetFillColor(85,107,47);
    $pdf->SetTextColor(255);

		for($i=0;$i<1;$i++)
		{
			$pdf->Row(array('BOX NUMERO', 'DIA', 'HORA INICIO', 'HORA FIN'));
		}		
		Yii::$app->formatter->locale = 'es-ES';
		setlocale(LC_ALL, 'es-ES');
		$minutosTotales = 0;
		foreach($Eventos as $data){
			$pdf->SetFillColor(153,255,153);
    		$pdf->SetTextColor(0);
			$columnaBox = BoxGeneral::find()->where(['id_box'=>$data->id_box])->one()->nombre_box;//con esto ya aprendi a obtener valores despues de un array desde modelDos
			//$columnaDia = \yii\helpers\ArrayHelper::getValue(date('n',strtotime($data,'date')));
			//$columnaDia = date('l',strtotime($data->date));
			$columnaDia = strftime("%A", strtotime($data->date));
			$columnaHoraInicio = \yii\helpers\ArrayHelper::getValue($data, 'start_time');
			$columnaHoraFin = \yii\helpers\ArrayHelper::getValue($data, 'end_time');
			
			$diff = ((strtotime($data->end_time))-(strtotime($data->start_time)))/60;
			$minutosTotales = $minutosTotales+$diff;
			
			$pdf->Row(array($columnaBox,$columnaDia, $columnaHoraInicio, $columnaHoraFin));
		}
		$horasTotales = floor($minutosTotales/60);
		$minutosTotales = ($minutosTotales)-($horasTotales*60);
		$pdf->Row(array(" ","Horas Semanales: ",$horasTotales." horas ".$minutosTotales." minutos"," "));
		   
		$pdf->Ln(10);
	
	$html13='La duración del contrato de uso de dependencias culminará cada 31 de diciembre de cada año y será de doce meses contados desde esa fecha. 
	Dicho plazo se entenderá renovado tácita y automáticamente por períodos iguales y sucesivos de doce meses cada uno, a menos que alguna de las partes comunique a la otra su decisión de no perseverar en el contrato, 
	lo que deberá hacer por escrito con una anticipación mínima de 30 (días) días al vencimiento del plazo originalmente pactado o de alguna de sus prórrogas. 
	Para efectos de computar el plazo éste se contará desde la fecha de envío de la carta, lo que podrá hacerse por mano, por correo, o por otro medio que de certeza de su despacho. ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html13),$parsedTrece );
$pdf->MultiCell(169,6, $parsedTrece );	

 $pdf->Ln(55);
 
 
 
  $html15='No obstante lo anterior, el PROPIETARIO podrá dar término al presente contrato, sin expresión de causa y sin esperar que se cumpla el plazo del contrato original o de sus prórrogas, comunicando al ARRENDADOR con al menos 30 días de anticipación. ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html15),$parsedQuince );
$pdf->MultiCell(169,6, $parsedQuince );	

 $pdf->Ln(5);
 
 
 $html17='El PROPIETARIO puede, sin autorización del ARRENDADOR, entregar el bien a un tercero, por las horas y/o días que no están comprendidas en este contrato. 
 Quien concurre como ARRENDADOR al presente contrato queda obligado a dar todas las facilidades para que ambos - o más de dos -  
 contratos puedan cumplirse en las horas convenidas con cada uno de ellos. Asimismo no dejará objetos personales en la consulta que puedan perturbar su uso por los demás ARRENDATARIOS. ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html17),$parsed17 );
$pdf->MultiCell(169,6, $parsed17 );	

 $pdf->Ln(5);
 
  $html18='QUINTO: DESTINO DE LOS BIENES ENTREGADOS. ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html18),$parsed18 );
$pdf->MultiCell(169,6, $parsed18 );	

 $pdf->Ln(5);
 
  $html19='El ARRENDADOR se obliga a destinar los bienes objeto del presente contrato exclusivamente 
  a las actividades que se comprenden en el servicio que motiva su otorgamiento, esto es, la prestación de servicios a terceros o a pacientes del ARRENDADOR en los días y horas convenidos. ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html19),$parsed19 );
$pdf->MultiCell(169,6, $parsed19 );	

 $pdf->Ln(5);
 
  $html20='El incumplimiento del servicio que motiva el contrato, esto es, el no uso de la consulta médica para atención de público y pacientes del 
  ARRENDADOR en los días y horas que comprende el contrato de uso de dependencias, pero no en menos ni en más días ni 
  en menos ni en más horas que las convenidas, dará derechos al PROPIETARIO, a poner término al presente contrato, 
  sin necesidad de requerimiento previo alguno, sin concesión de plazos y sin derecho a indemnización alguna para el ARRENDADOR.  ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html20),$parsed20 );
$pdf->MultiCell(169,6, $parsed20 );	

 $pdf->Ln(5);
 
 $html21='Las partes están conscientes en que la consulta se encuentra inserta en el contexto de un centro médico de atención de pacientes, 
 de manera que la falta de atención de pacientes en las horas previstas, causa perjuicios al centro médico y a la clínica de la cual el centro, a su vez, es parte integrante.  ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html21),$parsed21 );
$pdf->MultiCell(169,6, $parsed21 );	

 $pdf->Ln(5);
 
  $html22='Asimismo, las partes están conscientes en que los acuerdos que se establecen en esta cláusula, tienen carácter de esenciales y que, por ende, el 
  contrato de uso de dependencias se ha celebrado en interés del ARRENDADOR en orden a usar la consulta en un horario determinado, 
  y del PROPIETARIO en tanto que haya atención de pacientes en los días y horarios convenidos.  ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html22),$parsed22 );
$pdf->MultiCell(169,6, $parsed22 );	

 $pdf->Ln(30);
 
 $html14=' ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html14),$parsedCatorce );
$pdf->MultiCell(169,6, $parsedCatorce );	

  $pdf->Ln(20);
 
   $html23='SEXTO: SERVICIOS QUE PRESTARÁ LA PROPIETARIO POR SI O POR TERCEROS EN SU NOMBRE.  ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html23),$parsed23 );
$pdf->MultiCell(169,6, $parsed23 );	

 $pdf->Ln(5);
 
 $html220='El PROPIETARIO, por si o por medio de una sociedad relacionada o a través de terceros contratados para tal efecto, se obliga a prestar al ARRENDADOR los siguientes servicios: ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html220),$parsed220 );
$pdf->MultiCell(169,6, $parsed220 );	

 $pdf->Ln(5);
 
 $html24='      -     Servicios de secretaría y recepción;  ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html24),$parsed24 );
$pdf->MultiCell(169,6, $parsed24 );	

 
 $html25='      -     Servicios de reserva de horas, confirmación y cancelación de consultas médicas por    ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html25),$parsed25 );
$pdf->MultiCell(169,6, $parsed25 );	

$html26='            intermedio diversas plataformas y canales ya sea presencial, telefónico, vía internet u otros';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html26),$parsed26 );
$pdf->MultiCell(169,6, $parsed26 );	

$html27='            que el PROPIETARIO estime conveniente.   ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html27),$parsed27 );
$pdf->MultiCell(169,6, $parsed27 );

 $html28='      -     Servicios de recaudación de valores referidos a los servicios prestados en las dependencias';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html28),$parsed28 );
$pdf->MultiCell(169,6, $parsed28 );	

$html29='            del centro médico;';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html29),$parsed29 );
$pdf->MultiCell(169,6, $parsed29 );	

 $html30='      -     Servicios de estacionamiento para el vehículo del ARRENDADOR y de sus pacientes, en';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html30),$parsed30 );
$pdf->MultiCell(169,6, $parsed30 );	

$html31='            la medida que haya disponibilidad, en el mismo inmueble del PROPIETARIO,  ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html31),$parsed31 );
$pdf->MultiCell(169,6, $parsed31 );	

$html32='            y sin derecho a exclusividad respecto de un determinado sitio de estacionamiento;   ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html32),$parsed32 );
$pdf->MultiCell(169,6, $parsed32 );

$html33='      -     Central telefónica con anexo en la consulta del ARRENDADOR y telefonista que';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html33),$parsed33 );
$pdf->MultiCell(169,6, $parsed33 );	

$html34='            recepcione y derive llamadas o, en su caso, call center. El pago que se referirá    ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html34),$parsed34 );
$pdf->MultiCell(169,6, $parsed34 );	

$html35='            más adelante, por los servicios que se prestarán comprende sólo el derecho de hacer    ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html35),$parsed35 );
$pdf->MultiCell(169,6, $parsed35 );

$html36='            llamadas locales a teléfonos de red fija. Las llamadas de larga distancia, las llamadas ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html36),$parsed36 );
$pdf->MultiCell(169,6, $parsed36 );	

$html37='            a teléfonos celulares y las llamadas desde celulares que importen un cargo al receptor,';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html37),$parsed37 );
$pdf->MultiCell(169,6, $parsed37 );

$html38='            serán cobradas separadamente si, en su caso, estuvieren disponibles, lo que no constituye';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html38),$parsed38 );
$pdf->MultiCell(169,6, $parsed38 );	

$html39='            una obligación para el prestador de los servicios;    ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html39),$parsed39 );
$pdf->MultiCell(169,6, $parsed39 );

$html40='      -     Recetarios y Órdenes de exámenes de laboratorio e imagenología.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html40),$parsed40 );
$pdf->MultiCell(169,6, $parsed40 );	

$html41='      -     Delantal y credencial corporativos, que el ARRENDADOR se obliga a utilizar.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html41),$parsed41 );
$pdf->MultiCell(169,6, $parsed41 );	

$html42='      -     Recepción de pagos por concepto de consulta médica, ya sea en efectivo o con bonos, y     ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html42),$parsed42 );
$pdf->MultiCell(169,6, $parsed42 );	

$html43='            emisión de las respectivas boletas de venta de servicios de la Clínica a los pacientes por ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html43),$parsed43 );
$pdf->MultiCell(169,6, $parsed43 );	

$html44='            cada consulta.   ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html44),$parsed44 );
$pdf->MultiCell(169,6, $parsed44 );

$html45='      -     Disposición de distintos medios de pago para los pacientes para el pago de consulta médica     ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html45),$parsed45 );
$pdf->MultiCell(169,6, $parsed45 );	

$html46='            (efectivo, cheque, tarjetas de crédito, tarjetas de débito, tarjetas comercio y retail).';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html46),$parsed46 );
$pdf->MultiCell(169,6, $parsed46 );	

$html47='      -     Suministro de papelería, artículos de higiene y tocador para el uso habitual y normal de una      ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html47),$parsed47 );
$pdf->MultiCell(169,6, $parsed47 );	

$html48='            consulta; en calidad y cantidad definidos por la PROPIETARIO';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html48),$parsed48 );
$pdf->MultiCell(169,6, $parsed48 );	

$html49='      -     Servicios de aseo para la consulta y anexos.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html49),$parsed49 );
$pdf->MultiCell(169,6, $parsed49 );	

$html50='      -     Servicios de sala de espera para los pacientes del ARRENDADOR;';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html50),$parsed50 );
$pdf->MultiCell(169,6, $parsed50 );	

$html51='      -     Servicios de casino y cafetería para el ARRENDADOR y sus pacientes, todos los cuales     ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html51),$parsed51 );
$pdf->MultiCell(169,6, $parsed51 );	

$html52='            deberán pagar los consumos efectivos que realicen en el casino o cafetería referidos; ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html52),$parsed52 );
$pdf->MultiCell(169,6, $parsed52 );	

$html53='      -     Gastos de operación habitualmente llamados gastos comunes.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html53),$parsed53 );
$pdf->MultiCell(169,6, $parsed53 );	

 $pdf->Ln(5);
 
 $html54='      ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html54),$parsed54 );
$pdf->MultiCell(169,6, $parsed54 );	

 $pdf->Ln(5);
 
 $html55='SEPTIMO: SERVICIOS QUE PRESTARÁ EL ARRENDADOR.      ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html55),$parsed55 );
$pdf->MultiCell(169,6, $parsed55 );	

 $pdf->Ln(5);
 
 $html56='El ARRENDADOR, por su parte, acepta que las labores o actividades que se comprenden en todos y cada uno de los
 referidos servicios no podrían ser ejecutadas sino por vía del PROPIETARIO, de manera que en ningún caso podrá el ARRENDADOR ejercerlos, 
 contratarlos, o asumirlos por si mismo o por terceros contratados directamente por él.     ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html56),$parsed56 );
$pdf->MultiCell(169,6, $parsed56 );	

 $pdf->Ln(5);
 
  $html57='El ARRENDADOR deberá desempeñar su ejercicio sujeto a las normas y exigencias que defina el PROPIETARIO, 
  las que constan y detallan en el "Reglamento de Funcionamiento del Centro Médico", reglamento que el ARRENDADOR declara conocer y desde luego acepta cumplir en todas y cada una de sus partes.     ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html57),$parsed57 );
$pdf->MultiCell(169,6, $parsed57 );	

 $pdf->Ln(5);
 
 $html58='El ARRENDADOR se obliga a aceptar y utilizar los sistemas informáticos que el PROPIETARIO disponga para la administración tanto de reservas de horas, 
 correo electrónico, intranet, y toda la información clínica del paciente ya sea histórica como la generada en su consulta, todo lo cual es de propiedad de Clínica Chillán S.A., empresa controladora de Inmobiliaria Collín S.A.    ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html58),$parsed58 );
$pdf->MultiCell(169,6, $parsed58 );	

 $pdf->Ln(5);
 
  $html59='De acuerdo a la normativa vigente, se establece la prohibición de realizar procedimientos médicos diagnósticos o terapéuticos invasivos de cualquier naturaleza dentro del box de consulta.
  El PROPIETARIO dispondrá de una sala de procedimientos especialmente habilitada para tal efecto, cuyo uso en cuanto a horarios y tipo o modalidades de procedimientos médicos a realizar está supeditado
  a condiciones técnico asistenciales y  comerciales adicionales a este Contrato.    ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html59),$parsed59 );
$pdf->MultiCell(169,6, $parsed59 );	

 $pdf->Ln(5);
 
   $html60='Por otro lado se deja expresa constancia que el ARRENDADOR es quien deberá emitir directamente licencias electrónicas desde su box,
   para lo cual el PROPIETARIO habilitará y gestionará el equipamiento necesario para su implementación. Así también y de acuerdo a la normativa legal vigente, 
   el ARRENDADOR es quien deberá informar directamente a sus pacientes si la confirmación diagnóstica de la patología tratante está incorporada en las Garantías Explícitas en Salud (GES) y 
   gestionar personalmente la notificación respectiva mediante el Formulario de Constancia al Paciente GES. Misma situación para el CAEC.    ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html60),$parsed60 );
$pdf->MultiCell(169,6, $parsed60 );	

 $pdf->Ln(5);
 
  $html61='   ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html61),$parsed61 );
$pdf->MultiCell(169,6, $parsed61 );	

 $pdf->Ln(50);
 
 $html62='El ARRENDADOR declara aceptar la modalidad de convenios paquetizados para las todas prestaciones que la Clínica formalice, ya sea en el momento de la firma de este Contrato así como en el futuro, con todas las instituciones previsionales de salud que adhieran a este tipo de convenios.   ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html62),$parsed62 );
$pdf->MultiCell(169,6, $parsed62 );	

 $pdf->Ln(5);
 
 $html63='El ARRENDADOR tendrá la disponibilidad de participar en las distintas actividades y programas de apoyo a la labor asistencial y dispuestas por el PROPIETARIO tales como: reuniones de coordinación; charlas y seminarios; actividades apoyo al programa plan mamá; participación en medios de comunicación, entre otros.   ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html63),$parsed63 );
$pdf->MultiCell(169,6, $parsed63 );	

 $pdf->Ln(5);
 
 $html64='El objeto esencial de dichas normas será la mantención de altos estándares de ética, calidad de atención, eficiencia y homogeneidad en la entrega de los servicios de salud que se prestarán en el Centro Médico en el cual la consulta está inserta.   ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html64),$parsed64 );
$pdf->MultiCell(169,6, $parsed64 );	

 $pdf->Ln(5);
 
 $html65='OCTAVO: DE LA POLITICA DE ATENCIONES Y SOBRECUPOS EN LOS HORARIOS CONVENIDOS.   ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html65),$parsed65 );
$pdf->MultiCell(169,6, $parsed65 );	

 $pdf->Ln(5);
 
 $html66='El PROPIETARIO establecerá en conjunto con el ARRENDADOR la cantidad promedio de consultas por hora, 
 así como la cantidad de sobrecupos autorizados a realizar por día. Cualquier modificación que sobrepase el 30% de 
 esta definición por más de 5 días en un mes será objeto de una reevaluación del Contrato por ambas partes, con el objeto de 
 garantizar un buen servicio ya sea mediante el criterio de ampliar las horas de arriendo u otra alternativa a considerar.   ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html66),$parsed66 );
$pdf->MultiCell(169,6, $parsed66 );	

 $pdf->Ln(5);
 
 $html67='NOVENO: DEL VALOR DE ARRIENDO.   ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html67),$parsed67 );
$pdf->MultiCell(169,6, $parsed67 );	

 $pdf->Ln(5);
 
 $html68='El honorario que percibirá Inmobiliaria Collín S.A. por la prestación de los servicios anteriormente referidos se reúne en el concepto de “Gastos Operacionales”, cuyo cálculo final es $'.utf8_decode($valor_arriendo).' y se deriva de las siguientes condiciones:   ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html68),$parsed68 );
$pdf->MultiCell(169,6, $parsed68 );	

 $pdf->Ln(5);
 
 $html69='      -     Si el arriendo formalizado en este convenio totaliza menos de 6 horas semanales, el valor de      ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html69),$parsed69 );
$pdf->MultiCell(169,6, $parsed69 );	

$html70='            los Gastos Operacionales mensuales se calcularán en base a $14.000 la hora + IVA. ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html70),$parsed70 );
$pdf->MultiCell(169,6, $parsed70 );	

 $html71='      -     Si el arriendo formalizado en este convenio totaliza 6 o más horas semanales, el valor de los       ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html71),$parsed71 );
$pdf->MultiCell(169,6, $parsed71 );	

$html72='            Gastos Operacionales mensuales se calcularán en base al 10% del total facturado por el  ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html72),$parsed72 );
$pdf->MultiCell(169,6, $parsed72 );	

$html73='            ARRENDADOR en el período, con un tope mínimo de $100.000 (valores con IVA   ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html73),$parsed73 );
$pdf->MultiCell(169,6, $parsed73 );	

$html74='            incluido).   ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html74),$parsed74 );
$pdf->MultiCell(169,6, $parsed74 );	

 $pdf->Ln(55);
 
 $html75='Las tarifas y valores expresados se reajustarán anualmente de acuerdo a las políticas comerciales del PROPIETARIO a partir de 1 de 
 Enero de cada año. Los nuevos valores serán publicados por el PROPIETARIO durante el mes de noviembre de cada año.    ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html75),$parsed75 );
$pdf->MultiCell(169,6, $parsed75 );	

$pdf->Ln(5);
 
 $html76='El costo de las llamadas telefónicas de larga distancia, 
 hacia celulares y/o desde celulares que irroguen cargo al receptor de la llamada y que hayan sido hecho o recibidos desde 
 el anexo instalado en la consulta del ARRENDADOR, serán facturados separadamente y deberán ser pagados por el ARRENDADOR el
 último día del mes siguiente a aquel en que se efectuaron. El ARRENDADOR contará con una clave de acceso que le permitirá hacer 
 este tipo de llamadas, en caso de estar disponibles. Las llamadas hechas al amparo de la clave aludida, serán pagadas directamente por el ARRENDADOR, siendo de su responsabilidad el mal uso de la misma.    ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html76),$parsed76 );
$pdf->MultiCell(169,6, $parsed76 );	

$pdf->Ln(5);
 
 $html77='DECIMO: DE LA GESTION DE COBROS Y PAGOS.   ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html77),$parsed77 );
$pdf->MultiCell(169,6, $parsed77 );	

$pdf->Ln(5);
 
 $html78='El Centro Médico recibirá bonos y emitirá boletas propias a los pacientes por todas las prestaciones realizadas durante cada mes, al término del cual se emitirá un Informe de Pago al ARRENDADOR que contendrá el detalle de los pagos recibidos por sus consultas.  ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html78),$parsed78 );
$pdf->MultiCell(169,6, $parsed78 );	

$pdf->Ln(5);
 
 $html79='Entre el 1 y 10 de cada mes el ARRENDADOR tendrá plazo para hacer llegar su boleta por el valor indicado en dicho informe. Los pagos serán realizados el día 25 del mes siguiente de la producción informada. Las boletas que sean recepcionadas posteriormente al día 10 serán liquidadas al mes subsiguiente de producción.  ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html79),$parsed79 );
$pdf->MultiCell(169,6, $parsed79 );	

$pdf->Ln(5);
 
 $html80='DECIMO PRIMERO: TÉRMINO ANTICIPADO DEL CONTRATO.  ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html80),$parsed80 );
$pdf->MultiCell(169,6, $parsed80 );	

$pdf->Ln(5);
 
 $html81='El PROPIETARIO tendrá derecho a poner término anticipado al contrato de uso de dependencias y,  por ende, a exigir la inmediata restitución de los bienes comprendidos en el contrato de uso de dependencias en los siguientes casos:  ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html81),$parsed81 );
$pdf->MultiCell(169,6, $parsed81 );	

$pdf->Ln(5);
 
 $html82='      a)     Por fallecimiento del ARRENDADOR si este fuere persona natural o de disolución de la      ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html82),$parsed82 );
$pdf->MultiCell(169,6, $parsed82 );	

$html83='              sociedad si fuere una persona jurídica; ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html83),$parsed83 );
$pdf->MultiCell(169,6, $parsed83 );	

$html84='      b)     Por notoria insolvencia del ARRENDADOR, la que se constatará por la falta de pago de los       ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html84),$parsed84 );
$pdf->MultiCell(169,6, $parsed84 );	

$html85='              servicios contratados, por la declaración de quiebra, por la presentación de proposiciones de  ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html85),$parsed85 );
$pdf->MultiCell(169,6, $parsed85 );	

$html86='              convenio, por la notificación de demandas en el recinto en que está el inmueble objeto del   ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html86),$parsed86 );
$pdf->MultiCell(169,6, $parsed86 );	

$html87='              contrato de uso de dependencias; por la traba de embargos en el mismo recinto o por otras   ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html87),$parsed87 );
$pdf->MultiCell(169,6, $parsed87 );	

$html88='              señas o indicadores similares;  ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html88),$parsed88 );
$pdf->MultiCell(169,6, $parsed88 );	

$pdf->Ln(55);

$html89=' ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html89),$parsed89 );
$pdf->MultiCell(169,6, $parsed89 );	


$html90='      c)     Por violaciones o contravenciones a la ética médica, las que serán determinadas por el Comité';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html90),$parsed90 );
$pdf->MultiCell(169,6, $parsed90 );	

$html91='              de Ética de Clínica Chillán S.A. o, a falta de éste, por inactividad o no constitución, por el   ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html91),$parsed91 );
$pdf->MultiCell(169,6, $parsed91 );	

$html92='              Director Médico de la misma clínica o por el Gerente de la misma, a falta de decisión del    ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html92),$parsed92 );
$pdf->MultiCell(169,6, $parsed92 );	

$html93='              Comité de Ética o del Director Médico. Las contradicciones entre el Comité de Ética y el    ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html93),$parsed93 );
$pdf->MultiCell(169,6, $parsed93 );	

$html94='              Director Médico, o entre éstos y el Gerente, serán resueltos por el Directorio de la sociedad; ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html94),$parsed94 );
$pdf->MultiCell(169,6, $parsed94 );	

$html95='      d)     Por violaciones o contravenciones a los estándares, normas y procedimientos tanto técnicos ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html95),$parsed95 );
$pdf->MultiCell(169,6, $parsed95 );	

$html96='              como administrativos definidos por el Ministerio de Salud, Superintendencia de Salud y    ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html96),$parsed96 );
$pdf->MultiCell(169,6, $parsed96 );	

$html97='              Fondo Nacional de Salud, así como por las Normas, Reglamentos Protocolos y Manuales de    ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html97),$parsed97 );
$pdf->MultiCell(169,6, $parsed97 );	

$html98='              Procedimientos , tanto técnicos como administrativos institucionales propios de Clínica     ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html98),$parsed98 );
$pdf->MultiCell(169,6, $parsed98 );	

$html99='              Chillán S.A. y del Centro Médico, mismos que declara obran en su conocimiento; ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html99),$parsed99 );
$pdf->MultiCell(169,6, $parsed99 );	

$html100='      e)     Por la ejecución de intervenciones o la operación de equipos de exámenes o de diagnóstico en ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html100),$parsed100 );
$pdf->MultiCell(169,6, $parsed100 );	

$html101='              el recinto de la consulta que ha recibido sin conocimiento y autorización del director médico     ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html101),$parsed101 );
$pdf->MultiCell(169,6, $parsed101 );	

$html102='              y del gerente de Clínica Chillán S.A.;    ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html102),$parsed102 );
$pdf->MultiCell(169,6, $parsed102 );

$html103='      f)     Por el no pago, mora o retardo en el pago de los servicios contratados. Se entenderá que hay ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html103),$parsed103 );
$pdf->MultiCell(169,6, $parsed103 );	

$html104='              retardo cuando en dos o más meses consecutivos o no, dentro de un año, el pago de los      ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html104),$parsed104 );
$pdf->MultiCell(169,6, $parsed104 );	

$html105='              servicios se hubiere hecho con más de tres días de demora respecto de la fecha en que debió';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html105),$parsed105 );
$pdf->MultiCell(169,6, $parsed105 );

$html106='              hacerse de acuerdo a este contrato;';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html106),$parsed106 );
$pdf->MultiCell(169,6, $parsed106 );

$html107='      g)     En los casos en que no se cumpla cabal y totalmente el servicio que motiva el contrato de uso  ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html107),$parsed107 );
$pdf->MultiCell(169,6, $parsed107 );	

$html108='              de dependencias. Se entenderá que se ha dejado de cumplir el servicio cuando en dos     ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html108),$parsed108 );
$pdf->MultiCell(169,6, $parsed108 );	

$html109='              semanas, consecutivas o no, el ARRENDADOR no concurre a atender pacientes en los ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html109),$parsed109 );
$pdf->MultiCell(169,6, $parsed109 );

$html110='              horarios o días estipulados, durante dos días cada semana o, también, cuando no concurre un ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html110),$parsed110 );
$pdf->MultiCell(169,6, $parsed110 );

$html111='              total de cuatro días consecutivos o no, en un mismo mes calendario, a menos que tenga para  ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html111),$parsed111 );
$pdf->MultiCell(169,6, $parsed111 );

$html112='              ello causa justificada, la que será calificada por el director médico o por el gerente de la  ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html112),$parsed112 );
$pdf->MultiCell(169,6, $parsed112 );

$html113='              sociedad; ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html113),$parsed113 );
$pdf->MultiCell(169,6, $parsed113 );

$html114='      h)     Por incumplimiento de las normas contenidas en el Reglamento de Operaciones y   ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html114),$parsed114 );
$pdf->MultiCell(169,6, $parsed114 );	

$html115='              Funcionamiento del Centro Médico de Clínica  Chillán S.A.;     ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html115),$parsed115 );
$pdf->MultiCell(169,6, $parsed115 );	

$html116='      i)     En todos los casos en que hubiere incumplimiento del presente contrato.    ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html116),$parsed116 );
$pdf->MultiCell(169,6, $parsed116 );

$pdf->Ln(5);

$html117='DECIMO SEGUNDO: MANTENCIÓN BIENES ENTREGADOS.  ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html117),$parsed117 );
$pdf->MultiCell(169,6, $parsed117 );

$pdf->Ln(5);

$html118='Será de cargo del ARRENDADOR la mantención y conservación de los bienes objeto del contrato de uso de dependencias, obligándose a conservar el inmueble y los 
muebles comprendidos en el contrato en perfecto estado, a mantener en perfecto estado de funcionamiento las llaves de los artefactos, enchufes, timbres e interruptores de instalación eléctrica y otros.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html118),$parsed118 );
$pdf->MultiCell(169,6, $parsed118 );

$pdf->Ln(55);

$html119='DECIMO TERCERO: ARRENDAMIENTO Y CESIÓN DE CONTRATO.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html119),$parsed119 );
$pdf->MultiCell(169,6, $parsed119 );

$pdf->Ln(5);

$html120='Será de cargo del ARRENDADOR la mantención y conservación de los bienes objeto del contrato de uso de dependencias, obligándose a conservar el inmueble y los 
muebles comprendidos en el contrato en perfecto estado, a mantener en perfecto estado de funcionamiento las llaves de los artefactos, enchufes, timbres e interruptores de instalación eléctrica y otros.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html120),$parsed120 );
$pdf->MultiCell(169,6, $parsed120 );

$pdf->Ln(5);

$html121='El ARRENDADOR no podrá arrendar o entregar en arriendo a terceros, sea  todo o en parte, el inmueble objeto del presente contrato.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html121),$parsed121 );
$pdf->MultiCell(169,6, $parsed121 );

$pdf->Ln(5);

$html122='Por otra parte, el ARRENDADOR no podrá ceder o transferir bajo ningún título los derechos y obligaciones que emanan del presente contrato, ni el contrato mismo o parte de él.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html122),$parsed122 );
$pdf->MultiCell(169,6, $parsed122 );

$pdf->Ln(5);

$html123='El ARRENDADOR  no podrá compartir la consulta objeto del contrato de uso de dependencias con otros médicos o profesionales de la salud, a menos que cuente con la aprobación previa y por escrito del PROPIETARIO. En todo caso y para todos los efectos, la figura de subarriendo se encuentra prohibida para el ARRENDADOR.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html123),$parsed123 );
$pdf->MultiCell(169,6, $parsed123 );

$pdf->Ln(5);

$html124='El PROPIETARIO podrá entregar en arriendo la misma consulta a otros ARRENDATARIOS con tal que no se perturben en días y horas que corresponden al ARRENDADOR que ha concurrido al presente contrato. ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html124),$parsed124 );
$pdf->MultiCell(169,6, $parsed124 );

$pdf->Ln(5);

$html125='DECIMO CUARTO: MEJORAS.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html125),$parsed125 );
$pdf->MultiCell(169,6, $parsed125 );

$pdf->Ln(5);

$html126='Las mejoras que introduzca el ARRENDADOR quedarán para beneficio del inmueble al término del contrato, sin derecho a indemnización. Sin embargo  no se podrán introducir mejoras o cambios de ninguna naturaleza al inmueble, a menos que el ARRENDADOR cuente para ello con autorización expresa del PROPIETARIO la que en todo caso deberá constar por escrito. ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html126),$parsed126 );
$pdf->MultiCell(169,6, $parsed126 );

$pdf->Ln(5);

$html127='DECIMO QUINTO: CASO FORTUITO O FUERZA MAYOR.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html127),$parsed127 );
$pdf->MultiCell(169,6, $parsed127 );

$pdf->Ln(5);

$html128='Las partes dejan expresa constancia de que el PROPIETARIO no responderá de manera alguna por los perjuicios que pudieran experimentar los bienes o pertenencias del ARRENDADOR en caso de robo, incendios, inundaciones, filtraciones, roturas de cañerías, efectos de la humedad o calor, accidentes y cualquier otro caso fortuito o de fuerza mayor. ';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html128),$parsed128 );
$pdf->MultiCell(169,6, $parsed128 );

$pdf->Ln(55);

$html129='DECIMO SEXTO: CUMPLIMIENTO PROMESAS.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html129),$parsed129 );
$pdf->MultiCell(169,6, $parsed129 );

$pdf->Ln(5);

$html130='Con la suscripción de este contrato de contrato de uso de dependencias las partes dan por cumplida cualquier promesa suscrita respecto del inmueble a que se refiere este contrato, respecto de cuyas obligaciones se otorgan el más amplio, completo y mutuo finiquito.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html130),$parsed130 );
$pdf->MultiCell(169,6, $parsed130 );

$pdf->Ln(5);

$html131='DECIMO SEPTIMO: DOMICILIO CONVENCIONAL.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html131),$parsed131 );
$pdf->MultiCell(169,6, $parsed131 );

$pdf->Ln(5);

$html132='Para todos los efectos de este contrato, las partes fijan domicilio especial en la comuna Chillán, prorrogando la competencia ante sus tribunales ordinarios de justicia.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html132),$parsed132 );
$pdf->MultiCell(169,6, $parsed132 );

$pdf->Ln(5);

$html133='DECIMO OCTAVO: EJEMPLARES.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html133),$parsed133 );
$pdf->MultiCell(169,6, $parsed133 );

$pdf->Ln(5);

$html134='El presente contrato se otorga 2 ejemplares originales del mismo tenor, quedando 1 en poder de cada una de las partes.';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html134),$parsed134 );
$pdf->MultiCell(169,6, $parsed134 );

$pdf->Ln(35);

$html135='                         INMOBILIARIA COLLIN S.A.                               ARRENDADOR';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html135),$parsed135 );
$pdf->MultiCell(169,6, $parsed135 );

$html136='                        Sr. Rodrigo Lemarie Barría                               '.utf8_decode(''.$nombre.'').'';

$pdf->SetFont('times','',11);
$pdf->WriteHTML(utf8_decode($html136),$parsed136 );
$pdf->MultiCell(169,6, $parsed136 );
		  
				
/*				

$pdf->Cell(40,10,'Hello World!');
*/
	$alAzar = rand(1000,100000);
	
	$especialidadExiste = $fecha.' convenio '.$alAzar.' '.$rut;
				
				
				
				$filename="".$especialidadExiste.".pdf";
				
				//$nivel = '8';
				
				$filenameDos="convenios/".$filename;
				//$pdf->Output($filename.'.pdf','F');
				

$pdf->Output($filenameDos, 'F');

$sql = 'INSERT INTO `pr_antecedente`( `id`,`rut_med`, `tipoAntecedente`, `nombreArchivo`, `fechaSubida`) VALUES (Null,"'.($rut).'","5","'.($filename ).'","'.(date('Y-m-d')).'")';
            $command = \Yii::$app->db->createCommand($sql);
            $command->execute();


 if($sql){
			     $message = "Convenio generado correctamente";
				echo "<script type='text/javascript'>alert('$message');</script>";
				// $link = "addConvenioMedico.php?PTD_RUT=$paciente";
				 $link = "convenios/$filename";
				 echo ("<script>location.href='$link'</script>");
				 
			}else{
				echo json_encode('Ocurrio un error intentelo nuevamente');
			  }




exit;
}

public function actionDeleteconvenio($id)
    {
		//unlink(getcwd().'/archivos/'.$model->nombreArchivo);
		//unlink(getcwd().'/uploads/'.$model->file_id.'/'.$fileModel->file_name.$fileModel->extension);
       @session_start();
	   $model = $this->findModel($id);
	   $rutDelProfesional = $model -> rut_med;
	   $nombreFile = $model -> nombreArchivo;
	   $rutSinEspacios=preg_replace('/\s+/', '', $rutDelProfesional);
	   unlink(getcwd().'/convenios/'.iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $nombreFile ));
	   
	           $this->findModel($id)->delete();
			   $_SESSION['deleteConvenio'] = $model;
			   
			   return $this->redirect(['pr-antecedente/convenios', 'rut_med' => $rutSinEspacios]);

    //    return $this->redirect(['pr-med/index']);
	   
		//echo $nombreFile;
		

    }	

    /**
     * Finds the PrAntecedente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PrAntecedente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PrAntecedente::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
