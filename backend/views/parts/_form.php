<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Parts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_part')->textInput() ?>

    <?= $form->field($model, 'partDesc')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($model, 'partCode')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($model, 'partPrice')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'partQuant')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
