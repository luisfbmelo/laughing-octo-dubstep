<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\brands */

$this->title = 'Update Brands: ' . ' ' . $model->id_brand;
$this->params['breadcrumbs'][] = ['label' => 'Brands', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_brand, 'url' => ['view', 'id' => $model->id_brand]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="brands-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
