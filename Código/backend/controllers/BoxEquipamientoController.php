<?php

namespace backend\controllers;

use Yii;
use backend\models\BoxEquipamiento;
use backend\models\BoxEquipamientoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BoxEquipamientoController implements the CRUD actions for BoxEquipamiento model.
 */
class BoxEquipamientoController extends Controller
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
     * Lists all BoxEquipamiento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BoxEquipamientoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BoxEquipamiento model.
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
     * Creates a new BoxEquipamiento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

		  public function actionCreate($id)
    {
		@session_destroy();
        $model = new BoxEquipamiento();

        if ($model->load(Yii::$app->request->post())) {
           // return $this->redirect(['view', 'id' => $model->id_boxAtencion]);
		   
		   	$mostrarCodAten = $model->id_equipamiento;
			$mostrarCodBox = $model->id_box;
			//echo $mostrarCodAten;
			//echo $mostrarCodBox;			
			//$box = BoxGeneral::findOne( $mostrarCodBox);
			//$id_sector = $box->id_sector;
			//echo $id_sector;		
			
			$exists = BoxEquipamiento::find()->where([ 'id_equipamiento' => $mostrarCodAten])->andWhere(['id_box' => $mostrarCodBox])->exists();
		if($exists!=null){
				
				//echo "existe";
			@session_start();
			$_SESSION['equipamientoNoCreado'] = $model;
			return $this->redirect(['box-general/view', 'id' => $id]);	
			}else{
				//echo "no existe";
				$model->save();
			@session_start();
			$_SESSION['equipamientoCreado'] = $model;
			return $this->redirect(['box-general/view', 'id' => $id]);	
				
			}					   
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
				'id'=>$id,
            ]);
        }
    }

    /**
     * Updates an existing BoxEquipamiento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
 
	
	public function actionUpdate($id)
    {
		@session_destroy();
		$model = $this->findModel($id);
	   $rutDelProfesional = $model -> id_box;
       // $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			
			$model->save();
			
			@session_start();
			$_SESSION['equipamientoActualizada'] = $model;
            //return $this->redirect(['view', 'id' => $model->id_pr_esp]);
			
			return $this->redirect(['box-general/view', 'id' => $rutDelProfesional]);
			
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BoxEquipamiento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
   public function actionDelete($id)
    {				
		@session_start();
		$model = $this->findModel($id);
	   $rutDelProfesional = $model -> id_box;
        $this->findModel($id)->delete();
		
		$_SESSION['deleteEquipamientoBox'] = $model;

        return $this->redirect(['box-general/view', 'id' => $rutDelProfesional]);
		
		
    }

    /**
     * Finds the BoxEquipamiento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BoxEquipamiento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BoxEquipamiento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
