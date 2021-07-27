<?php

namespace app\controllers;

use app\models\SignupForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Messages;
use app\models\User;


class SiteController extends BehaviorsController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'toggle' => [
                'class' => \app\components\toggle\ToggleAction::className(),
                'modelClass' => Messages::className(),
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        if (Yii::$app->user->can('admin')) {
            $messages = Messages::find()->with(['user'])->all();
        } else {
            $messages = Messages::find()->where(['status' => 0])->with(['user'])->all();
        }

        $model = new Messages();

        if ($model->load(Yii::$app->request->post()) && $model->saveMessage()) {
            return $this->redirect(['index', [
                'model' => $model,
                'messages' => $messages,
            ]]);
        }

        return $this->render('index', [
            'model' => $model,
            'messages' => $messages,
        ]);
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

//        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()):
            if ($user = $model->reg()):
                if (Yii::$app->getUser()->login($user)):
                    return $this->goHome();
                endif;
            else:
                Yii::$app->session->setFlash('error', 'Возникла ошибка при регистрации.');
                Yii::error('Ошибка при регистрации');
                return $this->refresh();
            endif;
        endif;

        return $this->render('signup', [
            'model' => $model
        ]);
    }

    public function actionMblock($id)
    {
        $model = Messages::find()->where(['id' => $id])->one();
        $model->status = 1;
        $model->save();
        return $this->goBack();
    }

    public function actionMunblock($id)
    {
        $model = Messages::find()->where(['id' => $id])->one();
        $model->status = 0;
        $model->save();
        return $this->goBack();
    }
}
