<?php

/*
 * This file is part of the 2amigos/yii2-grid-view-library project.
 * (c) 2amigOS! <http://2amigos.us/>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace app\components\toggle;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ToggleAction works in conjunction with ToggleColumn to ease the task to update the model.
 */
class ToggleAction extends Action
{
    public $modelClass;

    public $onValue = 0;

    public $offValue = 1;

    public function init()
    {
        if ($this->modelClass === null) {
            throw new InvalidConfigException('"modelClass" cannot be empty.');
        }
        parent::init();
    }

    /**
     * @inheritdoc
     * @throws \yii\web\BadRequestHttpException
     */
    public function run($key, $attribute)
    {
        if (Yii::$app->request->isAjax) {
            $model = $this->findModel($key);
            Yii::$app->response->format = Response::FORMAT_JSON;

            $model->setAttributes(
                [$attribute => $model->$attribute == $this->offValue ? $this->onValue : $this->offValue]
            );
            if ($model->validate() && $model->save(false, [$attribute])) {
                if($attribute == 'rlt'){
                    $model->updatePoint();
                }
                return ['result' => true, 'value' => ($model->$attribute == $this->onValue)];
            }

            return ['result' => false, 'errors' => $model->getErrors()];
        }
        throw new BadRequestHttpException(Yii::t('app', 'Invalid request'));
    }

    /**
     * Finds the model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  integer               $id
     * @throws NotFoundHttpException if the model cannot be found
     * @return \yii\db\ActiveRecord  the loaded model
     */
    protected function findModel($id)
    {
        $class = $this->modelClass;
        if ($id !== null && ($model = $class::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
