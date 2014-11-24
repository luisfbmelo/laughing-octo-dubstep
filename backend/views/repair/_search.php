<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model common\models\SearchRepair */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="repair-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'enableClientValidation' => false
    ]); ?>
    <?php echo $form->errorSummary([$modelClient,$modelRepair,$modelStores, $modelBrands, $modelEquip, $modelModels, $modelTypes, $modelInv]); ?>
    
    <div class="row">
        <!--CLIENT DATA-->
        <?= $form->field($searchModel, 'client', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->label('Nome de cliente') ?>
        <?= $form->field($searchModel, 'cliContact', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->label('Contacto fixo') ?>
    </div>

    <!--REPAIR DATA-->
    <div class="row">
        <?= $form->field($searchModel, 'id_repair', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']]) ?>
        <?= $form->field($searchModel, 'store_id', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->dropDownList($stores,['id'=>'storesId','prompt'=>'--'])->label('Loja')?>
    </div>
    
    <div class="row">
        <?= $form->field($searchModel, 'equip', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3'],])->textInput()->label('Equipamentos') ?>
        <?= $form->field($searchModel, 'brand', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3']])->textInput()->label('Marcas') ?>
        <?= $form->field($searchModel, 'model', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3']])->textInput()->label('Modelos') ?>

        <?= $form->field($searchModel, 'sn', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3']])->textInput(['maxlength' => 10]) ?>
    </div>
    
    <div class="row">
        <?= $form->field($searchModel, 'status_id',['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->dropDownList($statusAll,['id'=>'statusID','prompt'=>'--'])->label('Estado de reparação') ?>
        <?= $form->field($searchModel, 'type_id', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->dropDownList($types,['id'=>'typeID','prompt'=>'--'])->label('Tipo de reparação')?>
    </div>

    <div class="row">
        <?php 
            echo $form->field($searchModel, 'date_entry', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->widget(DateControl::classname(), [
                'displayFormat' => 'dd/MM/yyyy',
                'autoWidget' => false,
                'widgetClass' => 'yii\widgets\MaskedInput',
                'options' => [
                    'mask' => '99/99/9999'
                ],
            ]);

            echo $form->field($searchModel, 'date_close', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->widget(DateControl::classname(), [
                'displayFormat' => 'dd/MM/yyyy',
                'autoWidget' => false,
                'widgetClass' => 'yii\widgets\MaskedInput',
                'options' => [
                    'mask' => '99/99/9999'
                ],
            ]);
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Pesquisar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Limpar', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(document).ready(function(){
        //AUTOCOMPLETES
        var urlBaseCli = '<?php echo Yii::$app->request->baseUrl;?>';
        var urlDestCli = urlBaseCli+'/client/allclients';

        $('#searchrepair-client').autocomplete({
            source: urlDestCli,
            minLength: 2,
            select: function(event, ui) {
                
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
        });

        //equips
        var urlBaseEquip = '<?php echo Yii::$app->request->baseUrl;?>';
        var urlDestEquip = urlBaseEquip+'/equipaments/allequips';

        $('#searchrepair-equip').autocomplete({
            source: urlDestEquip,
            minLength: 2,
            select: function(event, ui) {
                $("#searchrepair-equip").val(ui.item.equipDesc);


            },
            response: function( event, ui ) {
                console.log(ui);
            },
     
            html: true, // optional (jquery.ui.autocomplete.html.js required)
     
            // optional (if other layers overlap autocomplete list)
            open: function(event, ui) {
                
            }

        });

        //brands
        var urlBaseBrand = '<?php echo Yii::$app->request->baseUrl;?>';
        var urlDestBrand = urlBaseBrand+'/brands/allbrands';

        $('#searchrepair-brand').autocomplete({
            source: urlDestBrand,
            minLength: 2,
            select: function(event, ui) {
                console.log(ui);
                $("#searchrepair-brand").val(ui.item.brandName);

            },
            response: function( event, ui ) {
                //console.log(ui);
            },
     
            html: true, // optional (jquery.ui.autocomplete.html.js required)
     
            // optional (if other layers overlap autocomplete list)
            open: function(event, ui) {
                
            }
        });

        //models
        var urlBaseModel = '<?php echo Yii::$app->request->baseUrl;?>';
        var urlDestModel = urlBaseModel+'/models/allmodels';

        $('#searchrepair-model').autocomplete({
            source: urlDestModel,
            minLength: 2,
            select: function(event, ui) {
                console.log(ui);
                $("#searchrepair-model").val(ui.item.modeName);


            },
            response: function( event, ui ) {
                //console.log(ui);
            },
     
            html: true, // optional (jquery.ui.autocomplete.html.js required)
     
            // optional (if other layers overlap autocomplete list)
            open: function(event, ui) {
                
            }
        });
    });
</script>