<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\models\Repair;


/* @var $this yii\web\View */
/* @var $model common\models\repair */

$this->title = 'Reparação Nº ' . ' ' . $modelRepair->id_repair;
$this->params['breadcrumbs'][] = ['label' => 'Reparações', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelRepair->id_repair, 'url' => ['view', 'id' => $modelRepair->id_repair]];
$this->params['breadcrumbs'][] = 'Detalhes';
?>
<section class="col-lg-10 col-xs-12 col-sm-9 col-md-9">
    <div class="row hidden-print">
        <div class="col-lg-12">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </div>
        <div class="col-lg-12">
            <div class="row repairFields viewField">

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
    if (isset($_GET['sd']) && !empty($_GET['sd']) && is_numeric($_GET['sd']) && isset($_GET['a']) && !empty($_GET['a']) && $_GET['a']=="c"){?>
        <!-- visible-print-block -->
        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12" id="printEntry">
            <div class="row header">
                <div class="col-lg-6 col-xs-6 col-sm-6 col-md-6"><img src="<?php echo Yii::$app->request->baseUrl;?>/img/logo.jpg" alt=""></div>
                <div class="col-lg-6 col-xs-6 col-sm-6 col-md-6"> 
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Entrada</th>
                                <th>Nº <?php echo $modelRepair->id_repair;?></th>
                            </tr>
                            <tr>
                                <th>Data</th>
                                <th><?php echo $modelRepair->date_entry;?></th>
                            </tr>
                            <tr>
                                <th>Local</th>
                                <th><?php echo $modelStores->storeDesc;?></th>
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
                                <th>Nome</th>
                                <th colspan="2"><?php echo $modelClient->cliName;?></th>
                            </tr>
                            <tr>
                                <th>Morada</th>
                                <th colspan="2"><?php echo $modelClient->cliAdress;?></th>
                            </tr>
                            <tr>
                                <th rowspan="3">Contacto</th>
                                <th class="setTableTitle">Fixo</th>
                                <th><?php echo $modelClient->cliConFix;?></th>
                            </tr>
                            <tr>
                                <th>Móvel1</th>
                                <th><?php echo $modelClient->cliConMov1;?></th>
                            </tr>
                            <tr>
                                <th>Móvel 2</th>
                                <th><?php echo $modelClient->cliConMov2;?></th>
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
                                <th>Equipamento</th>
                                <th><?php echo $modelEquip->equipDesc;?></th>
                                <th><?php echo $modelBrands->brandName;?></th>
                                <th><?php echo $modelModels->modelName;?></th>
                                <th><?php echo $modelInv->inveSN;?></th>
                            </tr>

                            <tr>
                                <th>Bateria</th>
                                <?php //print_r($modelAccess[1]['accessory']['accessType']);
                                $key = repair::accessType($modelAccess,'accessType',1);
                                $key1 = repair::accessType($modelAccess,'accessType',2);
                                $key2 = repair::accessType($modelAccess,'accessType',3);
                                
                                if (isset($modelAccess) && is_numeric($key)){?>
                                <th><span class="glyphicon glyphicon-ok-sign"></span></th>
                                <?php }else{ ?>
                                <th></th>
                                <?php } ?>
                                <th colspan="3" rowspan="3">asd<?php echo $modelRepair->obs;?></th>
                            </tr>
                            
                            <tr>
                                <th>Carregador</th>
                                <th>
                                    <?php if (isset($modelAccess) && is_numeric($key2)){?>
                                    <span class="glyphicon glyphicon-ok-sign"></span>
                                    <?php } ?>
                                </th>
                            </tr>

                            <tr>
                                <th>Outro</th>
                                <?php if (isset($modelAccess) && is_numeric($key1)){?>
                                <th><?php echo $modelAccess[$key1]['otherDesc'];?></th>
                                <?php }else{ ?>
                                <th></th>
                                <?php } ?>
                            </tr>
                            
                        </tbody>
                    </table>

                    <table class="table table-bordered repairDesc">
                        <thead>                    
                            <tr>
                                <th>Avaria</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <th><?php echo $modelRepair->repair_desc;?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row foote">
                <div class="col-lg-6 col-xs-6 col-sm-6 col-md-6"><img src="<?php echo Yii::$app->request->baseUrl;?>/img/logo.jpg" alt=""></div>
                <div class="col-lg-6 col-xs-6 col-sm-6 col-md-6"> 
                    <table class="table table-bordered">
                        <tbody>
                             <tr>
                                <th>Entrada</th>
                                <th>Nº <?php echo $modelRepair->id_repair;?></th>
                            </tr>
                            <tr>
                                <th>Data</th>
                                <th><?php echo $modelRepair->date_entry;?></th>
                            </tr>
                            <tr>
                                <th>Local</th>
                                <th><?php echo $modelStores->storeDesc;?></th>
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
    <?php } ?>
</div>