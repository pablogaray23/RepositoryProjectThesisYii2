<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\PrMed;


$this->title = 'Sistema Gestión Horario Box';
?>
<div class="site-index">
	
    <div class="jumbotron">
        <h1> Menú Principal </h1>
	</div>
	<?php if (Yii::$app->user->can('Funcionario')){?>
    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
				<center><?= Html::a('<img src="imagenes/bot-medicos.png" width="35%" height="40%" />', ['pr-med/index']) ?></center>
				<p>&nbsp;</p>
            </div>
			<div class="col-lg-4">
                <center><?= Html::a('<img src="imagenes/bot-horarios.png" width="35%" height="40%" />', ['box-general/boxs']) ?></center>
				<p>&nbsp;</p>
            </div>
            <div class="col-lg-4">
				<center><?= Html::a('<img src="imagenes/bot-reporte.png" width="35%" height="40%" alt="My logo" />', ['event/index']) ?></center>
			<p>&nbsp;</p>
            </div>
        </div>
    </div>
	<?php } elseif (Yii::$app->user->can('Administrador Sistema')){
		
	} elseif (Yii::$app->user->can('Profesional')){
		$medico = PrMed::find()->where(['nombre_usuario'=>Yii::$app->user->identity->username])->one();
		return Yii::$app->response->redirect(Url::to(['pr-med/calendario','id'=>$medico->rut]));
	} ?>
</div>
