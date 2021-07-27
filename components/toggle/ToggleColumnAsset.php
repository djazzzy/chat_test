<?php

namespace app\components\toggle;

use yii\web\AssetBundle;

/**
 * EditableAddressAsset
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\editable
 */
class ToggleColumnAsset extends AssetBundle
{
    public $sourcePath = '@app/components/toggle/assets';

    public $css = [
        'switcher.css'
    ];

    public $js = [
        'jquery.switcher.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
