<?php

namespace backend\controllers;

use Yii;
use backend\models\PisoInst;
use backend\models\PisoInstSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * PisoInstController implements the CRUD actions for PisoInst model.
 */
class PisoInstController extends Controller
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
     * Lists all PisoInst models.
     * @return mixed
     */
    public function actionIndex($id_edificio)
    {
		//$id_edificio=Yii::$app->request->post("id_edificio");
        $searchModel = new PisoInstSearch();
		$dataProvider = $searchModel->search(['PisoInstSearch'=>['id_edificio'=>$id_edificio]]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'id_edificio'=>$id_edificio,
        ]);
    }
	
	public function actionLists($id)
	{
		$countPisos = PisoInst::find()
			->where (['id_edificio' => $id])
			->count();
		$pisos = PisoInst::find()
			->where (['id_edificio' => $id])
			->all();
		if($countPisos > 0)
		{
			foreach($pisos as $piso){
				echo "<option value='".$piso -> id_piso."' > ".$piso-> nombre_piso."</option>";				
			}
			
		}else{
			echo "<option> Edificio sin pisos </option>";
		}
		
	}
	
	public function actionSubcat() {
    $out = [];
	echo isset($_POST['depdrop_parents']);
	
		if (isset($_POST['depdrop_parents'])) {
			echo "entra";
		$id = end($_POST['depdrop_parents']);
		$list = PisoInst::find()->select(' id_piso, nombre_piso ')->distinct(true)->andWhere(['id_edificio'=>$id])->asArray()->all();
		$selected = null;
		if ($id != null && count($list) > 0) {
		$selected = '';
		foreach ($list as $i => $kota) {
		$kode=$kota['Shift'];
		$out[] = ['id' => $kota['id_piso']."|".$kota['nombre_piso'], 'name' => Funct::GROUPSHIT()[$kode] ];
		if ($i == 0) {
		$selected = $kota['id_piso']."|".$kota['nombre_piso'];
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
     * Displays a single PisoInst model.
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
     * Creates a new PisoInst model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_edificio)
    {
        $model = new PisoInst();

        if ($model->load(Yii::$app->request->post())) {
            
			
			//$mostrarElEdificio = $model->id_edificio;
			$model->save();
			
	//	return $this->redirect(['piso-inst/index']);
	
	//Html::a(' Ver Pisos ', ['piso-inst/index', 'id' => $p->id_edificio],  ['class' => 'btn btn-success']);
		
		return $this->redirect(['piso-inst/index', 'id_edificio' => $model->id_edificio]);
			
			
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
				'id_edificio'=>$id_edificio,
            ]);
        }
    }

    /**
     * Updates an existing PisoInst model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_piso]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PisoInst model.
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
     * Finds the PisoInst model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PisoInst the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PisoInst::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
