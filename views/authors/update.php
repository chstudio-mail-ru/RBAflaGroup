<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Authors */

$this->title = 'Изменить Автора: ' . $model->surname . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Авторы', 'url' => ['/authors']];
$this->params['breadcrumbs'][] = ['label' => $model->surname . ' ' . $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="authors-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
