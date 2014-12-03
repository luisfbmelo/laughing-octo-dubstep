<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Status */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="clearAll"></div>

<?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>
<?php echo $form->errorSummary([$model]); ?>
<div class="row">
    <div class="col-lg-12">
        <p class="note">Campos com <span class="required">*</span> são obrigatórios.</p>
    </div>
</div>

<div class="row">
    <?= $form->field($model, 'statusDesc', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput(['maxlength' => 250])?>
</div>

<div class="row">
    <?= $form->field($model, 'type', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->dropDownList([''=>'--','1' => 'Normal', '2' => 'Terminado', '3' => 'Fecho'],['id'=>'typeID'])?>
</div>

<div class="row">
	<div class="col-lg-4 col-xs-12 col-sm-4 col-md-4">
		<label for="picker">Escolha uma cor</label>
		<div id="picker"></div>
		<input type="hidden" name="Status[color]" class="colorPickerValue" value="ffffff">
	</div>
</div>

<div class="row form-group">
	<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 pageButtons">
	    <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span>', ['class' => 'btn btn-success col-lg-1', 'name' => 'add']) ?>
	    <?= Html::submitButton('<span class="glyphicon glyphicon-remove"></span>',array('class'=>'btn btn-danger col-lg-1','name'=>'cancelar','id'=>'cancelar')); ?>
	</div>
</div>

<?php ActiveForm::end(); ?>


<script>
	$(document).ready(function(){
		var timeout;
		$('#picker').colpick({
			flat:true,
			layout:'hex',
			submit:0,
			color: 'ffffff',
			onChange: function(e){				
				clearTimeout(timeout);

				timeout = setTimeout(function(){
					$(".colorPickerValue").val($.colpick.hsbToHex(e))
				}, 50);
			}
		});
	});
</script>