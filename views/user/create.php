<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->session->hasFlash('regSuccessful')): ?>
    <div class="alert alert-success">
        Регистрация прошла успешно.
    </div>
    <?php else: ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    <?php endif; ?>
</div>
