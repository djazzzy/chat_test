<?php

use app\models\Messages;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сообщения';

//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="messages-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="messages">
        <?php foreach($messages as $mess): ?>
            <? $classes = '';
            if($mess->user->id == Yii::$app->user->identity->id){
                $classes .= ' am';
            }
            if($mess->user->role == User::ROLE_ADMIN){
                $classes .= ' admin';
            }
            if($mess->status == Messages::BLOCK_ON){
                $classes .= ' blocked';
            }
            ?>
            <div class="message-wrap <?= $classes?>">
                <div class="message-author"><?= Html::encode($mess->user->username);?></div>
                <div class="message-text"><?= Html::encode($mess->text) ;?></div>
<!--                    <div class="message-text">--><?//= \yii\helpers\HtmlPurifier::process($mess->text) ;?><!--</div>-->
                <div class="message-date"><?=date("d.m.Y H:i", strtotime($mess->date))?></div>
                <?php if($mess->status == Messages::BLOCK_OFF && Yii::$app->user->can('admin')): ?>
                <a href="<?=Url::toRoute(['admin/status', 'id' => $mess->id, 'status' => 1]) ?>" class="message-block">Блокировать</a>
                <?php elseif($mess->status == Messages::BLOCK_ON && Yii::$app->user->can('admin')): ?>
                <a href="<?=Url::toRoute(['admin/status', 'id' => $mess->id, 'status' => 0]) ?>" class="message-block">Разблокировать</a>
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