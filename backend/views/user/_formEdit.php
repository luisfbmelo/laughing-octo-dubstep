<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clearAll"></div>

    <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

    <div class="row">
        <?= $form->field($model, 'username',['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->label('Nome de utilizador') ?>
    </div>

    <div class="row">
        <?= $form->field($model, 'email',['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->label('E-mail') ?>
    </div>

    <div class="row">
        <?= $form->field($modelSignup, 'password',['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->passwordInput()->label('Password') ?>
    </div>
    <div class="row">
        <?= $form->field($modelSignup, 'password_repeat',['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->passwordInput()->label('Confirme a password') ?>
    </div>

    <div class="row">
        <?= $form->field($modelGroups, 'id_group', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->dropDownList($allGroups,['id'=>'groupId','prompt'=>'--'])->label('Previlégios')?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span>', ['class' => 'btn btn-success', 'name' => 'update']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-remove"></span>',array('class'=>'btn btn-danger','name'=>'cancelar','id'=>'cancelar')); ?>
    </div>

    <?php ActiveForm::end(); ?>


