<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Inventory */

$this->title = 'Update Inventory: ' . ' ' . $model->id_inve;
$this->params['breadcrumbs'][] = ['label' => 'Inventories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_inve, 'url' => ['view', 'id' => $model->id_inve]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="inventory-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
