<?php

use yii\helpers\Html;
use backend\models\EspGen;


/* @var $this yii\web\View */
/* @var $model backend\models\EspAtn */

$this->title = EspGen::find()->where(['codigoEspecialidad'=>$esp])->one()->nombreEspecialidad;
$this->params['breadcrumbs'][] = ['label' => 'Esp Atns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="esp-atn-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'esp' => $esp,
    ]) ?>

</div>
