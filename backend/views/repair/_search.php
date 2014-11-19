<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SearchRepair */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="repair-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($searchModel, 'id_repair') ?>

    <?= $form->field($searchModel, 'type_id') ?>

    <?= $form->field($searchModel, 'client_id') ?>

    <?= $form->field($searchModel, 'inve_id') ?>

    <?= $form->field($searchModel, 'status_id') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'repair_desc') ?>

    <?php // echo $form->field($model, 'date_entry') ?>

    <?php // echo $form->field($model, 'date_close') ?>

    <?php // echo $form->field($model, 'store_id') ?>

    <?php // echo $form->field($model, 'priority') ?>

    <?php // echo $form->field($model, 'budget') ?>

    <?php // echo $form->field($model, 'maxBudget') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'obs') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
