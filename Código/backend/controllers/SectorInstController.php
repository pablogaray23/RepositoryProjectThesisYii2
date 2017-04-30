<?php

namespace backend\controllers;

use Yii;
use backend\models\SectorInst;
use backend\models\SectorInstSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * SectorInstController implements the CRUD actions for SectorInst model.
 */
class SectorInstController extends Controller
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
     * Lists all SectorInst models.
     * @return mixed
     */
    public function actionIndex($id_piso)
    {
        $searchModel = new SectorInstSearch();
       
		
		$dataProvider = $searchModel->search(['SectorInstSearch'=>['id_piso'=>$id_piso]]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'id_piso'=>$id_piso,
        ]);
		
    }
	
		public function actionLists($id)
	{
		$countSectores = SectorInst::find()
			->where (['id_piso' => $id])
			->count();
		$sectores = SectorInst::find()
			->where (['id_piso' => $id])
			->all();
		if($countSectores > 0)
		{
			foreach($sectores as $sector){
				echo "<option value='".$sector -> id_sector."' > ".$sector-> nombre_sector."</option>";				
			}
			
		}else{
			echo "<option> Piso sin sectores </option>";
		}
		
	}
	
	public function actionProd() {
    $out = [];
		if (isset($_POST['depdrop_parents'])) {
		$id = end($_POST['depdrop_parents']);
		$list = SectorInst::find()->select(' id_sector', 'nombre_sector ')->distinct(true)->andWhere(['id_piso'=>$id])->asArray()->all();
		$selected = null;
		if ($id != null && count($list) > 0) {
		$selected = '';
		foreach ($list as $i => $kota) {
		$kode=$kota['Shift'];
		$out[] = ['id' => $kota['id_sector']."|".$kota['nombre_sector'], 'name' => Funct::GROUPSHIT()[$kode] ];
		if ($i == 0) {
		$selected = $kota['id_sector']."|".$kota['nombre_sector'];
		}
		}
		// Shows how you can preselect a value
		echo Json::encode(['output' => $out, 'selected'=>$selected]);
		return;
		}
		} 
		echo Json::encode(['output' => '', 'selected'=>'']);
}

    /**
     * Displays a single SectorInst model.
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
     * Creates a new SectorInst model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
  
	
	
	    public function actionCreate($id_piso)
    {
        $model = new SectorInst();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['sector-inst/index', 'id_piso' => $model->id_piso]);		
        
	//	return $this->redirect(['piso-inst/index']);	
	//Html::a(' Ver Pisos ', ['piso-inst/index', 'id' => $p->id_edificio],  ['class' => 'btn btn-success']);
		
		
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
				'id_piso'=>$id_piso,
            ]);
        }
    }
	

    /**
     * Updates an existing SectorInst model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_sector]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SectorInst model.
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
     * Finds the SectorInst model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SectorInst the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SectorInst::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
