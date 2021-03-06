<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Authors */

$this->title = $model->surname . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Авторы', 'url' => ['/authors']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="authors-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить автора?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
        ],
    ]) ?>

</div>
