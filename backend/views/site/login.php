<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loginBox midPage">

    <div class="bigTitle">Efetue o login</div>

    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <?= $form->field($model, 'username',['labelOptions'=>['label'=>'Nome de Utilizador']])->textInput(array('placeholder' => 'Nome de utilizador')); ?>
        <?= $form->field($model, 'password',['labelOptions'=>['label'=>'Password']])->passwordInput(array('placeholder' => 'Password')) ?>

        <!-- <a href="#"><?php //echo Html::a('Recuperar password', ['user/request-password-reset']) ?></a> -->

        <?= $form->field($model, 'rememberMe',['labelOptions'=>['label'=>'Lembrar-me']])->checkbox() ?>
        <div class="form-group">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
