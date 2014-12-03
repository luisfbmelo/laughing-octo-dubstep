<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Inventory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'equip_id')->textInput() ?>

    <?= $form->field($model, 'brand_id')->textInput() ?>

    <?= $form->field($model, 'model_id')->textInput() ?>

    <?= $form->field($model, 'inveSN')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
