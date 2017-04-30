<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SectorInst */

$this->title = $model->id_sector;
$this->params['breadcrumbs'][] = ['label' => 'Sector Insts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sector-inst-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_sector], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_sector], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_sector',
            'nombre_sector',
            'id_piso',
        ],
    ]) ?>

</div>
