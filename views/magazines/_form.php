<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Magazines */
/* @var $authors array */
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

    <?php
        echo '<div class="form-group field-magazines-authors required'.((!empty($model->errors) && isset($model->errors['authors']))? ' has-error' : null ).'">';
        echo '<label class="control-label" for="magazines-authors">Авторы</label>';
        echo Select2::widget([
            'model' => $model,
            'attribute' => 'authors',
            'data' => $authors,
            'options' => ['placeholder' => 'Выберите авторов', 'multiple' => true,  'aria-required' => true, 'aria-invalid' => (!empty($model->errors) && isset($model->errors['authors']))],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        if (!empty($model->errors) && isset($model->errors['authors'])) {
            $errorText = $model->errors['authors'][0];
            echo '<div class="help-block">'.$errorText.'</div>';
        }
        echo '</div>';
    ?>

    <?= $form->field($model, 'date_add')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'ru',
        'dateFormat' => 'php:d.m.Y',
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
