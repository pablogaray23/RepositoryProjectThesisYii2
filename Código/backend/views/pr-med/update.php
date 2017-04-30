<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PrMed */

$this->title = 'Update Pr Med: ' . $model->rut;
$this->params['breadcrumbs'][] = ['label' => 'Pr Meds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rut, 'url' => ['view', 'id' => $model->rut]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pr-med-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
