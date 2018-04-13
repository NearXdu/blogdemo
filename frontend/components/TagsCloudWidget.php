<?php
/**
 * Created by PhpStorm.
 * User: crlt_
 * Date: 2018/4/9
 * Time: 下午10:59
 */

namespace frontend\components;

use yii\base\Widget;
use yii\helpers\Html;

class TagsCloudWidget extends Widget
{
    public $tags;

    public function init()
    {
        parent::run();
    }

    public function run()
    {
        $tagString = '';
        $fontStyle = array(
            6 => "danger",
            5 => "info",
            4 => "warning",
            3 => "primary",
            2 => "success",
        );
        foreach ($this->tags as $tag => $weight) {
            $tagString .= '<a href="' . \Yii::$app->homeUrl . '?r=post/index&PostSearch[tags]='
                . $tag . '">' .
                ' <h' . $weight . ' style="display:inline-block;"><span class="label label-'
                . $fontStyle[$weight] . '">' . $tag . '</span></h' . $weight . '></a>';

        }
        return $tagString;
    }
}