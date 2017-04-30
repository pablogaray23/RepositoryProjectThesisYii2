<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PrEsp */

$this->title = $model->id_pr_esp;
$this->params['breadcrumbs'][] = ['label' => 'Pr Esps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pr-esp-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_pr_esp], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_pr_esp], [
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
            'id_pr_esp',
            'rut',
            'codigoEspecialidad',
            'institucion',
            'anio',
        ],
    ]) ?>

</div>
