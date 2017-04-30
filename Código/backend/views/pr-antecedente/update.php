<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PrAntecedente */

$this->title = 'Update Pr Antecedente: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pr Antecedentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pr-antecedente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
