<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AnketsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\models\Ankets */

$this->title = 'Анкеты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (\Yii::$app->user->can('admin')): ?>
    <p>
        <?= Html::a('Добавить анкету', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Посмотреть ответы',Url::toRoute(['answers/index']),['class' => 'btn btn-primary']) ?>
    </p>
    <?php endif;?>

    <?php
        $columns =  [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'Номер',
                'contentOptions' =>[ 'style' => 'width:50px'],
                'headerOptions' =>[ 'style' => 'width:50px'],
            ],

            [
                'attribute' => 'name',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a($model->name,Url::toRoute(['ankets/fill', 'name' => $model->table_name ]));
                },
            ],
        ];
        \Yii::$app->user->can('admin') ?
        $columns[] = [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Действия',
            'contentOptions' =>[ 'style' => 'width:50px'],
            'headerOptions' =>[ 'style' => 'width:50px'],
            'template' => '{view} {delete}',
        ] : null;
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,

    ]); ?>
</div>
