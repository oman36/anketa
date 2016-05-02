<?php

namespace app\controllers;

use app\models\Ankets;
use app\models\Answers;
use app\models\UserAnswersSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class AnswersController extends Controller
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

        if  (Yii::$app->user->can('admin')) {
            return parent::beforeAction($event);
        }else {
            return $this->goHome();
        }
    }

    /**
     * Lists all Answers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserAnswersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Answer model.
     * @param int $id
     * @param string $name
     * @return mixed
     */
    public function actionView($id, $name)
    {
        return $this->render('view', [
            'model' => $this->findModel($name,$id),
            'title' => 'Просмотр ответа'
        ]);
    }

    /**
     * Deletes an existing Answers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $name
     * @param int $id
     * @return mixed
     */
    public function actionDelete($name,$id)
    {
        $this->findModel($name,$id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Ankets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $name
     * @param int $id
     * @return Ankets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($name,$id)
    {
        Answers::setTableName("answers_{$name}");
        if (($model = Answers::findOne(['user_id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Извените, но такой анкеты нет');
        }
    }
}
