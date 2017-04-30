<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EspGen */

$this->title = 'Update Esp Gen: ' . $model->codigoEspecialidad;
$this->params['breadcrumbs'][] = ['label' => 'Esp Gens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->codigoEspecialidad, 'url' => ['view', 'id' => $model->codigoEspecialidad]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="esp-gen-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
