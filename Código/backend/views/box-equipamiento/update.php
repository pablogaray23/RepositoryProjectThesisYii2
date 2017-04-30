<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BoxEquipamiento */

$id = $model->id_box_equipamiento;
$this->title = 'Update Box Equipamiento: ' . $model->id_box_equipamiento;
$this->params['breadcrumbs'][] = ['label' => 'Box Equipamientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_box_equipamiento, 'url' => ['view', 'id' => $model->id_box_equipamiento]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box-equipamiento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'id'=>$id,
    ]) ?>

</div>
