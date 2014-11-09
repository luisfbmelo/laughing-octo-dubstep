<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\equipaments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="equipaments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_equip')->textInput() ?>

    <?= $form->field($model, 'equipDesc')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
