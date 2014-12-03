<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\InventorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_inve') ?>

    <?= $form->field($model, 'equip_id') ?>

    <?= $form->field($model, 'brand_id') ?>

    <?= $form->field($model, 'model_id') ?>

    <?= $form->field($model, 'inveSN') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
