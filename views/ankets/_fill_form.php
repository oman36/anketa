<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $answers app\models\Answers
 * @var $form yii\widgets\ActiveForm
 * @var $fields array
 **/

?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'id' => 'fill-form',
        'fieldConfig' => [
            'template' => "<div class=\"row\">{label}</div>" .
                "<div class=\"row\"><div class=\"col-lg-12\">{input}</div></div>" .
                "<div class=\"row\"><div class=\"col-lg-12\">{error}</div></div>",
            'labelOptions' => ['class' => 'col-lg-12 text-left control-label'],
        ],
    ]); ?>

    <?php foreach($fields as $name => $field) {
        echo $form->field($answers, $name)->textInput();
    }
    ?>

    <div class="text-center">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-success', 'name' => 'send-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
