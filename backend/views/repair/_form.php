<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\repair */
/* @var $form yii\widgets\ActiveForm */
?>


        <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

        <div class="col-lg-12">
            <h1 class="createSubTitle">Informação do Cliente</h1>
            <div class="smallDivider"></div>
        </div>

        <div class="row">
            <?= $form->field($modelClient, 'cliName', ['options' => ['class' => 'col-lg-12']])->textInput() ?>
            <input type="button" value="Novo" class="btn btn-danger newClient col-lg-1"/> 
        </div>

        <div class="row clientData" style="display:none;">
            <?= $form->field($modelClient, 'cliName', ['options' => ['class' => 'col-lg-6']])->textInput() ?>
            <?= $form->field($modelClient, 'cliAdress', ['options' => ['class' => 'col-lg-12']])->textArea() ?>
            <?= $form->field($modelClient, 'cliDoorNum', ['options' => ['class' => 'col-lg-4']])->textInput() ?>
            <?= $form->field($modelClient, 'cliPostalCode', ['options' => ['class' => 'col-lg-4']])->textInput() ?>
            <?= $form->field($modelClient, 'cliPostalSuffix', ['options' => ['class' => 'col-lg-4']])->textInput() ?>
            <input type="hidden" id="isNew" name="isNew" value="hidden"/>
        </div>

        <div class="col-lg-12">
            <h1 class="createSubTitle">Informação de Reparação</h1>
            <div class="smallDivider"></div>
        </div>

        <div class="row">
            <?= $form->field($modelRepair, 'client_id', ['options' => ['class' => 'col-lg-6']])->textInput() ?>
            <?= $form->field($modelStores, 'id_store', ['options' => ['class' => 'col-lg-6']])->dropDownList($stores,['id'=>'storeID','prompt'=>'Selecione uma loja'])->label('Loja')?>
               

            <?= $form->field($modelRepair, 'type_id', ['options' => ['class' => 'col-lg-6']])->textInput() ?>

            

            <?= $form->field($modelRepair, 'inve_id', ['options' => ['class' => 'col-lg-6']])->textInput() ?>

            <?= $form->field($modelRepair, 'status', ['options' => ['class' => 'col-lg-6']])->textInput(['maxlength' => 45]) ?>

            <?= $form->field($modelRepair, 'user_id', ['options' => ['class' => 'col-lg-12']])->textInput() ?>

            <?= $form->field($modelRepair, 'repair_desc', ['options' => ['class' => 'col-lg-12']])->textarea(['rows' => 6]) ?>

            <?= $form->field($modelRepair, 'date_entry', ['options' => ['class' => 'col-lg-6']])->textInput() ?>

            <?= $form->field($modelRepair, 'date_close', ['options' => ['class' => 'col-lg-6']])->textInput() ?>

            <?= $form->field($modelRepair, 'store_id', ['options' => ['class' => 'col-lg-6']])->textInput() ?>

            <?= $form->field($modelRepair, 'priority', ['options' => ['class' => 'col-lg-6']])->textInput() ?>

            <?= $form->field($modelRepair, 'budget', ['options' => ['class' => 'col-lg-6']])->textInput(['maxlength' => 10]) ?>

            <?= $form->field($modelRepair, 'maxBudget', ['options' => ['class' => 'col-lg-6']])->textInput(['maxlength' => 10]) ?>

            <?= $form->field($modelRepair, 'total', ['options' => ['class' => 'col-lg-6']])->textInput(['maxlength' => 10]) ?>
            
            <div class="col-lg-12"></div>

            <div class="form-group">
                <?= Html::submitButton($modelRepair->isNewRecord ? 'Create' : 'Update', ['class' => $modelRepair->isNewRecord ? 'btn btn-success col-lg-1' : 'btn btn-primary col-lg-1']) ?>
                <?= Html::submitButton('Cancelar',array('class'=>'btn btn-danger col-lg-1','name'=>'cancelar','id'=>'cancelar')); ?>
            </div>
        </div>

        
        

        <?php ActiveForm::end(); ?>

<script>
    $(document).ready(function(){
        $(".newClient").click(function(){
            var state = "false";
            $(".clientData").toggle(0,function(){
                console.log($(".clientData").css("display"));
                if ($(".clientData").css("display")=="none"){
                    state="hidden";
                }else{
                    state="shown";
                }

                $("#isNew").val(state);

            });
        });
    });
</script>