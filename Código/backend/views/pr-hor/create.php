<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PrHor */

$this->title = 'Nuevo bloque';
$this->params['breadcrumbs'][] = ['label' => 'Pr Hors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pr-hor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
