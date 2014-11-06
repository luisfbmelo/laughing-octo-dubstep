<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cliName')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($model, 'cliAdress')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($model, 'cliPostalCode')->textInput() ?>

    <?= $form->field($model, 'cliPostalSuffix')->textInput() ?>

    <?= $form->field($model, 'cliDoorNum')->textInput() ?>

    <?= $form->field($model, 'cliCC')->textInput() ?>

    <?= $form->field($model, 'cliNIF')->textInput() ?>

    <?= $form->field($model, 'cliConFix')->textInput() ?>

    <?= $form->field($model, 'cliConMov1')->textInput() ?>

    <?= $form->field($model, 'cliConMov2')->textInput() ?>

    <?= $form->field($model, 'cliBirthday')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
