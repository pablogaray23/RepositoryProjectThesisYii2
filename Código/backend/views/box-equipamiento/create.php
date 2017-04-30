<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BoxEquipamiento */

$this->title = 'Create Box Equipamiento';
$this->params['breadcrumbs'][] = ['label' => 'Box Equipamientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box-equipamiento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'id'=>$id,
    ]) ?>

</div>
