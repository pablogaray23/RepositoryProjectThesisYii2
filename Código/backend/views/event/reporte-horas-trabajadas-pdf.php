<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use backend\models\Event;
use backend\models\BoxGeneral;
use backend\models\PrMed;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\data\SqlDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reportes';
$this->params['breadcrumbs'][] = $this->title;

?><center><h2>Total de horas trabajadas por cada profesional en la semana</h2></center><?php

		echo GridView::widget([
				'dataProvider' => $dataProvider,
				'columns' => [
					//['class' => 'yii\grid\SerialColumn'],

					'rut',
					[
						'value' => function($model){
							//var_dump($model);
							//die();
							$medico = PrMed::find()->where(['rut'=> $model])->asArray()->one();
							return $medico['nombre']." ".$medico['apellidoPaterno']." ".$medico['apellidoMaterno'];
						},
						'label' => 'Nombre',
					],
					[
						'value' => 'horas',
						'label' => 'Total de Horas'
					]
				],
				
			]);
		
	
