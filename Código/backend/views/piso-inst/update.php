<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PisoInst */

$this->title = '' . $model->id_piso;
$this->params['breadcrumbs'][] = ['label' => 'Piso Insts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_piso, 'url' => ['view', 'id' => $model->id_piso]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="piso-inst-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
