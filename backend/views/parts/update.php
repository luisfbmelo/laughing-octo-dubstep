<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Parts */

$this->title = 'Update Parts: ' . ' ' . $model->id_part;
$this->params['breadcrumbs'][] = ['label' => 'Parts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_part, 'url' => ['view', 'id' => $model->id_part]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="parts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
