<?php

namespace backend\controllers;

use Yii;
use backend\models\BoxAtencion;
use backend\models\BoxAtencionSearch;
use backend\models\BoxGeneral;
use backend\models\BoxGeneralSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BoxAtencionController implements the CRUD actions for BoxAtencion model.
 */
class BoxAtencionController extends Controller
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
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
					[
                        'actions' => ['signup'],
                        'allow' => Yii::$app->user->can('Administrador Sistema'),
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all BoxAtencion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BoxAtencionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BoxAtencion model.
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
     * Creates a new BoxAtencion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
		@session_destroy();
        $model = new BoxAtencion();

        if ($model->load(Yii::$app->request->post())) {
           // return $this->redirect(['view', 'id' => $model->id_boxAtencion]);
		   
		   	$mostrarCodAten = $model->id_atn;
			$mostrarCodBox = $model->id_boxGeneral;
			//echo $mostrarCodAten;
			//echo $mostrarCodBox;
			
			$box = BoxGeneral::findOne( $mostrarCodBox);
			$id_sector = $box->id_sector;
			//echo $id_sector;
			
			
			$exists = BoxAtencion::find()->where([ 'id_atn' => $mostrarCodAten])->andWhere(['id_boxGeneral' => $mostrarCodBox])->exists();
			//echo $exists;
			
			if($exists!=null){
				
				//echo "existe";
			@session_start();
			$_SESSION['atencionNoCreado'];
			return $this->redirect(['box-general/index', 'id_sector' => $id_sector]);	
			}else{
				//echo "no existe";
				$model->save();
			@session_start();
			$_SESSION['atencionCreado'] = $model;
			return $this->redirect(['box-general/index', 'id_sector' => $id_sector]);		
				
			}					   
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
				'id'=>$id,
            ]);
        }
    }

    /**
     * Updates an existing BoxAtencion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_boxAtencion]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BoxAtencion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		
		//imprimo el id y si lo imprimir
		echo $id;
		
		//ahora que ya se que existe el id, comenzare a buscar
		$model = $this->findModel($id);
		//primero busco el codigo del box
		$elBox = $model->id_boxGeneral;
		//imprimo el codigo del box
		echo $elBox;
		//ahora que ya tengo el codigo del box, puedo buscar el codigo del sector
		
		$box = BoxGeneral::findOne( $elBox);
			$id_sector = $box->id_sector;
			//imprimo el codigo del sector
			echo $id_sector;
			/*
		*/
		
		
        $model->delete();
		/*
		@session_start();
			$_SESSION['deleteAtencionBox'] ;
		*/

        return $this->redirect(['box-general/index', 'id_sector' => $id_sector]);	
    }

    /**
     * Finds the BoxAtencion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BoxAtencion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BoxAtencion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
