<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SearchParts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_part') ?>

    <?= $form->field($model, 'partDesc') ?>

    <?= $form->field($model, 'partCode') ?>

    <?= $form->field($model, 'partPrice') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'partQuant') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
