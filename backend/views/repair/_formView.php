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
            <div class="row">
                <div class="col-lg-12">
                    
                    <?php if ($modelRepair->status!=0){ ?>
                        <!--EDIT BTN-->
                        <?= Html::a('<span class="glyphicon glyphicon-edit" style="padding-right:10px;"></span>Editar', ['update', 'id' => $modelRepair->id_repair], ['class' => 'btn btn-primary']) ?>
                        
                        <!--REMOVE BTN-->
                        <?php if (Yii::$app->session->get('user.group')!=3){?>
                            <?= Html::a('<span class="glyphicon glyphicon-trash" style="padding-right:10px;"></span>Eliminar', ['delete', 'id' => $modelRepair->id_repair], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Tem a certeza que deseja eliminar?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <?php } ?>

                        <!--PRINT ENTRY BTN-->
                        <a href="<?php echo Yii::$app->request->baseUrl;?>/repair/view?id=<?php echo $modelRepair->id_repair;?>&sd=<?php echo $modelRepair->id_repair;?>&a=n" class="btn btn-primary printBtn">
                            <span class="glyphicon glyphicon-print" style="padding-right:10px;"></span>Emissão
                        </a>

                        <!--DELIVER BTN-->
                        <?php if($modelStatus->type==2){
                            echo Html::a('<span class="glyphicon glyphicon-ok" style="padding-right:10px;"></span>Entregar', ['setdeliver', 'id' => $modelRepair->id_repair], [
                                'class' => 'btn btn-success',
                                'data' => [
                                    'confirm' => 'Tem a certeza que deseja entregar esta reparação?',
                                    'method' => 'post',
                                ],
                            ]);
                        }else if ($modelStatus->type==3){ ?>
                        <!--PRINT DELIVER BTN-->
                            <a href="<?php echo Yii::$app->request->baseUrl;?>/repair/view?id=<?php echo $modelRepair->id_repair;?>&sd=<?php echo $modelRepair->id_repair;?>&a=c" class="btn btn-primary printBtn">
                                <span class="glyphicon glyphicon-print" style="padding-right:10px;"></span>Entrega
                            </a>
                        <?php } ?>

                    <!--RECOVER BTN-->
                    <?php }else{ 
                        echo Html::a('<span class="glyphicon glyphicon-repeat" style="padding-right:10px;"></span>Recuperar', ['recover', 'id' => $modelRepair->id_repair], [
                                'class' => 'btn btn-success',
                                'data' => [
                                    'confirm' => 'Tem a certeza que deseja recuperar esta reparação?',
                                    'method' => 'post',
                                ],
                            ]);
                    } ?>
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
                <?= $form->field($modelClient, 'cliName', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->textInput(['readonly'=>'readonly']) ?>
                <?= $form->field($modelStores, 'storeDesc', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->textInput(['readonly'=>'readonly'])->label('Loja')?> 
            </div>
            
            <div class="row">
                <!--ADDRESS-->
                <?= $form->field($modelClient, 'cliAdress', ['options' => ['class' => 'col-lg-12']])->textArea(['rows' => 4,'readonly'=>'readonly']) ?>
            </div>

            <div class="row">
                <?= $form->field($modelClient, 'cliDoorNum', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput(['readonly'=>'readonly']) ?>
                <?= $form->field($modelClient, 'cliPostalCode', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput(['readonly'=>'readonly']) ?>
                <?= $form->field($modelClient, 'cliPostalSuffix', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput(['readonly'=>'readonly']) ?>
            </div>
            
            <div class="row">
                <!--CONTACTS-->
                <?= $form->field($modelClient, 'cliConFix', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput(['readonly'=>'readonly']) ?>
                <?= $form->field($modelClient, 'cliConMov1', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput(['readonly'=>'readonly']) ?>
                <?= $form->field($modelClient, 'cliConMov2', ['options' => ['class' => 'col-lg-4 col-xs-12 col-sm-4 col-md-4']])->textInput(['readonly'=>'readonly']) ?>
            </div>            
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
            <?= $form->field($modelEquip, 'equipDesc', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3 required'],])->textInput(['readonly'=>'readonly'])->label('Equipamentos') ?>
                <input type="hidden" name="equipId" id="equipId" value="<?= $modelEquip->id_equip ?>"/>
                <?= $form->field($modelBrands, 'brandName', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3 required']])->textInput(['readonly'=>'readonly'])->label('Marcas') ?>
                <input type="hidden" name="brandId" id="brandId" value="<?= $modelBrands->id_brand ?>"/>
                <?= $form->field($modelModels, 'modelName', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3 required']])->textInput(['readonly'=>'readonly'])->label('Modelos') ?>
                <input type="hidden" name="modelId" id="modelId" value="<?= $modelModels->id_model ?>"/>

                <?= $form->field($modelInv, 'inveSN', ['options' => ['class' => 'col-lg-3 col-xs-12 col-sm-6 col-md-3']])->textInput(['maxlength' => 10,'readonly'=>'readonly']) ?>

            </div>

            <div class="row">
                <!--DESCRIPTIONS-->
                <?= $form->field($modelRepair, 'repair_desc', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->textarea(['rows' => 4,'readonly'=>'readonly'])->label("Descrição da Avaria") ?>
                <?= $form->field($modelRepair, 'obs', ['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->textarea(['rows' => 4,'readonly'=>'readonly'])->label("Outras observações") ?>
            </div>

            <div class="row">
                 <!--DESCRIPTIONS-->
                <?= $form->field($modelRepair, 'repair_done_desc', ['options' => ['class' => 'col-lg-12 col-xs-12 col-sm-12 col-md-12']])->textarea(['rows' => 4,'readonly'=>'readonly'])->label("Reparação efetuada") ?>

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
                        <?= $form->field($modelTypes, 'typeDesc', ['options' => ['class' => 'col-lg-12 col-xs-12 col-sm-12 col-md-12 required']])->textInput(['readonly'=>'readonly'])->label('Tipo de reparação')?>
                        

                        <!--BUDGET/DATE SELECTION-->
                        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 normalType" <?= (!$showBar) ? 'style="display:none;"' : null ?>>
                            <div class="row">
                                <?= $form->field($modelRepair, 'maxBudget', ['options' => ['class' => 'col-lg-12 maxBudget']])->textInput(['readonly'=>'readonly']) ?>      
                            </div>               
                            
                        </div>

                    </div>
                </div>
                
                <div class="col-lg-6 col-xs-12 col-sm-6 col-md-6 accessoriesListing">
                    <!--ACCESSORIES-->
                    <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                        <label class="control-label">Acessórios</label>
                        <?php 
                            if (isset($modelAccess) && sizeof($modelAccess)>0){?>
                            
                            <ul>
                                <?php foreach($modelAccess as $item){
                                    if ($item['accessory_id'] == 3){
                                        $isOther = true;
                                    }
                                    ?>
                                <li><?php echo $item['accessory']['accessDesc'];?></li>
                                <?php } ?>
                                
                            </ul>

                            <?php 
                                if (isset($isOther) && $isOther){
                                   echo $form->field($modelRepairAccess, 'otherDesc', ['options' => ['class' => 'col-lg-4 col-xs-4 col-sm-4 col-md-4','style'=>'display:block']])->textInput(['readonly'=>'readonly'])->label("");
                                }else{
                                   echo $form->field($modelRepairAccess, 'otherDesc', ['options' => ['class' => 'col-lg-4 col-xs-4 col-sm-4 col-md-4']])->textInput(['readonly'=>'readonly'])->label("");
                                }
                           } ?>

                        
                    </div>
                    
                </div>
            
            </div>    

             <div class="row">
            <!--WORKPRICE-->
            <?= $form->field($modelRepair, 'workPrice',['options' => ['class' => 'col-lg-6 col-xs-12 col-sm-6 col-md-6']])->textInput(['readonly'=>'readonly']) ?> 

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
                                
                                <input type="radio" name="Status[id_status]" id="status_'.$row["id_status"].'" value="'.$row["id_status"].'" '.$check.' disabled/>
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
            
        </div>
        <?php 

            if (isset($items) && sizeof($items)>0){ ?>
                <div class="partsContainer row">
                    <div class="partsAction smallSectionTitle col-lg-12">
                        Peças
                    </div>
                </div>

                <table class="partsInsert table table-striped table-bordered">
                    <thead>
                        <tr class="listHeader">
                  
                            <td>Código</td>
                            <td>Quantidade</td>
                            <td>Designação</td>
                            <td>Preço</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach($items as $i=>$item){
                            ?>
                                <tr id="line_<?php echo $i;?>">
                                    <td><?= $form->field($item,"[$i]partCode")->textInput(['readonly'=>'readonly'])->label(false) ?></td>
                                    <td><?= $form->field($item,"[$i]partQuant")->textInput(['readonly'=>'readonly'])->label(false) ?></td>
                                    <td><?= $form->field($item,"[$i]partDesc")->textInput(['readonly'=>'readonly'])->label(false) ?></td>
                                    <td><?= $form->field($item,"[$i]partPrice")->textInput(['readonly'=>'readonly'])->label(false) ?><input type="hidden" id="parts-<?php echo $i; ?>-id_part" class="form-control" name="Parts[<?php echo $i; ?>][id_part]" value="<?php echo $item->id_part;?>"></td>
                                                                    
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>

                

        <?php } ?>
        <div class="row" style="margin-top:30px;">            
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
                <table class="formTable table table-striped table-bordered">
                    <thead>
                        <tr class="listHeader">
                            <td>TOTAL</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $form->field($modelRepair, 'total',['options' => ['class' => 'col-lg-12 col-xs-12 col-sm-12 col-md-12']])->textInput(['readonly'=>'readonly'])->label(false) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php ActiveForm::end(); ?>