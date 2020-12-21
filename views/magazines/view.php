<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Magazines */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Журналы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
if ($model->date_add != '' && $model->date_add != '0000-00-00 00:00:00') {
    $model->date_add = date('d.m.Y', strtotime($model->date_add));
} else {
    $model->date_add = '';
}
?>
<div class="magazines-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить журнал?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description',
            [
                'attribute' => 'image',
                'value' => $model->image,
                'format' => ['image', ['width' => '100']],
            ],
            'date_add',
        ],
    ]) ?>

</div>
