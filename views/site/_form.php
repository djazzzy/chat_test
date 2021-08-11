<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Messages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="messages-form js-messages-form">

    <?php $form = ActiveForm::begin(); ?>

<!--    --><?//= $form->field($model, 'user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textInput(['maxlength' => true, 'class' => 'message-input'])->label('Ваше сообщение') ?>

    <?= $form->field($model, 'time')->textInput() ?>

<!--    --><?//= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
