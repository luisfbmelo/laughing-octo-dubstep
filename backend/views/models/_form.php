<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\models */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="models-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_model')->textInput() ?>

    <?= $form->field($model, 'modelName')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'brand_id')->textInput() ?>

    <?= $form->field($model, 'equip_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
