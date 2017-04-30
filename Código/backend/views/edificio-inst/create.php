<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\EdificioInst */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Edificio Insts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edificio-inst-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
