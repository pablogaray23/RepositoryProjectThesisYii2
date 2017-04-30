<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\UploadedFile;

/* @var $this yii\web\View */
/* @var $model backend\models\PrAntecedente */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pr Antecedentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pr-antecedente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'rut_med',
            'tipoAntecedente',
             [
                'attribute'=>'nombreArchivo',
                'format' => 'html',
				//'value'=> '../../uploads/' . $model->nombreArchivo,
				//$data = 'C:/xampp/htdocs/basic/web/archivos'.''.$model->nombreArchivo,
				'value' => Html::a($model->nombreArchivo,Yii::$app->request->baseUrl. '/archivos/' . $model->nombreArchivo, ['target' => '_blank','class' => 'profile-link']),
				//'value' => Html::a($model->nombreArchivo, ['download', 'lala' => $model->nombreArchivo], ['target' => '_blank','class' => 'profile-link']),
				//'value' => Html::a('Download', ['sample-download', 'filename' =>$data ], ['target' => '_blank']),
				//'value' => Html::a(Yii::t('app', 'Remove Image'), Url::to['/user/deleteImage', 'id'=>$model->id], ['class' => 'btn btn-danger'] ),
            ],
        ],
    ]) ?>

</div>
