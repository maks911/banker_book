<?php

namespace backend\controllers;

use backend\models\AjaxSearch;
use common\models\LoginForm;
use backend\models\Kitchen;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class AdminController extends Controller
{
    public $layout = 'main.twig';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $posts = Kitchen::find()->all();
        $this->view->params['searchModel'] = new AjaxSearch();
        return $this->render('index.twig', ['posts' => $posts]);
    }

    public function actionSearch(): array
    {
        $request = Yii::$app->request;
        $search = trim(htmlspecialchars($request->post('search')));
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'data' => Kitchen::find()->where(['like', 'kitchen_name', "%$search%", false])->all(),
        ];
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        return $this->render('index');
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    //override security login
    public function beforeAction($action)
    {
        return true;
    }
}
