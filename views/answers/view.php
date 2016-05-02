<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Answers */

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => 'Ответы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?> (<?=Html::encode($model->username) ?>)</h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => array_keys($model->getFields()),
    ]) ?>

</div>
