<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PrMedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pr Meds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pr-med-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pr Med', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'rut',
            'nombre',
            'apellidoPaterno',
            'apellidoMaterno',
            'email:email',
            // 'telefono',
            // 'direccion',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
