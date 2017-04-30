<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AtnGen */

$this->title = 'Create Atn Gen';
$this->params['breadcrumbs'][] = ['label' => 'Atn Gens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atn-gen-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
