<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SectorInst */

$this->title = 'Update Sector Inst: ' . $model->id_sector;
$this->params['breadcrumbs'][] = ['label' => 'Sector Insts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_sector, 'url' => ['view', 'id' => $model->id_sector]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sector-inst-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
