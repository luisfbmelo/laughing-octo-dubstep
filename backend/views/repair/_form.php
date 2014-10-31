<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\repair */
/* @var $form yii\widgets\ActiveForm */
?>


        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'type_id', ['options' => ['class' => 'col-lg-6']])->textInput() ?>

        <?= $form->field($model, 'client_id', ['options' => ['class' => 'col-lg-6']])->textInput() ?>

        <?= $form->field($model, 'inve_id', ['options' => ['class' => 'col-lg-6']])->textInput() ?>

        <?= $form->field($model, 'status', ['options' => ['class' => 'col-lg-6']])->textInput(['maxlength' => 45]) ?>

        <?= $form->field($model, 'user_id', ['options' => ['class' => 'col-lg-12']])->textInput() ?>

        <?= $form->field($model, 'repair_desc', ['options' => ['class' => 'col-lg-12']])->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'date_entry', ['options' => ['class' => 'col-lg-6']])->textInput() ?>

        <?= $form->field($model, 'date_close', ['options' => ['class' => 'col-lg-6']])->textInput() ?>

        <?= $form->field($model, 'store_id', ['options' => ['class' => 'col-lg-6']])->textInput() ?>

        <?= $form->field($model, 'priority', ['options' => ['class' => 'col-lg-6']])->textInput() ?>

        <?= $form->field($model, 'budget', ['options' => ['class' => 'col-lg-6']])->textInput(['maxlength' => 10]) ?>

        <?= $form->field($model, 'maxBudget', ['options' => ['class' => 'col-lg-6']])->textInput(['maxlength' => 10]) ?>

        <?= $form->field($model, 'total', ['options' => ['class' => 'col-lg-6']])->textInput(['maxlength' => 10]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success col-lg-12' : 'btn btn-primary col-lg-12']) ?>
        </div>

        <?php ActiveForm::end(); ?>
