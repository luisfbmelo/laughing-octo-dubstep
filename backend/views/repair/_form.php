<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model common\models\repair */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clearAll"></div>
        <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>
            <?php echo $form->errorSummary([$modelClient,$modelRepair,$modelStores, $modelBrands, $modelEquip, $modelModels, $modelTypes, $modelInv, $modelAccess]); ?>
            <div class="row">
                <div class="col-lg-12">
                    <p class="note">Campos com <span class="required">*</span> são obrigatórios.</p>
                </div>
            </div>



        <div class="col-lg-12">
            <h1 class="createSubTitle">Informação do Cliente</h1>
            <div class="smallDivider"></div>
        </div>

        <!-- <div class="row">
           
            <input type="button" value="Novo" class="btn btn-danger newClient col-lg-1"/> 
        </div> -->

        <div class="clientData">
            
            <div class="row">
                <!--CLIENT INITIAL DATA-->
                <?= $form->field($modelClient, 'cliName', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6'],])->textInput() ?>
                <?= $form->field($modelStores, 'id_store', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->dropDownList($stores,['id'=>'storesId','prompt'=>'--'])->label('Loja')?>
            </div>

            <div class="row">
                <!--ADDRESS-->
                <?= $form->field($modelClient, 'cliAdress', ['options' => ['class' => 'col-lg-12']])->textArea(['rows' => 4]) ?>
            </div>  

            <div class="row">
                <?= $form->field($modelClient, 'cliDoorNum', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput() ?>
                <?= $form->field($modelClient, 'cliPostalCode', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput() ?>
                <?= $form->field($modelClient, 'cliPostalSuffix', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput(['placeholder'=>'000']) ?>
            </div>  
          
            <div class="row">
                <!--CONTACTS-->
                <?= $form->field($modelClient, 'cliConFix', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput() ?>
                <?= $form->field($modelClient, 'cliConMov1', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput() ?>
                <?= $form->field($modelClient, 'cliConMov2', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput() ?>
            </div>
            
            <input type="hidden" name="clientDataHidden" id="clientDataHidden" value="<?= (isset($modelClient->id_client)) ? $modelClient->id_client : 'new' ?>"/>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h1 class="createSubTitle">Informação de Reparação</h1>
                <div class="smallDivider"></div>
            </div>  
        </div>
        

        <div class="repairData">

            <!--EQUIPMENT-->
            <div class="row equipList">

                <?= $form->field($modelEquip, 'equipDesc', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3 required'],])->textInput()->label('Equipamentos') ?>
                <input type="hidden" name="equipId" id="equipId" value="<?= (isset($modelEquip->id_equip) && is_numeric($modelEquip->id_equip)) ? $modelEquip->id_equip : 'new' ?>"/>
                <?= $form->field($modelBrands, 'brandName', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3 required']])->textInput()->label('Marcas') ?>
                <input type="hidden" name="brandId" id="brandId" value="<?= (isset($modelBrands->id_brand) && is_numeric($modelBrands->id_brand)) ? $modelBrands->id_brand : 'new' ?>"/>
                <?= $form->field($modelModels, 'modelName', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3 required']])->textInput()->label('Modelos') ?>
                <input type="hidden" name="modelId" id="modelId" value="<?= (isset($modelModels->id_model) && is_numeric($modelModels->id_model)) ? $modelModels->id_model : 'new' ?>"/>

                <?= $form->field($modelInv, 'inveSN', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3']])->textInput() ?>
             <!-- $form->field($modelEquip, 'id_equip', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3 required'],])->dropDownList($equip,['id'=>'equipID','prompt'=>'\-\-'])->label('Equipamentos') 

            
             (isset($isOk) && $isOk[0]) ? $form->field($modelBrands, 'id_brand', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3 required']])->dropDownList($brands,['id'=>'brandID','prompt'=>'\-\-'])->label('Marcas') : $form->field($modelBrands, 'id_brand', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3 required']])->dropDownList($brands,['id'=>'brandID','prompt'=>'\-\-','disabled'=>'true'])->label('Marcas')

             (isset($isOk) && $isOk[1]) ? $form->field($modelModels, 'id_model', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3 required']])->dropDownList($models,['id'=>'modelID','prompt'=>'\-\-'])->label('Modelos') : $form->field($modelModels, 'id_model', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3 required']])->dropDownList($models,['id'=>'modelID','prompt'=>'\-\-','disabled'=>'true'])->label('Modelos')

              -->
            </div>
            

            
            <div class="row">
                 <!--DESCRIPTIONS-->
                <?= $form->field($modelRepair, 'repair_desc', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->textarea(['rows' => 4])->label("Descrição da Avaria") ?>
                <?= $form->field($modelRepair, 'obs', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->textarea(['rows' => 4])->label("Outras observações") ?>

            </div>

            <div class="row">
                <!-- REPAIR TYPE -->
                <?= $form->field($modelTypes, 'id_type', ['options' => ['class' => 'col-lg-12 col-xs-12 col-sm-12 col-md-12 required']])->dropDownList($types,['id'=>'typeID','prompt'=>'--'])->label('Tipo de reparação')?> 
            

            </div>

            <div class="row">
                 <?php
                 
                if (isset($modelTypes->id_type)){
                    $newModel = $modelTypes->findOne($modelTypes->id_type);
                }
                //budget bar
                if (isset($newModel) && $newModel->extraData == 1){
                    $showBar = true;
                    $showDate = false;

                //warranty bar
                }else if(isset($newModel) && $newModel->extraData == 2){
                    $showBar = false;
                    $showDate = true;

                }else{
                    $showBar = false;
                    $showDate = false;
                }                
              
                ?>
                <!--BUDGET/DATE SELECTION-->
                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 normalType" <?= (!$showBar) ? 'style="display:none;"' : "" ?>>
                    <div class="row">
                        <?= $form->field($modelRepair, 'maxBudget', ['options' => ['class' => 'col-lg-12 maxBudget']])->textInput(['maxlength' => 10]) ?>                    
                        
                        <input type="hidden" name="maxBudgetHidden" id="maxBudgetHidden" <?= (!$showBar) ? 'value="hidden"' : 'value="shown"'?>/>
                    </div>               
                    
                </div>
            </div>


            <div class="row">
                 <div class="col-lg-6 col-xs-12 col-sm-6 col-md-6 accessoriesListing">
                    <!--ACCESSORIES-->
                    <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                        <label>
                            <?= $form->field($modelAccess, 'id_accessories', ['options' => ['class' => 'clearPad']])->checkboxList($accessories,['unselect'=> 0,'separator'=>'<br/>','class'=>'checkboxList'])->label("Acessórios") ?>
                        </label>
                    </div>
                    <?= $form->field($modelRepairAccess, 'otherDesc', ['options' => ['class' => 'col-lg-4 col-xs-4 col-sm-4 col-md-4']])->textInput(['placeholder'=>'Outro acessório','id'=>'outroAccess'])->label("") ?>
                </div>            
            </div>
        </div>                
         
        <div class="row">
            <div class="form-group col-lg-12 col-xs-12 col-sm-12 col-md-12 pageButtons">
                <?= Html::submitButton($modelRepair->isNewRecord ? '<span class="glyphicon glyphicon-ok"></span>' : 'Atualizar', ['class' => $modelRepair->isNewRecord ? 'btn btn-success col-lg-1' : 'btn btn-primary col-lg-1','name'=>'submit']) ?>
                <?= Html::submitButton('<span class="glyphicon glyphicon-remove"></span>',array('class'=>'btn btn-danger col-lg-1','name'=>'cancelar','id'=>'cancelar')); ?>
            </div>

        </div>

        

        <?php ActiveForm::end(); ?>

<script>
    $(document).ready(function(){

        //CHANGE EXTRA DATA REPAIR TYPE BOX
        $("#typeID").on('change',function(){
            var state = $(this).val();
            var desc = $('option:selected', $(this)).val();
            console.log(desc);

            if (desc==1){
                $(".normalType").toggle(0,function(){
                    console.log($(".normalType").css("display"));
                    if ($(".normalType").css("display")=="none"){
                        state="hidden";
                    }else{
                        state="shown";
                    }

                    $("#maxBudgetHidden").val(state);

                });

            }else{
                $(".normalType").css('display','none');
                state = 'hidden';
                $("#maxBudgetHidden").val(state);
            }
            
        });

        //LOAD BRANDS
        $("#equipID").on('change',function(){
            $("#modelID").attr("disabled", "disabled");

            if ($('option:selected', $(this)).text()!="--"){
                var opt="";
                var equipId = $('option:selected', $(this)).val();
                var urlBase = '<?php echo Yii::$app->request->baseUrl;?>';
                var urlDest = urlBase+'/repair/getbrands';

                $.ajax({
                    url: urlDest,
                    type:"POST",
                    dataType: 'json',
                    data:{ id: equipId},
                    success: function(data){
                        opt = '<option value>--</option>'

                        $.each( data, function( key, value ) {
                            opt+= '<option value="'+key+'">'+value+'</option>';
                        });
                      
                        $("#brandID").empty();
                        $("#brandID").append(opt);
                        $("#brandID").removeAttr("disabled");
                    },
                    error: function(){

                    }
                });
                
            }else{
                opt = '<option>--</option>';
                $("#brandID, #modelID").empty();
                $("#brandID, #modelID").append(opt);
                $("#brandID, #modelID").attr("disabled", "disabled");
            }

        });

        //LOAD MODELS
        $("#brandID").on('change',function(){
            $("#modelID").removeAttr("disabled");
            if ($('option:selected', $(this)).text()!="--"){
                var opt = "";
                var brandId = $('option:selected', $(this)).val();
                var equipId = $('option:selected', $("#equipID")).val();
                var urlBase = '<?php echo Yii::$app->request->baseUrl;?>';
                var urlDest = urlBase+'/repair/getmodels';

                $.ajax({
                    url: urlDest,
                    type:"POST",
                    dataType: 'json',
                    data:{ brandId: brandId, equipId: equipId},
                    success: function(data){
                        console.log(data);
                        opt = '<option value>--</option>'
                        
                        $.each( data, function( key, value ) {
                            opt+= '<option value="'+key+'">'+value+'</option>';
                        });
                      
                        $("#modelID").empty();
                        $("#modelID").append(opt);
                        $("#modelID").removeAttr('disabled');
                        
                    },
                    error: function(){

                    }
                });
                
            }else{
                opt = '<option>--</option>';
                $("#modelID").empty();
                $("#modelID").append(opt);
                $("#modelID").attr("disabled", "disabled");
            }

        });
        

        //AUTOCOMPLETES
        var urlBaseCli = '<?php echo Yii::$app->request->baseUrl;?>';
        var urlDestCli = urlBaseCli+'/client/allclients';

        $('#client-cliname').autocomplete({
            source: urlDestCli,
            minLength: 2,
            select: function(event, ui) {
                $("#client-cliadress").val(ui.item.address);
                $("#client-clidoornum").val(ui.item.door);
                $("#client-clipostalcode").val(ui.item.pc);
                $("#client-clipostalsuffix").val(ui.item.pcsufix);
                $("#client-cliconfix").val(ui.item.hometel);
                $("#client-cliconmov1").val(ui.item.mo1);
                $("#client-cliconmov2").val(ui.item.mo2);

                //say that it must be updated only
                $("#clientDataHidden").val(ui.item.id);
            },
            response: function( event, ui ) {
                console.log(ui);
            },
     
            html: true, // optional (jquery.ui.autocomplete.html.js required)
     
            // optional (if other layers overlap autocomplete list)
            open: function(event, ui) {
                
            }

            //say it's a new client
        }).on('change',function(){
            $("[id^='client-']:not('#client-cliname')").val(null);
            $("#clientDataHidden").val("new");

        });

        //equips
        var urlBaseEquip = '<?php echo Yii::$app->request->baseUrl;?>';
        var urlDestEquip = urlBaseEquip+'/equipaments/allequips';

        $('#equipaments-equipdesc').autocomplete({
            source: urlDestEquip,
            minLength: 2,
            select: function(event, ui) {
                $("#equipaments-equipdesc").val(ui.item.equipDesc);

                //say that it must be updated only
                $("#equipId").val(ui.item.id);
            },
            response: function( event, ui ) {
                console.log(ui);
            },
     
            html: true, // optional (jquery.ui.autocomplete.html.js required)
     
            // optional (if other layers overlap autocomplete list)
            open: function(event, ui) {
                
            }

            //say it's a new client
        }).on('change',function(){
            $("#equipId").val("new");

        });

        //brands
        var urlBaseBrand = '<?php echo Yii::$app->request->baseUrl;?>';
        var urlDestBrand = urlBaseBrand+'/brands/allbrands';

        $('#brands-brandname').autocomplete({
            source: urlDestBrand,
            minLength: 2,
            select: function(event, ui) {
                console.log(ui);
                $("#brands-brandname").val(ui.item.brandName);

                //say that it must be updated only
                $("#brandId").val(ui.item.id);
            },
            response: function( event, ui ) {
                //console.log(ui);
            },
     
            html: true, // optional (jquery.ui.autocomplete.html.js required)
     
            // optional (if other layers overlap autocomplete list)
            open: function(event, ui) {
                
            }

            //say it's a new client
        }).on('change',function(){
            $("#brandId").val("new");

        });

        //models
        var urlBaseModel = '<?php echo Yii::$app->request->baseUrl;?>';
        var urlDestModel = urlBaseModel+'/models/allmodels';

        $('#models-modelname').autocomplete({
            source: urlDestModel,
            minLength: 2,
            select: function(event, ui) {
                console.log(ui);
                $("#models-modelname").val(ui.item.modeName);

                //say that it must be updated only
                $("#modelId").val(ui.item.id);

                //CHANGE ALL
                //$("#brands-brandname").val(ui.item.brandName);
                //$("#brandId").val(ui.item.brandId);
                //$("#equipaments-equipdesc").val(ui.item.equipName);
                //$("#equipId").val(ui.item.equipId);
            },
            response: function( event, ui ) {
                //console.log(ui);
            },
     
            html: true, // optional (jquery.ui.autocomplete.html.js required)
     
            // optional (if other layers overlap autocomplete list)
            open: function(event, ui) {
                
            }

            //say it's a new client
        }).on('change',function(){
            $("#modelId").val("new");

        });

        //OTHER DESC SHOWUP
        $('#accessories-id_accessories input[type=checkbox]').change(function(){
            if($(this).val()==3){
                $(".field-repairaccessory-otherdesc").toggle();
            }
        });
    });
</script>