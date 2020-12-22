<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MagazinesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Журналы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="magazines-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить журнал', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'description',
            [
                'attribute' => 'image',
                'value' => function ($model) {
                    return $model->getImageUrl();
                },
                'format' => ['image', ['width' => '100']],
            ],
            [
                'attribute' => 'authors',
                'value' => function ($model) {
                    $authors = $model->getAuthors();
                    $authorsString = '';
                    foreach ($authors as $author) {
                        $authorsString .= '<a href="/authors/view/'.$author->id.'">'.$author->surname.' '.$author->name.'</a><br />';
                    }
                    return $authorsString;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'date_add',
                'value' => function ($model) {
                    $date = new \DateTime($model->date_add);

                    if ($date->getTimestamp() < 0) {
                        return 'Не задано';
                    }

                    return $date->format('d.m.Y');
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
