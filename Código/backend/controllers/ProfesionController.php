<?php

namespace backend\controllers;

use Yii;
use backend\models\Profesion;
use backend\models\ProfesionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * ProfesionController implements the CRUD actions for Profesion model.
 */
class ProfesionController extends Controller
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
     * Lists all Profesion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProfesionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
	
		

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profesion model.
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
     * Creates a new Profesion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Profesion();

        if ($model->load(Yii::$app->request->post()) ) {
			
				$mostrarRut = $model->nombre_profesion;
			//echo $mostrarRut;
			$exists = Profesion::find()->where([ 'nombre_profesion' => $mostrarRut])->exists();
			//echo $exists;
			
			if($exists!=null){
				
				//echo "existe";
				@session_start();
			$_SESSION['profesionNoCreado'] = $mostrarRut;
			return $this->redirect(['index']);
			}else{
				//echo "no existe";
				$model->save();
			@session_start();
			$_SESSION['profesionCreado'] = $model;
			return $this->redirect(['index']);
				
			}
			
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Profesion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			@session_start();
			$_SESSION['profesionActualizado'] = $model;
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Deletes an existing Profesion model.
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
     * Finds the Profesion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profesion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profesion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
