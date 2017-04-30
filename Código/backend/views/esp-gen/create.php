<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\EspGen */

$this->title = 'Agregar Nueva Especialidad';
$this->params['breadcrumbs'][] = ['label' => 'Esp Gens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="esp-gen-create">

    <h3><center><u><font color="blue"><?= Html::encode($this->title) ?></font></u></center></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
