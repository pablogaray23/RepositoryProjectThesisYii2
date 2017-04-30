<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Equipamiento */

$this->title = 'Create Equipamiento';
$this->params['breadcrumbs'][] = ['label' => 'Equipamientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipamiento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
