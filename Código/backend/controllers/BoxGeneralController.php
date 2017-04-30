<?php

namespace backend\controllers;

use Yii;
use backend\models\BoxGeneral;
use backend\models\BoxGeneralSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\BoxAtencion;
use backend\models\BoxAtencionSearch;
use backend\models\PisoInst;
use backend\models\SectorInst;
use backend\models\Event;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use backend\models\PrMed;

use yii\helpers\Json;


/**
 * BoxGeneralController implements the CRUD actions for BoxGeneral model.
 */
class BoxGeneralController extends Controller
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
     * Lists all BoxGeneral models.
     * @return mixed
     */
    public function actionIndex($id_sector)
    {
        $searchModel = new BoxGeneralSearch();
		$searchModelDos = new BoxAtencionSearch();
		
		// $searchModel = BoxGeneralSearch::findOne($id_sector);

		
		$dataProvider = $searchModel->search(['BoxGeneralSearch'=>['id_sector'=>$id_sector]]);
		
		$modelE = $searchModelDos->search(Yii::$app->request->queryParams);
		
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->pagination->pageSize=5000;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'modelE' => $modelE,
			'id_sector'=>$id_sector,
        ]);
    }
	
	public function actionBoxs()
    {

        $searchModel = new BoxGeneralSearch();
		$searchModelDos = new BoxAtencionSearch();
		
		// $searchModel = BoxGeneralSearch::findOne($id_sector);

		$modelE = $searchModelDos->search(Yii::$app->request->queryParams);
		
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->pagination->pageSize=5000;
		
			return $this->render('boxs', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'modelE' => $modelE,
			]);
		
    }
	public function actionMisBoxs() //No se usa ya. Se deja para reciclar codigo.
    {
		$medico = PrMed::find()->where(['nombre_usuario'=>Yii::$app->user->identity->username])->one();
		$misEventos = Event::find()->where(['rut_profesional'=>$medico->rut])->all();
		
		$dataProvider = new Query();
		$dataProvider->select('id_box,nombre_box')->from('box_general');
		//$searchModelDos = new BoxAtencionSearch();
		$boxsMedico = new BoxGeneralSearch();
		
		$boxsMedico = Event::find()->where(['rut_profesional' => $id])->groupBy('id_box')->all();
		
		//$dataProvider->where(['id_box'=>'1']);
		foreach($boxsMedico as $box){
			
			$dataProvider->orWhere(['id_box'=>$box->id_box]);
			
		}
		$rows = $dataProvider->all();
		
		return $this->render('horario', [
			'lista' => $rows,
		]);
		
        $dataProvider = new ActiveDataProvider([
			'query' => $misEventos,
			'pagination' => [
			'pageSize' => 10,
			],
			'sort' => [
				'defaultOrder' => [
				'created_at' => SORT_DESC,
				'title' => SORT_ASC, 
			]
		],
	]);
		/*
		foreach($misEventos as $evento){
			$dataProviders[] = new ArrayDataProvider([
				'allModels' => $evento,
				'sort' =>['attributes' => ['id_box'],],
				'pagination' => ['pageSize' => 100]
			]);
		}
		*/
		
		// $searchModel = BoxGeneralSearch::findOne($id_sector);

		
		
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//$dataProvider->pagination->pageSize=5000;
		
			return $this->render('mis-boxs', [
				//'searchModel' => $searchModel,
				'misEventos' => $misEventos,
				
			]);
		
    }

    /**
     * Displays a single BoxGeneral model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
	public function actionHorario($id)
	{
		$model = $this->findModel($id);
		return $this->render('horario',['model'=>$model,]);
	}
	public function actionMishorarios($id,$rut)
	{
		$model = $this->findModel($id);
		return $this->render('mis-horarios',['model'=>$model,'rut'=>$rut]);
	}
    /**
     * Creates a new BoxGeneral model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

	
	   public function actionCreate($id_sector)
    {
        $model = new BoxGeneral();
		$modelE = new BoxAtencion();
		

        if ($model->load(Yii::$app->request->post())) {            
			
			$mostrarElEdificio = $model->id_sector;
			$mostrarElRut = $model->nombre_box;
			//echo $mostrarElRut;
			if ($model->field!='' && $model->campo!=''){
				$campo = $model->campo;
				$field = $model->field;
				//echo $field;
				
				for($i = $campo; $i <= $field; $i++) {
					if($i<10){
						$guardar = $mostrarElRut.'0'.$i;
					}else{
						$guardar = $mostrarElRut.''.$i;
					}				
				//echo $guardar;
				//echo "<br/>";
					try{
						$model2 = new BoxGeneral();
						$model2->load(Yii::$app->request->post());
						$model2->nombre_box=''.$guardar;			 
						$model2->save();
						
						$modelE->load(Yii::$app->request->post());
						$model3 = new BoxAtencion();
						$model3->load(Yii::$app->request->post());
						 
						$model3->id_boxGeneral = $model2->id_box;
						$model3->save();
					}catch(\Exception $e){
						@session_start();
						$_SESSION['existeBox']=1;
					}
				}
			} else {
				try{
					$model->save();
					$atencion = new BoxAtencion();
					$atencion->load(Yii::$app->request->post());
					
					$atencion->id_boxGeneral = $model->id_box;
					$atencion->save();
				}catch(\Exception $e){
					@session_start();
					$_SESSION['existeBox']=1;
				}
			}
			return $this->redirect(['box-general/index', 'id_sector' => $model->id_sector]);
		//	return $this->redirect(['piso-inst/index']);	
		//Html::a(' Ver Pisos ', ['piso-inst/index', 'id' => $p->id_edificio],  ['class' => 'btn btn-success']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
				'modelE' => $modelE,
				'id_sector'=>$id_sector,
				
            ]);
        }
    }

    /**
     * Updates an existing BoxGeneral model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			/*
			$mostrarElEdificio = $model->id_sector;
			$mostrarElRut = $model->nombre_box;
			$model2 = new BoxGeneral();
            $model2->load(Yii::$app->request->post());
             $model2->nombre_box=$mostrarElRut;		
			$model2->id_sector=$mostrarElEdificio;	
			*/
			 $model->save(false);
			//echo $mostrarElEdificio;
			//echo $mostrarElRut;
			
            return $this->redirect(['box-general/index', 'id_sector' => $model->id_sector]);	
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BoxGeneral model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionSelPiso()
	{
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				
				$id_edificio = $parents[0];
				$out = PisoInst::find()->select(['id_piso AS id','nombre_piso AS name'])->andWhere(['id_edificio'=>$id_edificio])->asArray()->all();
				// the getSubCatList function will query the database based on the
				// cat_id and return an array like below:
				// [
				//    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
				//    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
				// ]
				
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}	
	}
	
	public function actionSelSector()
	{
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			$id_edificio = empty($parents[0]) ? null : $parents[0];
			$id_piso = empty($parents[1]) ? null : $parents[1];
			if ($id_piso != null) {

				$out = SectorInst::find()->select(['id_sector AS id','nombre_sector AS name'])->andWhere(['id_piso'=>$id_piso])->asArray()->all();			
				echo Json::encode(['output'=>$out, 'selected'=>'']);
				return;
			}
		}	
	}
	
    /**
     * Finds the BoxGeneral model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BoxGeneral the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BoxGeneral::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
}
