<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\SignupForm */
/* @var $form ActiveForm */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="signup">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-control-sm'],
    ]); ?>

        <?= $form->field($model, 'login')->textInput([
            'template' => '<div class="form-group">
                      <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>'
        ]) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password2')->passwordInput() ?>
        <?= $form->field($model, 'username') ?>

        <div class="form-group">
            <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

    <?php
    if($model->scenario === 'emailActivation'):
        ?>
        <i>*На указанный емайл будет отправлено письмо для активации аккаунта.</i>
    <?php
    endif;
    ?>

</div><!-- signup -->
