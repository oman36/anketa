<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $questions string[] */

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => 'Анкеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="list-group">
        <?php foreach ($questions as $question) {
            echo "<li class='list-group-item'>{$question}</li>";
        }
        ?>
    </ul>

</div>
