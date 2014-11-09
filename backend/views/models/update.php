<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\models */

$this->title = 'Update Models: ' . ' ' . $model->id_model;
$this->params['breadcrumbs'][] = ['label' => 'Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_model, 'url' => ['view', 'id' => $model->id_model]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="models-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
