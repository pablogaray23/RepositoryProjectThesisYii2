<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EdificioInst */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Edificio Insts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_edificio, 'url' => ['view', 'id' => $model->id_edificio]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="edificio-inst-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
