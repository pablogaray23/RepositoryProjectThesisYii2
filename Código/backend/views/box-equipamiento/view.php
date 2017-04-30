<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\BoxEquipamiento */

$this->title = $model->id_box_equipamiento;
$this->params['breadcrumbs'][] = ['label' => 'Box Equipamientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box-equipamiento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_box_equipamiento], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_box_equipamiento], [
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
            'id_box_equipamiento',
            'id_equipamiento',
            'id_box',
        ],
    ]) ?>

</div>
