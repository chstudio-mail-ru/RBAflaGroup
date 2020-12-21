<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Magazines */

$this->title = 'Изменить журнал: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Журналы', 'url' => ['/magazines']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="magazines-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
