<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PrEsp */



$id = $model->id_pr_esp;
$this->title = 'Actualizar información de la especialidad : ' . $model->especialidad->nombreEspecialidad . ' del Prof Médico';
$this->params['breadcrumbs'][] = ['label' => 'Pr Esps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pr_esp, 'url' => ['view', 'id' => $model->id_pr_esp]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pr-esp-update">

<h2><center><font color="blue"><u><?= Html::encode($this->title) ?></u></font></center></h2>

    <?= $this->render('_form', [
        'model' => $model,
		'id'=>$id,
    ]) ?>

</div>
