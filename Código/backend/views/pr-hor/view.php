<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PrHor */

$this->title = $model->id_pr_horario;
$this->params['breadcrumbs'][] = ['label' => 'Pr Hors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pr-hor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_pr_horario], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_pr_horario], [
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
            'id_pr_horario',
            'rut_profesional',
            'dia_semana',
            'hora_inicio',
            'hora_fin',
        ],
    ]) ?>

</div>
