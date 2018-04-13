<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $name
 * @property int $frequency
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 128],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'frequency' => 'Frequency',
        ];
    }

    public static function string2array($tags)
    {
        return preg_split('/\s*,\s*/', trim($tags), -1, PREG_SPLIT_NO_EMPTY);
    }

    public static function array2string($tags)
    {
        return implode(', ', $tags);
    }

    public static function addTags($tags)
    {
        if (empty($tags)) return;
        foreach ($tags as $name) {
            $aTag = Tag::find()->where(['name' => $name])->one();
            $aTagCount = Tag::find()->where(['name' => $name])->count();
            if (!$aTagCount) {
                $model = new Tag();
                $model->name = $name;
                $model->frequency = 1;
                $model->save();
            } else {
                $aTag->frequency += 1;
                $aTag->save();
            }
        }
    }

    public static function removeTags($tags)
    {

        if (empty($tags)) return;
        foreach ($tags as $name) {
            $aTag = Tag::find()->where(['name' => $name])->one();
            $aTagCount = Tag::find()->where(['name' => $name])->count();
            if ($aTagCount) {
                if ($aTagCount && $aTag->frequency <= 1) {
                    $aTag->delete();
                } else {
                    $aTag->frequency -= 1;
                    $aTag->save();
                }
            }
        }
    }

    public static function updateFrequency($oldTags, $newTags)
    {
        if (!empty($oldTags) || !empty($newTags)) {
            $oldTagArray = self::string2array($oldTags);
            $newTagArray = self::string2array($newTags);
            self::addTags(array_values(array_diff($newTagArray, $oldTagArray)));
            self::removeTags(array_values(array_diff($oldTagArray, $newTagArray)));
        }
    }

    public static function findTagWeights($limit = 20)
    {
        $tagLevel=5;//5个档次
        $models=Tag::find()->orderBy('frequency desc')->limit($limit)->all();
        $total=Tag::find()->limit($limit)->count();
        $stepper=ceil($total/$tagLevel);
        $tags=array();
        $counter=1;
        if($total>0){
            foreach($models as $model){
                $weight=ceil($counter/$stepper)+1;
                $tags[$model->name]=$weight;
                $counter++;
            }
            ksort($tags);
        }
        return $tags;
    }
}
