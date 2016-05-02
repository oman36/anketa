<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\AnketaAsset;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
AnketaAsset::register($this);
?>
<style>

</style>
<div class="site-index">
	<?php $form = ActiveForm::begin([
		'id' => 'anketa-form',
		//'options' => ['class' => 'form-horizontal'],
		'fieldConfig' => [
			'template' => "<div class=\"row\">{label}</div>" .
				"<div class=\"row\"><div class=\"col-lg-11\">{input}</div>" .
				"<div class=\"col-lg-1\"><button class=\"btn btn-danger remove\">-</button></div></div>" .
				"<div class=\"row\"><div class=\"col-lg-12\">{error}</div></div>",
			'labelOptions' => ['class' => 'col-lg-12 text-left control-label'],
		],
	]); ?>

	<?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

	<?= $form->field($model, 'table_name')->textInput() ?>

	<hr>
	<div id="questions">
		<?= $form->field($model, 'questions[]')->textInput()->label('Вопрос №<span>1</span>') ?>
	</div>
	<button id="add-field" class="btn btn-primary">Добавить вопрос</button>
	<hr/>
	<div class="text-center">

			<?= Html::submitButton('Создать', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>

	</div>



	<?php ActiveForm::end(); ?>
</div>
<script>

</script>
