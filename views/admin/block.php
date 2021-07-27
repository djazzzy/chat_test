<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Messages;
use app\components\toggle\ToggleColumn;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заблокированные сообщения';
$this->params['breadcrumbs'][] = ['label' => 'Админка', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="messages-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'user_id',
                'value'=>'user.username',
            ],
            'text',
            [
                'attribute' => 'date',
                'value' => function ($model, $key, $index, $widget) {
                    return date("d.m.Y H:i", strtotime($model->date));
                },
            ],
//            'status',
            [
                'class' => ToggleColumn::className(),
                'header' => 'Блокировать',
                'url' => ['toggle'],
                'attribute' => 'status',
                'format' => 'raw',
                'onValue' => Messages::BLOCK_ON,
                'contentOptions' => ['style' => 'text-align: center;width: 50px'],
            ],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>