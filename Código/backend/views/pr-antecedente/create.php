<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\PrEsp;
use backend\models\PrEspSearch;
use backend\models\PrAntecedente;
use backend\models\PrAntecedenteSearch;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\PrAntecedente */

$this->title = 'Subir Antecedentes Médicos';
$this->params['breadcrumbs'][] = ['label' => 'Pr Antecedentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pr-antecedente-create">



    <h2><center><font color="blue"><?= Html::encode($this->title) ?></font></center></h2>

    <?= $this->render('_form', [
        'model' => $model,
		'rut_med'=>$rut_med,
    ]) ?>

	
	

	
</div>
