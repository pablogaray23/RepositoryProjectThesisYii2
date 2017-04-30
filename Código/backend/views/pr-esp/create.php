<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PrEsp */

$this->title = 'Agregar Especialidad a Profesional Médico';
$this->params['breadcrumbs'][] = ['label' => 'Pr Esps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pr-esp-create">

   <h2><center><font color="blue"><u><?= Html::encode($this->title) ?></u></font></center></h2>

    <?= $this->render('_form', [
        'model' => $model,
		'id'=>$id,
    ]) ?>

</div>
