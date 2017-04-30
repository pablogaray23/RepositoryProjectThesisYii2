<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PrMed */

$this->title = 'Agregar Nuevo Profesional Médico';
$this->params['breadcrumbs'][] = ['label' => 'Pr Meds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pr-med-create">

    <h2><center><font color="blue"><u><?= Html::encode($this->title) ?></u></font></center></h2>

    <?= $this->render('_form', [
        'model' => $model,
		'modelE' => $modelE,
    ]) ?>

</div>
