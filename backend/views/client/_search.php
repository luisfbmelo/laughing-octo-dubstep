<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\client */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_client') ?>

    <?= $form->field($model, 'cliName') ?>

    <?= $form->field($model, 'cliAdress') ?>

    <?= $form->field($model, 'cliPostalCode') ?>

    <?= $form->field($model, 'cliPostalSuffix') ?>

    <?php // echo $form->field($model, 'cliDoorNum') ?>

    <?php // echo $form->field($model, 'cliCC') ?>

    <?php // echo $form->field($model, 'cliNIF') ?>

    <?php // echo $form->field($model, 'cliConFix') ?>

    <?php // echo $form->field($model, 'cliConMov1') ?>

    <?php // echo $form->field($model, 'cliConMov2') ?>

    <?php // echo $form->field($model, 'cliBirthday') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
