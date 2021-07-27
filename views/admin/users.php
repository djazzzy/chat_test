<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = ['label' => 'Админка', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'login',
            'username',
            'role',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{edit}',
                'buttons' => [
                    'edit' => function ($url) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-edit"> Редактировать</span><br>',
                            $url,
                            [
                                'title' => 'Редактировать',
                                'data-pjax' => '0',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>


</div>