<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BoxGeneral */



$this->title = 'Crear Box de Atención';
$this->params['breadcrumbs'][] = ['label' => 'Box Generals', 'url' => ['box-general/index', 'id_sector' => $id_sector]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box-general-create">

    <h2><center><font color="blue"><?= Html::encode($this->title) ?></font></center></h2>

    <?= $this->render('_form', [
        'model' => $model,
		'modelE' => $modelE,
		'id_sector'=>$id_sector,
		
    ]) ?>

</div>
