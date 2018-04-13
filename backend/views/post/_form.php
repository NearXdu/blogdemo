<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\models\Poststatus;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>
    <?php
    //    $status=Poststatus::find()->all();
    //    $arrMap=ArrayHelper::map($status,'id','name');
    //    $status=Yii::$app->db->createCommand('select id,name from poststatus')->queryAll();
    //    $arrMap=ArrayHelper::map($status,'id','name');
    $arrStatus = (new \yii\db\Query())
        ->select('name,id')
        ->from('poststatus')
        ->indexBy('id')
        ->column();
    ?>

    <?= $form->field($model, 'status')->dropDownList($arrStatus,
        ['prompt' => '请选择状态']); ?>


    <?php
    $authors = \common\models\Adminuser::find()->all();
    $arrAuthors = ArrayHelper::map($authors, 'id', 'nickname');

    ?>

    <?= $form->field($model, 'author_id')->dropDownList($arrAuthors, ['prompt' => '请选择作者']) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
