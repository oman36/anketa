<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Ankets;

class SiteController extends Controller
{
    public function behaviors()
    {
        return ['access' => ['class' => AccessControl::className(), 'only' => ['logout'], 'rules' => [['actions' => ['logout'], 'allow' => true, 'roles' => ['@'],],],], 'verbs' => ['class' => VerbFilter::className(), 'actions' => ['logout' => ['post'],],],];
    }

    public function actions()
    {
        return ['error' => ['class' => 'yii\web\ErrorAction',], 'captcha' => ['class' => 'yii\captcha\CaptchaAction', 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,],];
    }

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(Url::toRoute('ankets/index'));
        }else {
            return $this->redirect(Url::toRoute('site/login'));
        }
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goBack();
        }
        return $this->render('login', ['model' => $model,]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
