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
        <?= $form->field($modelGroups, 'id_group', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->dropDownList($allGroups,['id'=>'groupId','prompt'=>'--'])->label('Privilégios')?>
    </div>

    <div class="row">
        <?= $form->field($modelStores, 'id_store', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->dropDownList($allStores,['id'=>'storeID','prompt'=>'--'])->label('Loja')?>
    </div>

    <div class="row form-group">
        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 pageButtons">
            <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span>', ['class' => 'btn btn-success col-lg-1', 'name' => 'update']) ?>
            <?= Html::submitButton('<span class="glyphicon glyphicon-remove"></span>',array('class'=>'btn btn-danger col-lg-1','name'=>'cancelar','id'=>'cancelar')); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>


