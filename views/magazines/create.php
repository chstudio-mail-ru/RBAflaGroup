<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Magazines */
/* @var $authors array */

$this->title = 'Добавить журнал';
$this->params['breadcrumbs'][] = ['label' => 'Журналы', 'url' => ['/magazines']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="magazines-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'authors' => $authors,
    ]) ?>

</div>
