<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\models\Repair;


/* @var $this yii\web\View */
/* @var $model common\models\repair */

$this->title = 'Reparação Nº ' . ' ' . $modelRepair->id_repair;
if (\Yii::$app->session->get('lastAction')=="warranty" || \Yii::$app->session->get('lastAction')=="pickup"){
    $this->params['breadcrumbs'][] = ['label' => 'Reparações', 'url' => ["warning/".\Yii::$app->session->get('lastAction')]];
}else{
    $this->params['breadcrumbs'][] = ['label' => 'Reparações', 'url' => [\Yii::$app->session->get('lastAction')]];
}

$this->params['breadcrumbs'][] = ['label' => $modelRepair->id_repair, 'url' => ['view', 'id' => $modelRepair->id_repair]];
$this->params['breadcrumbs'][] = 'Detalhes';
?>
<section class="col-lg-10 col-xs-12 col-sm-8 col-md-8">
    <div class="row hidden-print">
        <div class="col-lg-12">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="repairFields viewField">

                <h1 class="sectionTitle col-lg-12"><?= Html::encode($this->title) ?></h1>

                <?=
                
                 $this->render('_formView', [
                    'modelRepair' => $modelRepair,
                    'modelClient' => $modelClient,
                    'stores' => $allStores,
                    'types' => $allTypes,
                    'statusAll' => $allStatus,
                    'accessories' => $allAccess,
                    'modelStores' => $modelStores,
                    'modelBrands' => $modelBrands,
                    'modelEquip' => $modelEquip,
                    'modelModels' => $modelModels,
                    'modelTypes' => $modelTypes,
                    'modelInv' => $modelInv,
                    'modelAccess' => $modelAccess,
                    'modelRepairAccess' => $modelRepairAccess,
                    'modelStatus' => $modelStatus,
                    'modelParts' => $modelParts,
                    'isOk' => $isOk,
                    'items' => $items
                ]) ?>

            </div>
        </div>
    </div>
    <?php
    if (isset($_GET['sd']) && !empty($_GET['sd']) && is_numeric($_GET['sd']) && isset($_GET['a']) && !empty($_GET['a'])){

        switch($_GET['a']){
            case "n":      

        ?>
        <!-- visible-print-block -->
        <div class="row">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 visible-print-block" id="printEntry">
                <div class="row header">
                    <div class="col-lg-6 col-xs-5 col-sm-6 col-md-6"><img src="<?php echo Yii::$app->request->baseUrl;?>/img/logo.jpg" alt=""></div>
                    <div class="col-lg-6 col-xs-7 col-sm-6 col-md-6"> 
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Entrada</td>
                                    <td>Nº <?php echo $modelRepair->id_repair;?></td>
                                </tr>
                                <tr>
                                    <td>Data</td>
                                    <td><?php echo date("Y-m-d", strtotime($modelRepair->date_entry));?></td>
                                </tr>
                                <tr>
                                    <td>Local</td>
                                    <td><?php echo $modelStores->storeDesc;?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row client_data_table">
                    <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Nome</td>
                                    <td colspan="2"><?php echo $modelClient->cliName;?></td>
                                </tr>
                                <tr>
                                    <td>Morada</td>
                                    <td colspan="2"><?php echo $modelClient->cliAdress;?></td>
                                </tr>
                                <tr>
                                    <td rowspan="3">Contacto</td>
                                    <td class="setTableTitle">Fixo</td>
                                    <td><?php echo $modelClient->cliConFix;?></td>
                                </tr>
                                <tr>
                                    <td>Móvel1</td>
                                    <td><?php echo $modelClient->cliConMov1;?></td>
                                </tr>
                                <tr>
                                    <td>Móvel 2</td>
                                    <td><?php echo $modelClient->cliConMov2;?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row repair_details_table">
                    <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Equipamento</td>
                                    <td><?php echo $modelEquip->equipDesc;?></td>
                                    <td><?php echo $modelBrands->brandName;?></td>
                                    <td><?php echo $modelModels->modelName;?></td>
                                    <td><?php echo $modelInv->inveSN;?></td>
                                </tr>

                                <tr>
                                    <td>Bateria</td>
                                    <?php //print_r($modelAccess[1]['accessory']['accessType']);
                                    $key = repair::accessType($modelAccess,'accessType',1);
                                    $key1 = repair::accessType($modelAccess,'accessType',2);
                                    $key2 = repair::accessType($modelAccess,'accessType',3);
                                    
                                    if (isset($modelAccess) && is_numeric($key)){?>
                                    <td><span class="glyphicon glyphicon-ok-sign"></span></td>
                                    <?php }else{ ?>
                                    <td></td>
                                    <?php } ?>
                                    <td colspan="3" rowspan="3"><?php echo $modelRepair->repair_desc;?></td>
                                </tr>
                                
                                <tr>
                                    <td>Carregador</td>
                                    <td>
                                        <?php if (isset($modelAccess) && is_numeric($key2)){?>
                                        <span class="glyphicon glyphicon-ok-sign"></span>
                                        <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Outro</td>
                                    <?php if (isset($modelAccess) && is_numeric($key1)){?>
                                    <td><?php echo $modelAccess[$key1]['otherDesc'];?></td>
                                    <?php }else{ ?>
                                    <td></td>
                                    <?php } ?>
                                </tr>
                                
                            </tbody>
                        </table>

                        <?php if (!empty($modelRepair->obs)){ ?>
                            <table class="table table-bordered repairDesc">
                                <thead>                    
                                    <tr>
                                        <td>Outras observações</td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td><?php echo $modelRepair->obs;?></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php } ?>

                        
                    </div>
                </div>

                <div class="row foote">
                    <div class="col-lg-6 col-xs-5 col-sm-6 col-md-6"><img src="<?php echo Yii::$app->request->baseUrl;?>/img/logo.jpg" alt=""></div>
                    <div class="col-lg-6 col-xs-7 col-sm-6 col-md-6"> 
                        <table class="table table-bordered">
                            <tbody>
                                 <tr>
                                    <td>Entrada</td>
                                    <td>Nº <?php echo $modelRepair->id_repair;?></td>
                                </tr>
                                <tr>
                                    <td>Data</td>
                                    <td><?php echo date("Y-m-d", strtotime($modelRepair->date_entry));?></td>
                                </tr>
                                <tr>
                                    <td>Local</td>
                                    <td><?php echo $modelStores->storeDesc;?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <script>
               
                    //print showing div
                    printDiv("printEntry");      

                    function printDiv(divName) {
                        var printContents = document.getElementById(divName).innerHTML;
                        var originalContents = document.body.innerHTML;

                        document.body.innerHTML = printContents;

                        window.print();
                        setTimeout(function () { window.location.href = window.location.href.split('&')[0]; }, 100);

                        document.body.innerHTML = originalContents;
                    }
              
            </script>
        </div>

        <?php break;

        case "c":
        ?>

            <div class="row">
                <!-- visible-print-block -->
                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 visible-print-block" id="printEntry">
                    <div class="row header">
                        <div class="col-lg-6 col-xs-5 col-sm-6 col-md-6"><img src="<?php echo Yii::$app->request->baseUrl;?>/img/logo.jpg" alt=""></div>
                        <div class="col-lg-6 col-xs-7 col-sm-6 col-md-6"> 
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Entrega</td>
                                        <td>Nº <?php echo $modelRepair->getDeliveryId($modelRepair->id_repair);?></td>
                                    </tr>
                                    <tr>
                                        <td>Data</td>
                                        <td><?php echo date("Y-m-d", strtotime($modelRepair->date_entry));?></td>
                                    </tr>
                                    <tr>
                                        <td>Local</td>
                                        <td><?php echo $modelStores->storeDesc;?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row client_data_table">
                        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Nome</td>
                                        <td colspan="2"><?php echo $modelClient->cliName;?></td>
                                    </tr>
                                    <tr>
                                        <td>Morada</td>
                                        <td colspan="2"><?php echo $modelClient->cliAdress;?></td>
                                    </tr>
                                    <tr>
                                        <td rowspan="3">Contacto</td>
                                        <td class="setTableTitle">Fixo</td>
                                        <td><?php echo $modelClient->cliConFix;?></td>
                                    </tr>
                                    <tr>
                                        <td>Móvel1</td>
                                        <td><?php echo $modelClient->cliConMov1;?></td>
                                    </tr>
                                    <tr>
                                        <td>Móvel 2</td>
                                        <td><?php echo $modelClient->cliConMov2;?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row repair_details_table">
                        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Equipamento</td>
                                        <td><?php echo $modelEquip->equipDesc;?></td>
                                        <td><?php echo $modelBrands->brandName;?></td>
                                        <td><?php echo $modelModels->modelName;?></td>
                                        <td><?php echo $modelInv->inveSN;?></td>
                                    </tr>

                                    <tr>
                                        <td>Bateria</td>
                                        <?php //print_r($modelAccess[1]['accessory']['accessType']);
                                        $key = repair::accessType($modelAccess,'accessType',1);
                                        $key1 = repair::accessType($modelAccess,'accessType',2);
                                        $key2 = repair::accessType($modelAccess,'accessType',3);
                                        
                                        if (isset($modelAccess) && is_numeric($key)){?>
                                        <td><span class="glyphicon glyphicon-ok-sign"></span></td>
                                        <?php }else{ ?>
                                        <td></td>
                                        <?php } ?>
                                        <td colspan="3" rowspan="3"><?php echo $modelRepair->obs;?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Carregador</td>
                                        <td>
                                            <?php if (isset($modelAccess) && is_numeric($key2)){?>
                                            <span class="glyphicon glyphicon-ok-sign"></span>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Outro</td>
                                        <?php if (isset($modelAccess) && is_numeric($key1)){?>
                                        <td><?php echo $modelRepairAccess->otherDesc;?></td>
                                        <?php }else{ ?>
                                        <td></td>
                                        <?php } ?>
                                    </tr>                                    
                                </tbody>
                            </table>

                            <table class="table table-bordered repairDesc">
                                <thead>                    
                                    <tr>
                                        <td>Reparação efetuada</td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td><?php echo $modelRepair->repair_done_desc;?></td>
                                        <!-- <td><?php //echo $modelRepair->repair_desc;?></td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <?php if (isset($items) && sizeof($items)>0){?>

                    <table class="partsInsert table table-striped table-bordered">
                        <thead>
                            <tr class="listHeader">
                                <td colspan="4" style="font-weight:bold;">Peças</td>
                            </tr>
                            <tr class="listHeader">
                                <td>Código</td>
                                <td>Quantidade</td>
                                <td>Designação</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                             
                                foreach($items as $i=>$item){
                                ?>
                                    <tr id="line_<?php echo $i;?>">
                                        <td><?php echo $item['partCode'];?></td>
                                        <td><?php echo $item['partQuant'];?></td>
                                        <td><?php echo $item['partDesc'];?></td>                                                                        
                                    </tr>
                            <?php }?>
                                   
                        </tbody>
                    </table>
                    <?php } ?>
                
                    <div class="row repairTotal">
                        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>                                    
                                        <td class="showTotal">Total</td>
                                        <td class="priceTag"><?php echo $modelRepair->total;?></td>
                                    </tr>                                    
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <script>
                   
                        //print showing div
                        printDiv("printEntry");      

                        function printDiv(divName) {
                            var printContents = document.getElementById(divName).innerHTML;
                            var originalContents = document.body.innerHTML;

                            document.body.innerHTML = printContents;

                            window.print();
                            setTimeout(function () { window.location.href = window.location.href.split('&')[0]; }, 100);

                            document.body.innerHTML = originalContents;
                        }
                  
                </script>
            </div>

    <?php break;}} ?>
</section>