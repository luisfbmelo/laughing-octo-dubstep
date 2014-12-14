<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Stores */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clearAll"></div>

<?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>
<?php echo $form->errorSummary([$model]); ?>

<div class="row">
	<?= $form->field($model, 'storeDesc', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->textInput()->label('Nome da loja') ?>
</div>

<div class="row form-group">
	<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 pageButtons">
	    <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span>', ['class' => 'btn btn-success col-lg-1', 'name' => 'add']) ?>
	    <?= Html::submitButton('<span class="glyphicon glyphicon-remove"></span>',array('class'=>'btn btn-danger col-lg-1','name'=>'cancelar','id'=>'cancelar')); ?>
	</div>
</div>

<?php ActiveForm::end(); ?>


