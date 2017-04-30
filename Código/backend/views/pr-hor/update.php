<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PrHor */

$this->title = 'Update Pr Hor: ' . $model->id_pr_horario;
$this->params['breadcrumbs'][] = ['label' => 'Pr Hors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pr_horario, 'url' => ['view', 'id' => $model->id_pr_horario]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pr-hor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
