<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\EdificioInst */

$this->title = $model->id_edificio;
$this->params['breadcrumbs'][] = ['label' => 'Edificio Insts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edificio-inst-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_edificio], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_edificio], [
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
            'id_edificio',
            'nombre_edificio',
        ],
    ]) ?>

</div>
