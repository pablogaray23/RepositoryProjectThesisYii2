<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\BoxAtencion */

$this->title = $model->id_boxAtencion;
$this->params['breadcrumbs'][] = ['label' => 'Box Atencions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box-atencion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_boxAtencion], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_boxAtencion], [
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
            'id_boxAtencion',
            'id_boxGeneral',
            'id_atn',
        ],
    ]) ?>

</div>
