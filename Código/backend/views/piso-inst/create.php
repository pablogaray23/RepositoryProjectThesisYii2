<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PisoInst */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Piso Insts', 'url' => ['piso-inst/index', 'id_edificio' => $id_edificio]];
$this->params['breadcrumbs'][] = $this->title;

/**/

?>
<div class="piso-inst-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'id_edificio'=>$id_edificio,
    ]) ?>

</div>
