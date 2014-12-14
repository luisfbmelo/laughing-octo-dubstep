<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\repair */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clearAll"></div>
        <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>
            <?php 
            //summary models array
            $arrayModels = array($modelClient,$modelRepair,$modelStores, $modelBrands, $modelEquip, $modelModels, $modelTypes, $modelInv, $modelAccess,$modelStatus);
            if (isset($items) && sizeof($items)>0){ 
                foreach($items as $i=>$item){
                    array_push($arrayModels,$item);
                }
            }
            echo $form->errorSummary($arrayModels); 

            ?>
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
                <?= $form->field($modelClient, 'cliPostalSuffix', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput() ?>
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
                <input type="hidden" name="equipId" id="equipId" value="<?= $modelEquip->id_equip ?>"/>
                <?= $form->field($modelBrands, 'brandName', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3 required']])->textInput()->label('Marcas') ?>
                <input type="hidden" name="brandId" id="brandId" value="<?= $modelBrands->id_brand ?>"/>
                <?= $form->field($modelModels, 'modelName', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3 required']])->textInput()->label('Modelos') ?>
                <input type="hidden" name="modelId" id="modelId" value="<?= $modelModels->id_model ?>"/>

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

            <?php

                //budget bar
                if ($modelTypes->id_type == 1){
                    $showBar = true;
                }else{
                    $showBar = false;
                }
              
                ?>

            <div class="row">
                <!-- REPAIR TYPE -->
                <div class="col-lg-6 col-xs-12 col-sm-6 col-md-6">
                    <div class="row">
                        <?= $form->field($modelTypes, 'id_type', ['options' => ['class' => 'col-lg-12 col-xs-12 col-sm-12 col-md-12 required']])->dropDownList($types,['id'=>'typeID','prompt'=>'--'])->label('Tipo de reparação')?>
                        

                        <!--BUDGET/DATE SELECTION-->
                        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 normalType" <?= (!$showBar) ? 'style="display:none;"' : null ?>>
                            <div class="row">
                                <?= $form->field($modelRepair, 'maxBudget', ['options' => ['class' => 'col-lg-12 maxBudget']])->textInput(['maxlength' => 10]) ?>                    
                                
                                <input type="hidden" name="maxBudgetHidden" id="maxBudgetHidden" <?= (!$showBar) ? 'value="hidden"' : 'value="shown"'?>/>
                            </div>               
                            
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 col-xs-12 col-sm-6 col-md-6 accessoriesListing">
                    <!--ACCESSORIES-->
                    <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                        <label>
                            <?= $form->field($modelAccess, 'id_accessories', ['options' => ['class' => 'clearPad']])->checkboxList($accessories,['unselect'=> 0,'separator'=>'<br/>','class'=>'checkboxList'])->label("Acessórios") ?>
                        </label>
                    </div>

                    <?php 
                        if (isset($modelAccess->id_accessories) && in_array(3,$modelAccess->id_accessories)){
                           echo $form->field($modelRepairAccess, 'otherDesc', ['options' => ['class' => 'col-lg-4 col-xs-4 col-sm-4 col-md-4','style'=>'display:block']])->textInput(['placeholder'=>'Outro acessório','id'=>'outroAccess'])->label("");
                        }else{
                           echo $form->field($modelRepairAccess, 'otherDesc', ['options' => ['class' => 'col-lg-4 col-xs-4 col-sm-4 col-md-4']])->textInput(['placeholder'=>'Outro acessório','id'=>'outroAccess'])->label("");
                        }
                    ?> 

                    
                </div>
            
            </div>            
            
        </div>

        <div class="row">
            <!--WORKPRICE-->
            <?= $form->field($modelRepair, 'workPrice',['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->textInput() ?> 

            <!--STATUS-->
            <div class="col-lg-6 col-md-12 col-sm-6 col-xs-6 ">
                <label class="control-label" for="status-id_status">Estado da reparação</label>
                <div class="statusButtons">
                    <?php 
                    if (isset($statusAll) && sizeof($statusAll)>0){
                        /*echo $form->field($modelStatus, 'id_status', ['options' => ['class' => 'clearPad']])->radioList(ArrayHelper::map($statusAll,'id_status','statusDesc'),['unselect'=> 0,'class'=>'checkboxList','itemOptions'=>['labelOptions'=>['style'=>'background-color:#']]])->label("Estado da reparação");*/


                        $bodyHtml="";
                        foreach($statusAll as $i=>$row){
                            if ($modelStatus->id_status==$row['id_status']){
                                $check = "checked";
                            }else{
                                $check = "";
                            }
                            $bodyHtml.='
                            <span class="statusContainer">
                                
                                <input type="radio" name="Status[id_status]" id="status_'.$row["id_status"].'" value="'.$row["id_status"].'" '.$check.'/>
                                <label for="status_'.$row["id_status"].'" class="status_'.$row["id_status"].'">'.$row["statusDesc"].'</label>
                            </span>';
                        }
                        $bodyHtml.='<div class="clearAll"></div>';
                        echo $bodyHtml;
                    }
                     ?>
                </div>
            </div>
        </div>

        <div class="partsContainer row">
            <div class="partsAction smallSectionTitle col-lg-12">
                Peças
            </div>
        </div>

        <table class="partsInsert table table-striped table-bordered">
            <thead>
                <tr class="listHeader">
                    <td></td>
                    <td>Código</td>
                    <td>Quantidade</td>
                    <td>Designação</td>
                    <td>Preço</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (isset($items) && sizeof($items)>0){ 
                    foreach($items as $i=>$item){
                    ?>
                        <tr id="line_<?php echo $i;?>" class="realPart">
                            <td class="partRemove"><div class="glyphicon glyphicon-remove" id="part_<?= $item->id_part ?>"></div></td>
                            <td><?= $form->field($item,"[$i]partCode")->textInput()->label(false) ?></td>
                            <td><?= $form->field($item,"[$i]partQuant")->textInput()->label(false) ?></td>
                            <td><?= $form->field($item,"[$i]partDesc")->textInput()->label(false) ?></td>
                            <td><?= $form->field($item,"[$i]partPrice")->textInput()->label(false) ?><input type="hidden" id="parts-<?php echo $i; ?>-id_part" class="form-control" name="Parts[<?php echo $i; ?>][id_part]" value="<?php echo $item->id_part;?>"></td>
                                                            
                        </tr>
                <?php }}else{ ?>
                    <tr id="line_0">
                        <td></td>
                        <td><?= $form->field($modelParts,'[0]partCode')->textInput()->label(false) ?></td>
                        <td><?= $form->field($modelParts,'[0]partQuant')->textInput()->label(false) ?></td>
                        <td><?= $form->field($modelParts,'[0]partDesc')->textInput()->label(false) ?></td>
                        <td><?= $form->field($modelParts,'[0]partPrice')->textInput()->label(false) ?></td>                            
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="row addButtonContainer">
            <div class="addButton btn btn-info">
               <span class=" glyphicon glyphicon-plus"></span>
                <span>Adicionar peça</span> 
            </div>
            
        </div>

        <!--TOTAL-->
        <div class="row" style="margin-top:30px">
             

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
                <table class="formTable table table-striped table-bordered">
                    <thead>
                        <tr class="listHeader">
                            <td>TOTAL</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $form->field($modelRepair, 'total',['options' => ['class' => 'col-lg-12 col-xs-12 col-sm-12 col-md-12']])->textInput()->label(false) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        

        <!--END BUTTONS-->
        <div class="row">
            <div class="form-group col-lg-12 col-xs-12 col-sm-12 col-md-12 pageButtons">
                <?= Html::submitButton($modelRepair->isNewRecord ? 'Criar' : '<span class="glyphicon glyphicon-ok"></span>', ['class' => $modelRepair->isNewRecord ? 'btn btn-success col-lg-1' : 'btn btn-success col-lg-1','name'=>'submit']) ?>
                <?= Html::submitButton('<span class="glyphicon glyphicon-remove"></span>',array('class'=>'btn btn-danger col-lg-1','name'=>'cancelar','id'=>'cancelar')); ?>
            </div>
        </div>  
            
        

        <?php ActiveForm::end(); ?>

<script>
    $(document).ready(function(){
        //CHANGE TOTAL VALUE
        changeTotal();

        function changeTotal(){
            var workPrice=parseInt($("#repair-workprice").val()),
            partQuant=0,
            partTotal=0,
            totalParts = 0;

            //in case of workPrice NaN
            workPrice = workPrice || 0;

            $.each($(".partsInsert tbody tr"), function() {
                partQuant = parseInt($(this).find("input[id^=parts][id$=partquant]").val()) || 0;
                partTotal = parseInt($(this).find("input[id^=parts][id$=partprice]").val()) || 0;
                totalParts+=partQuant * partTotal;
            });
            
            $("#repair-total").attr('value', totalParts+workPrice);
            console.log($("#repair-total").attr('value'));
        }        

        $(".repairUpdate").on("keyup", "input.partInput, [id^=parts][id$=partprice], [id^=parts][id$=partquant] ,#repair-workprice", function(){
            changeTotal();
        });

        //DELETE PART
        $("tbody").on("click",'.partRemove div', function(){
            
            var urlBase = '<?php echo Yii::$app->request->baseUrl;?>';
            var urlDest = urlBase+'/parts/delajax';
            var el = $(this), partId;

            //if has ID
            if (el.attr("id")){
                partId = el.attr("id").split("_").pop();
            }
  
            //if id is ok
            if (partId!=undefined && partId!=""){
                if(confirm("Deseja realmente excluir este item? A operação é irreversível!"))
                {
                    $.ajax({
                        url: urlDest,
                        type:"POST",
                        dataType: 'json',
                        data:{ id: partId},
                        success: function(data){
                            var tbodyChild = el.parent().parent().parent().children().length;
                            
                            if (data=="done"){
                                
                                if (tbodyChild==1){
                                    el.parent().parent().find("input").removeAttr('value');   
                                }else{
                                    el.parent().parent().remove();
                                }
                                
                            }else if(data=="empty"){

                                if (tbodyChild==1){
                                    el.parent().parent().find("input").removeAttr('value');   
                                }else{
                                    el.parent().parent().remove();
                                }
                            }
                            changeTotal();
                        },
                        error: function(){

                        }
                    });
                }

            //if is a new element
            }else{
                console.log("1");
                el.parent().parent().remove(); 
                changeTotal();
            }
            
        });


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
               // $("#equipId").val(ui.item.equipId);
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
                var el = $(".field-repairaccessory-otherdesc");


                el.toggle();
                
                
            }
        });
    });
</script>