<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Equipamiento */

$this->title = 'Update Equipamiento: ' . $model->id_equipamiento;
$this->params['breadcrumbs'][] = ['label' => 'Equipamientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_equipamiento, 'url' => ['view', 'id' => $model->id_equipamiento]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="equipamiento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
