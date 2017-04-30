<?php

namespace backend\controllers;

use Yii;
use backend\models\PrMed;
use backend\models\PrAntecedente;
use backend\models\PrMedSearch;
use backend\models\PrEsp;
use backend\models\PrEspSearch;
use backend\models\Event;
use backend\models\EventSearch;
use backend\models\BoxGeneral;
use backend\models\BoxGeneralSearch;
use backend\models\BoxAtencionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query;

/**
 * PrMedController implements the CRUD actions for PrMed model.
 */
class PrMedController extends Controller
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
                        'actions' => ['index','create','delete','update','view','horario'],
                        'allow' => Yii::$app->user->can('Funcionario'),
                    ],
					[
                        'actions' => ['calendario'],
                        'allow' => true,
					]
                ],
            ],
        ];
    }

    /**
     * Lists all PrMed models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrMedSearch();
		$searchModelDos = new PrEspSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$modelE = $searchModelDos->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'modelE' => $modelE,
        ]);
    }

    /**
     * Displays a single PrMed model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
		$model = PrMed::findOne($id);
		//$modelAuthor  = Author::findOne($key);
		
		  if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('kv-detail-success', 'Datos modificados correctamente');
            // Multiple alerts can be set like below
            return $this->redirect(['view', 'id'=>$id]);
        } else {
            return $this->render('view', ['model'=>$model]);
        }
		
		
		
    }

    /**
     * Creates a new PrMed model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		@session_destroy();
        $model = new PrMed();
		$modelE = new PrEsp();

		if ($model->load(Yii::$app->request->post())) {
            //return $this->redirect(['view', 'id' => $model->rut]);
			$mostrarRut = $model->rut;
			//echo $mostrarRut;
			$exists = PrMed::find()->where([ 'rut' => $mostrarRut])->exists();
			//echo $exists;
			
			if($exists!=null){
				
				//echo "existe";
				@session_start();
			$_SESSION['profesionalNoCreado'] = $mostrarRut;
			return $this->redirect(['index']);
			}else{
				//echo "no existe";
				$model->save();
			$modelE->load(Yii::$app->request->post());
			$modelE->rut = $model->rut;
			$modelE->save();
			@session_start();
			$_SESSION['profesionalCreado'] = $model;
			return $this->redirect(['index']);
				
			}
			
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
				'modelE' => $modelE
            ]);
        }
    }

    /**
     * Updates an existing PrMed model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->rut]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PrMed model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
		$this->findModel($id)->estado=1;

        return $this->redirect(['index']);
    }
	
	public function actionHorario($id)
	{

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
	}
	public function actionCalendario($id)
	{
		return $this->render('calendario',
			[
				'id'=>$id,
			]
		);
	}
    /**
     * Finds the PrMed model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PrMed the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PrMed::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
