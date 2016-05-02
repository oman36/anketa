<?php

use yii\helpers\Html;
use app\assets\AnketaAsset;
/**
 * @var $this yii\web\View
 * @var $answers app\models\Answers
 * @var $fields array
 **/

AnketaAsset::register($this);
$this->title = $title;

$this->params['breadcrumbs'][] = ['label' => 'Анкеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="site-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php if (Yii::$app->session->hasFlash('fillSuccessful')): ?>
		<div class="alert alert-success">
			Анкета успешно заполнена.
		</div>
	<?php else: ?>
		<?= $this->render('_fill_form', [
			'answers' => $answers,
			'fields' => $fields
		]) ?>
	<?php endif; ?>

</div>
