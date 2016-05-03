<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserAnswersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\models\UserAnswers */

$this->title = 'Ответы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <p>
        <?= Html::a('< К анкетам',Url::toRoute(['ankets/index']),['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            [
                'attribute' => 'userName',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a(
                        $model->getUserName(),
                        Url::toRoute([
                        'user/view',
                        'id' => $model->user_id,
                    ]));
                },
            ],
            [
                'attribute' => 'anketsName',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a(
                        $model->getAnketsName(),
                        Url::toRoute([
                            'ankets/view',
                            'id' => $model->ankets_id,
                        ])
                    );
                },
            ],
            [
                'header' => 'Ответы',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a(
                        'Смотреть',
                        Url::toRoute([
                            'answers/view',
                            'id' => $model->user_id,
                            'name' => $model->ankets->table_name,
                        ]),
                        [
                            'class' => 'btn btn-info',
                        ]
                    );
                },
                'headerOptions' => ['style'=> ['width' => '60px']]
            ],
        ],

    ]); ?>
</div>
