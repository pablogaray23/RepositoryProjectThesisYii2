<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PisoInst */

$this->title = $model->id_piso;
$this->params['breadcrumbs'][] = ['label' => 'Piso Insts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="piso-inst-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_piso], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_piso], [
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
            'id_piso',
            'nombre_piso',
            'id_edificio',
        ],
    ]) ?>

</div>
