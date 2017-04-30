<?php

namespace app\controllers;
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\LoginForm;

use yii\rbac\DbManager;

use backend\models\UserPermisos;
use backend\models\UserAsignacion;
use backend\models\SignupForm;
use backend\models\AuthItem;
use backend\models\AuthAssignment;
use backend\models\PrMed;
use backend\models\PrMedSearch;
use backend\models\PrEspSearch;

use yii\base\DynamicModel;



/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'invitado','calendario'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
					[
                        'actions' => ['signup'],
                        'allow' => Yii::$app->user->can('Administrador Sistema'),
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
	public function actionSignup()
    {
		
        $model = new SignupForm();
		
		$modelPermiso = new DynamicModel([
			'permiso'	
		]);
		$modelPermiso->addRule(['permiso'], 'safe');
		
		$authItems = AuthItem::find()->all();
		
        if ($model->load(Yii::$app->request->post()) && $modelPermiso->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
				$newPermission=new AuthAssignment;
				$newPermission->user_id=$user->id;
				$newPermission->item_name=$modelPermiso->permiso;
				$newPermission->load(Yii::$app->request->post());
				$newPermission->save(false);//fuck coding regulations
                //if (Yii::$app->getUser()->login($user)){ 
                return $this->goHome();
                //}
            }
        }

        return $this->render('signup', [
            'model' => $model,
			'modelPermiso' => $modelPermiso,
			'authItems'=>$authItems,
        ]);
    }
	public function actionInvitado()
	{
		$searchModel = new PrMedSearch();
		$searchModelDos = new PrEspSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$modelE = $searchModelDos->search(Yii::$app->request->queryParams);

        return $this->render('invitado', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'modelE' => $modelE,
        ]);
	}
	public function actionCalendario($id)
	{
		return $this->render('calendario',
			[
				'id'=>$id,
			]
		);
	}
}
