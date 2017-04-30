<?php

namespace backend\controllers;

use Yii;
use backend\models\PrEsp;
use backend\models\PrEspSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PrEspController implements the CRUD actions for PrEsp model.
 */
class PrEspController extends Controller
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
     * Lists all PrEsp models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrEspSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PrEsp model.
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
     * Creates a new PrEsp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	
	    public function actionCreate($id)
    {
		@session_destroy();
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
			return $this->redirect(['pr-med/view', 'id' => $id]);
			}else{
				//echo "no existe";
				$model->save();
			@session_start();
			$_SESSION['especialidadCreado'] = $model;
			return $this->redirect(['pr-med/view', 'id' => $id]);
				
			}
			
			
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
				'id'=>$id,
            ]);
        }
    }
	

    /**
     * Updates an existing PrEsp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		@session_destroy();
		$model = $this->findModel($id);
	   $rutDelProfesional = $model -> rut;
       // $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			
			$model->save();
			
			@session_start();
			$_SESSION['especialidadActualizada'] = $model;
            //return $this->redirect(['view', 'id' => $model->id_pr_esp]);
			
			return $this->redirect(['pr-med/view', 'id' => $rutDelProfesional]);
			
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PrEsp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		@session_start();
		$model = $this->findModel($id);
	   $rutDelProfesional = $model -> rut;
        $this->findModel($id)->delete();
		
		$_SESSION['deletePrEsp'] = $model;

        return $this->redirect(['pr-med/view', 'id' => $rutDelProfesional]);
    }

    /**
     * Finds the PrEsp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PrEsp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PrEsp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
