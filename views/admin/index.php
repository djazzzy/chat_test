<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Админка';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="messages-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <a href="<?=Url::toRoute('admin/users') ?>" class="btn btn-success">Пользователи</a>
    <a href="<?=Url::toRoute('admin/block') ?>" class="btn btn-success">Заблокированные сообщения</a>

</div>