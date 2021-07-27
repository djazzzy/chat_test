<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сообщения';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="messages-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="messages">
        <?php foreach($messages as $mess): ?>
            <?php if($mess->user->id == Yii::$app->user->identity->id && $mess->user->login == 'admin'): ?>
                <div class="message-wrap am admin">
            <?php elseif($mess->user->id == Yii::$app->user->identity->id): ?>
                <div class="message-wrap am">
            <?php elseif($mess->user->login == 'admin'): ?>
                <div class="message-wrap admin">
            <?php elseif($mess->status == 1): ?>
                <div class="message-wrap blocked">
            <?php else: ?>
                <div class="message-wrap">
            <?php endif; ?>
                    <div class="message-author"><?=$mess->user->username;?></div>
                    <div class="message-text"><?=$mess->text;?></div>
                    <div class="message-date"><?=date("d.m.Y H:i", strtotime($mess->date))?></div>
                    <?php if($mess->status == 0 && Yii::$app->user->can('admin')): ?>
                    <a href="<?=Url::toRoute(['site/mblock', 'id' => $mess->id]) ?>" class="message-date">Блокировать</a>
                    <?php elseif($mess->status == 1 && Yii::$app->user->can('admin')): ?>
                    <a href="<?=Url::toRoute(['site/munblock', 'id' => $mess->id]) ?>" class="message-date">Разблокировать</a>
                    <?php endif; ?>
                </div>
        <?php endforeach; ?>
    </div>

    <div class="message-sticky">
    <?php if(Yii::$app->user->can('user')): ?>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    <?php else: ?>
        <div><a href="<?=Url::toRoute('site/login') ?>">Авторизируйтесь</a> чтобы писать сообщения</div>
    <?php endif; ?>
    </div>

</div>