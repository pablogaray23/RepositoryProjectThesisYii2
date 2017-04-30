<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BoxAtencion */

$this->title = 'Update Box Atencion: ' . $model->id_boxAtencion;
$this->params['breadcrumbs'][] = ['label' => 'Box Atencions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_boxAtencion, 'url' => ['view', 'id' => $model->id_boxAtencion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box-atencion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
