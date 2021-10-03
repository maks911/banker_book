<?php

namespace backend\controllers;

use app\models\form\KitchenForm;
use backend\models\AjaxSearch;
use backend\models\Kitchen;
use backend\models\Tag;
use Yii;
use yii\db\Exception;
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
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
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
    public function actionIndex(): string
    {
        $posts = Kitchen::find()->with('tags')->all();
        $this->view->params['searchModel'] = new AjaxSearch();
        return $this->render('index.twig', ['posts' => $posts]);
    }

    /**
     * Live search in left sidebar
     * @return array
     */
    public function actionSearch(): array
    {
        $search = Yii::$app->request->post('search') ? $this->getClearFIeld(Yii::$app->request->post('search')) : '';
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'data' => Kitchen::find()->where(['like', 'kitchen_name', "%$search%", false])->all(),
        ];
    }

    /**
     * Add Action Controller
     * @return string|Response
     * @throws Exception
     */
    public function actionAdd()
    {
        $modelForm = new KitchenForm();
        $modelTag = new Tag();
        $modelForm->kitchen = new Kitchen();
        $modelForm->kitchen->loadDefaultValues();
        $modelForm->setAttributes(Yii::$app->request->post());
        $tags = Yii::$app->request->post('Tag') ? explode(',', Yii::$app->request->post('Tag')['value']) : [];
        if (
            Yii::$app->request->post()
            && $modelForm->saveKitchensWithTags($modelForm->kitchen, $tags)
        ) {
            Yii::$app->session->setFlash('success', "You have successfully added the kitchen.");
            return $this->redirect(array('/admin'));
        }
        return $this->render('add.twig', ['model' => $modelForm, 'modelTag' => $modelTag]);
    }

    /**
     * Edit Action Controller
     * @param string $id
     * @return string|Response
     * @throws Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionEdit(string $id)
    {
        $modelForm = new KitchenForm();
        $modelForm->kitchen = Kitchen::find()->where(['id' => $id])->with('tags')->one();
        $tags = Yii::$app->request->post('Tag') ? explode(',', Yii::$app->request->post('Tag')['value']) : [];
        $modelForm->setAttributes(Yii::$app->request->post());
        if ($modelForm->kitchen) {
            $tagsValue = $this->tagsToString($modelForm->kitchen->tags);
            if (
                Yii::$app->request->post()
                && $modelForm->saveKitchensWIthTags($modelForm->kitchen, $tags)
            ) {
                Yii::$app->session->setFlash('success', "You have successfully updated the kitchen.");
                return $this->redirect(['/admin']);
            }
            return $this->render('edit.twig', ['model' => $modelForm->kitchen, 'tagsValue' => $tagsValue]);
        }
        throw new \yii\web\NotFoundHttpException();
    }

    /**
     * Converts array tags to string
     * @param array $tags
     * @return string
     */
    private function tagsToString(array $tags): string
    {
        $tagsValueArr = [];
        foreach ($tags as $tag) {
            $tagsValueArr[] = $tag->value;
        }
        return implode(",", $tagsValueArr);
    }

    /**
     * Delete Kitchen
     * @return array|false[]
     * @throws \Throwable
     */
    public function actionDelete()
    {
        $valid = $this->getClearFIeld(Yii::$app->request->post('valid'));
        if ($valid) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = Kitchen::find()->where(['id' => $this->getRequestData('id')])->one();
            try {
                if ($post->delete()) {
                    return [
                        'success' => true,
                        'data' => $post
                    ];
                }
            } catch (Exception $ex) {
                Yii::debug($ex->getMessage());
            }
        }

        return [
            'success' => false
        ];
    }

    /**
     * Help Function For get Post data
     * @param string $param
     * @return string
     */
    private function getRequestData(string $param): string
    {
        return Yii::$app->request->post($param) ? $this->getClearFIeld(Yii::$app->request->post($param)) : '';
    }

    /**
     * Help method to remove special characters from string and etc
     * @param string $field
     * @return string
     */
    private function getClearFIeld(string $field) : string
    {
        return trim(filter_var($field, FILTER_SANITIZE_STRING));
    }

    /**
     * Override security login
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        return true;
    }
}
