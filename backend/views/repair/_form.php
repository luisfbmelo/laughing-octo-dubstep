<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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

        <div class="row clientData">
            

            <!--CLIENT INITIAL DATA-->
            <?= $form->field($modelClient, 'cliName', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6'],])->textInput() ?>
            <?= $form->field($modelStores, 'id_store', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->dropDownList($stores,['id'=>'storesId','prompt'=>'--'])->label('Loja')?>

            <!--ADDRESS-->
            <?= $form->field($modelClient, 'cliAdress', ['options' => ['class' => 'col-lg-12']])->textArea(['rows' => 4]) ?>
            <?= $form->field($modelClient, 'cliDoorNum', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput() ?>
            <?= $form->field($modelClient, 'cliPostalCode', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput() ?>
            <?= $form->field($modelClient, 'cliPostalSuffix', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput() ?>

            <!--CONTACTS-->
            <?= $form->field($modelClient, 'cliConFix', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput() ?>
            <?= $form->field($modelClient, 'cliConMov1', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput() ?>
            <?= $form->field($modelClient, 'cliConMov2', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput() ?>
            <input type="hidden" name="clientDataHidden" id="clientDataHidden" value="new"/>
        </div>

        <div class="col-lg-12">
            <h1 class="createSubTitle">Informação de Reparação</h1>
            <div class="smallDivider"></div>
        </div>

        <div class="repairData">


            <!--EQUIPMENT-->
            <div class="row equipList">
            <?= $form->field($modelEquip, 'id_equip', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3 required'],])->dropDownList($equip,['id'=>'equipID','prompt'=>'--'])->label('Equipamentos')?>

            
            <?= (isset($isOk) && $isOk[0]) ? $form->field($modelBrands, 'id_brand', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3 required']])->dropDownList($brands,['id'=>'brandID','prompt'=>'--'])->label('Marcas') : $form->field($modelBrands, 'id_brand', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3 required']])->dropDownList($brands,['id'=>'brandID','prompt'=>'--','disabled'=>'true'])->label('Marcas')?>

            <?= (isset($isOk) && $isOk[1]) ? $form->field($modelModels, 'id_model', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3 required']])->dropDownList($models,['id'=>'modelID','prompt'=>'--'])->label('Modelos') : $form->field($modelModels, 'id_model', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3 required']])->dropDownList($models,['id'=>'modelID','prompt'=>'--','disabled'=>'true'])->label('Modelos')?>

            <?= $form->field($modelInv, 'inveSN', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3']])->textInput(['maxlength' => 10]) ?>
            </div>
            

         <div class="row">
  
            <!-- REPAIR TYPE -->
            <?= $form->field($modelTypes, 'id_type', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6 required']])->dropDownList($types,['id'=>'typeID','prompt'=>'--'])->label('Tipo de reparação')?>
            <?= $form->field($modelRepair, 'priority', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->dropDownList([''=>'--','1' => 'Alta', '2' => 'Média', '3' => 'Baixa'],['id'=>'priorityID']) ?>
             
            <!--BUDGET SELECTION-->
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 normalType" style="display:none;">
                <div class="row">
                    <?= $form->field($modelRepair, 'maxBudget', ['options' => ['class' => 'col-lg-12 maxBudget']])->textInput(['maxlength' => 10]) ?>                    
                    
                    <input type="hidden" name="maxBudgetHidden" id="maxBudgetHidden" value="hidden"/>
                </div>               
                
            </div>

            <!--DESCRIPTIONS-->
            <?= $form->field($modelRepair, 'repair_desc', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-3']])->textarea(['rows' => 4])->label("Descrição da Avaria") ?>
            <?= $form->field($modelRepair, 'obs', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-3']])->textarea(['rows' => 4])->label("Outras observações") ?>
      
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 accessoriesListing">
                <!--ACCESSORIES-->
                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                    <label>
                        <?= $form->field($modelAccess, 'id_accessories', ['options' => ['class' => 'clearPad']])->checkboxList($accessories,['unselect'=> 0,'separator'=>'<br/>','class'=>'checkboxList'])->label("Acessórios") ?>
                    </label>
                </div>
                <?= $form->field($modelRepairAccess, 'otherDesc', ['options' => ['class' => 'col-lg-4 col-xs-4 col-sm-4 col-md-4']])->textInput(['placeholder'=>'Outro acessório','id'=>'outroAccess'])->label("") ?>
            </div>
            


            


            <div class="form-group col-lg-12 col-xs-12 col-sm-12 col-md-12 pageButtons">
                <?= Html::submitButton($modelRepair->isNewRecord ? 'Criar' : 'Atualizar', ['class' => $modelRepair->isNewRecord ? 'btn btn-success col-lg-1' : 'btn btn-primary col-lg-1','name'=>'submit']) ?>
                <?= Html::submitButton('Cancelar',array('class'=>'btn btn-danger col-lg-1','name'=>'cancelar','id'=>'cancelar')); ?>
            </div>
        </div>

        
        

        <?php ActiveForm::end(); ?>

<script>
    $(document).ready(function(){


        $("#typeID").on('change',function(){
            var state = $(this).val();
            var desc = $('option:selected', $(this)).text();
            console.log(desc);

            if (desc=="Normal"){
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
        

        //AUTOCOMPLETE CLIENT
        var urlBaseAuto = '<?php echo Yii::$app->request->baseUrl;?>';
        var urlDestAuto = urlBaseAuto+'/client/allclients';

        $('#client-cliname').autocomplete({
            source: urlDestAuto,
            minLength: 2,
            select: function(event, ui) {
                $("#client-cliadress").val(ui.item.address);
                $("#client-clidoornum").val(ui.item.door);
                $("#client-clipostalcode").val(ui.item.pc);
                $("#client-clipostalsuffix").val(ui.item.pcsufix);
                $("#client-cliconfix").val(ui.item.hometel);
                $("#client-cliconmov1").val(ui.item.mo1);
                $("#client-cliconmov2").val(ui.item.mo2);

                $("[id^='client-']:not('#client-cliname')").attr("readonly","readonly");

                $("#clientDataHidden").val(ui.item.id);
            },
            response: function( event, ui ) {
                console.log(ui);
            },
     
            html: true, // optional (jquery.ui.autocomplete.html.js required)
     
            // optional (if other layers overlap autocomplete list)
            open: function(event, ui) {
                
            }


        }).on('change',function(){
            $("[id^='client-']:not('#client-cliname')").val(null);
            $("[id^='client-']:not('#client-cliname')").attr("readonly",false);
            $("#clientDataHidden").val("new");

        });

        //OTHER DESC SHOWUP
        $('#accessories-id_accessories input[type=checkbox]').change(function(){
            if($(this).val()==3){
                $(".field-repairaccessory-otherdesc").toggle();
            }
        });
    });
</script>