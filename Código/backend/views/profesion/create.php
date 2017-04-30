<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Profesion */

$this->title = 'Crear Nueva Profesion';
$this->params['breadcrumbs'][] = ['label' => 'Profesions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profesion-create">

    <h1><center><u><font color="blue"><?= Html::encode($this->title) ?></font></u></center></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
