<?php

namespace backend\controllers;

use Yii;
use backend\models\EspGen;
use backend\models\EspGenSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use backend\models\EspAtn;
use backend\models\EspAtnSearch;

/**
 * EspGenController implements the CRUD actions for EspGen model.
 */
class EspGenController extends Controller
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
     * Lists all EspGen models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EspGenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		
		
		if(Yii::$app->request->post('hasEditable')){
			$idEspecialidad = Yii::$app->request->post('editableKey');
			$especialidades = EspGen::findOne($idEspecialidad);
			$out = Json::encode(['output' => '', 'message' => '']);
			$post = [];
			$posted = current($_POST['EspGen']);
			$post['EspGen'] = $posted;
			if($especialidades->load($post)){
				$especialidades->save();
				//return $this->redirect(['index']);
				//print_r($profesion->getErrors());
				
			}
			echo $out;
			return;
			
		}
		
		

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EspGen model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EspGen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EspGen();
		$modelEspAtn = new EspAtn();


        if ($model->load(Yii::$app->request->post())) {
			
			$mostrarRut = $model->nombreEspecialidad;
			//echo $mostrarRut;
			$exists = EspGen::find()->where([ 'nombreEspecialidad' => $mostrarRut])->exists();
			//echo $exists;
			
			if($exists!=null){
				
				//echo "existe";
				@session_start();
			$_SESSION['especialidadNoCreado'] = $mostrarRut;
			return $this->redirect(['index']);
			}else{
				//echo "no existe";
				$model->save();
				$modelEspAtn->load(Yii::$app->request->post());
				$modelEspAtn->id_esp_gen = $model->codigoEspecialidad;
				$modelEspAtn->id_atn_gen = 1;
				$modelEspAtn->save();
			@session_start();
			$_SESSION['especialidadCreado'] = $model;
			return $this->redirect(['index']);
				
			}
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EspGen model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            	@session_start();
			$_SESSION['especialidadActualizado'] = $model;
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EspGen model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EspGen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EspGen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EspGen::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
