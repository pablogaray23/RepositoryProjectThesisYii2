<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->title = 'Actualizar evento: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id_event]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="event-update">

    <h1><?= Html::encode($this->title) ?></h1>
	
    <?= $this->render('_formUpdate', [
        'model' => $model,
		'modelIteraciones' => $modelIteraciones,
    ]) ?>

</div>
