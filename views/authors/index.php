<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AuthorsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $fail boolean */

$this->title = 'Авторы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="authors-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить Автора', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'surname',
            'name',
            'patronymic',
            [
                'attribute' => 'magazines',
                'value' => function ($model) {
                    $magazines = $model->getMagazines();
                    $magazinesString = '';
                    foreach ($magazines as $magazine) {
                        $magazinesString .= '<a href="/magazines/view/'.$magazine->id.'">'.$magazine->name.'</a><br />';
                    }
                    return $magazinesString;
                },
                'format' => 'raw',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

    <?php
    if ($fail) {
    ?>
    <div class="form-group  has-error">
        <div class="help-block">Невозможно удалить автора, т.к. он является автором существующих журналов</div>
    </div>
    <?php
    }
    ?>

</div>
