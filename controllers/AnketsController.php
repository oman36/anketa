<?php

namespace app\controllers;

use app\models\Questions;
use app\models\UserAnswers;
use app\models\Ankets;
use app\models\Answers;
use Yii;
use app\models\AnketsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for Ankets model.
 */
class AnketsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($event)
    {

        if  (Yii::$app->user->can('admin')
            OR Yii::$app->controller->action->id === 'index'
            OR Yii::$app->controller->action->id === 'fill'
        ) {
            return parent::beforeAction($event);
        }else {
            return $this->goHome();
        }
    }

    /**
     * Lists all Ankets models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AnketsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Ankets models.
     * @return mixed
     */
    public function actionFill($name)
    {
        $user_id = Yii::$app->getUser()->id;
        Answers::setTableName("answers_{$name}");

        // $firstOne = впервые заполняется анкета
        $firstOne = true;
        if ($answers = Answers::findOne([
            'user_id' => $user_id,
        ])) {
            $firstOne = false;
        } else {
            $answers = new Answers();
        }

        $user_answers = new UserAnswers();

        // получем полное навзание и id анкеты по имени таблицы
        $params =  Ankets::getParamsByName($name);

        // если первый раз этим пользователем заполняется анкета, то
        // смотрим получается ли сохранить данные об этом
        $user_answers_add = $firstOne ? $user_answers->load([
                'no' => [
                    'user_id' => $user_id,
                    'ankets_id' => $params['id'],
                ]
            ],'no') && $user_answers->validate()
            : true;

        if ($answers->load(Yii::$app->request->post())
            && $answers->validate()
            && $user_answers_add
        ) {
            // если первый раз этим пользователем заполняется анкета, то
            // сохраняем данные об этом
            $firstOne ? $user_answers->save(false): null;

            $answers->save(false);

            Yii::$app->session->setFlash('fillSuccessful');
            return $this->render('fill', [
                'title' => $params['name'],
            ]);
        } else {
            return $this->render('fill', [
                'answers' => $answers,
                'fields' => $answers->getFields(),
                'title' => $params['name'],
            ]);
        }
    }

    /**
     * Displays a single Ankets model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $name = $model->table_name;
        Questions::setTableName("questions_{$name}");
        $questions = Questions::find()->select('question_text')->asArray()->column();
        return $this->render('view', [
            'questions' => $questions,
            'title' => $model->name,
        ]);
    }

    /**
     * Creates a new Ankets model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ankets();

        $postArray  = Yii::$app->request->post();

        // вручную засовываем ответы на вопрос в модель, если они есть
        $model->questions = isset($postArray['Ankets']['questions']) ?
            $postArray['Ankets']['questions'] : null;

        if ($model->load($postArray) && $model->save()) {
            Yii::$app->session->setFlash('addSuccessful');
            return $this->render('create');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Deletes an existing Ankets model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Ankets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Ankets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ankets::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Извените, но такой анкеты нет');
        }
    }
}
