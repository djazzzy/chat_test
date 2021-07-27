<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property string $user_id
 * @property string $text
 * @property string $date
 * @property int $status
 */
class Messages extends \yii\db\ActiveRecord
{

    const BLOCK_OFF = 0;
    const BLOCK_ON = 1;

    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'text'], 'required'],
            [['date'], 'safe'],
            [['status','user_id'], 'integer'],
            [['text'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'text' => 'Сообщение',
            'date' => 'Date',
            'status' => 'Status',
        ];
    }

    public function saveMessage(){
        $this->user_id = Yii::$app->user->identity->id;
        return $this->save();
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
