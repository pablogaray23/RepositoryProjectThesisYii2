<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SectorInst */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Piso Insts', 'url' => ['sector-inst/index', 'id_piso' => $id_piso]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sector-inst-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'id_piso'=>$id_piso,
    ]) ?>

</div>
