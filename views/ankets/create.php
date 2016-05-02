<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\AnketaAsset;
/**
 * @var $this yii\web\View
 * @var $model app\models\Ankets;
 */

AnketaAsset::register($this);

$this->title = 'Создание анкеты';
$this->params['breadcrumbs'][] = ['label' => 'Анкеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="site-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php if (Yii::$app->session->hasFlash('addSuccessful')): ?>
		<div class="alert alert-success">
			Анкета успешно сохранена.
		</div>
	<?php else: ?>
		<?= $this->render('_create_form', [
			'model' => $model,
		]) ?>
	<?php endif; ?>

</div>
