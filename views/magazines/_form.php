<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Magazines */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="magazines-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php
        if (file_exists('uploads/'.md5($model->id).'.jpg')) {
            echo '<img src="/uploads/'.md5($model->id).'.jpg" width="100" />';
        } elseif (file_exists('uploads/'.md5($model->id).'.png')) {
            echo '<img src="/uploads/'.md5($model->id).'.png" width="100" />';
        }
    ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <?= $form->field($model, 'date_add')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'ru',
        'dateFormat' => 'php:d.m.Y',
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
