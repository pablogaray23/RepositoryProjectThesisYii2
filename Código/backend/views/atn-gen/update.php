<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AtnGen */

$this->title = 'Update Atn Gen: ' . $model->id_atencion;
$this->params['breadcrumbs'][] = ['label' => 'Atn Gens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_atencion, 'url' => ['view', 'id' => $model->id_atencion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="atn-gen-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
