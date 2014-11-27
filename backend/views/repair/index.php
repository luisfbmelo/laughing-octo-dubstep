<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\helpers\Url;
use common\models;
use yii\helpers\ArrayHelper;

use common\models\Stores;
use common\models\Status;
use common\models\Repair;
use common\models\Client;


setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
date_default_timezone_set('Atlantic/Azores');

//get user group and define buttons
if (\Yii::$app->session->get('user.group')!=3){ 
    $template = '{view}{update}{delete}';
}else{
    $template = '{view}';
}

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lista de reparações';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="col-lg-10 col-xs-12 col-sm-9 col-md-9">
    <div class="row hidden-print">


        <div class="col-lg-2 col-xs-4 col-sm-4 col-md-4">
            <a href="<?php echo Url::to(['repair/create']); ?>" class="topBtn">
                <div class="btnEl">

                    <?php //Html::a('Nova reparação', ['create'], ['class' => 'btn btn-success']) ?>
                    <div class="glyphicon glyphicon-pencil"></div>   
                    <div class="bButtonTitle">Nova reparação</div>

                </div>
                
            </a>
        </div>
        <div class="col-lg-2 col-xs-4 col-sm-4 col-md-4">
            <a href="<?php echo Url::to(['repair/search']); ?>" class="topBtn">
                <div class="btnEl">

                    <?php //Html::a('Nova reparação', ['create'], ['class' => 'btn btn-success']) ?>
                    <div class="glyphicon glyphicon-search"></div>   
                    <div class="bButtonTitle">Pesquisar</div>

                </div>
            </a>
        </div>
    </div>
    <div class="row hidden-print">
        <div class="col-lg-12">
             <div class="repair-index">
                <h1 class="sectionTitle"><?= Html::encode($this->title) ?></h1>  

                <!-- <input type="button" value="Eliminar" class="btn btn-danger deleteBtn"/> -->  
                <div class="btn btn-danger deleteBtn">
                    <span class="glyphicon glyphicon-trash"></span>
                </div>

                <?php if (isset($_GET['SearchRepair'])){?>
                    <a href="<?php echo Yii::$app->request->baseUrl;?>/repair/index" class="btn btn-default clearBtn">
                        <span>Limpar</span>
                    </a>
                <?php } ?>

                <?= 



                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        //['class' => 'yii\grid\SerialColumn'],
                        ['class' => CheckboxColumn::className()],
                        
                        'id_repair',
                        //'type_id',
                        //'client_id',
                        //'inve_id',
                        'repair_desc:ntext',
                        [
                            'attribute' => 'store_id',
                            'label' => 'Local',
                            'filter' => ArrayHelper::map(stores::find()->asArray()->orderBy('storeDesc ASC')->all(), 'id_store', 'storeDesc'),
                            'content' => function($model, $index, $dataColumn) {
                                return $model->getStoreDesc()["storeDesc"];
                            },

                        ],
                        [
                            //data from other modules tables
                            'attribute' => 'client',
                            'label' => 'Cliente',
                            /*'content' => function($model, $index, $dataColumn) {
                                return $model->getClientName()["cliName"];
                            }*/
                            'value' => 'client.cliName'

                        ],

                        [
                            'attribute' => 'date_entry'/*,
                            'label' => 'Entrada',
                            'content' => function($model, $index, $dataColumn){
                                return $model->getArrangedDate();
                            }*/
                        ],

                        [
                            'attribute' => 'username',
                            'label' => 'Utilizador',
                            'value' => 'user.username'
                        ],
                        
                        //'date_entry',
                        [
                            'attribute' => 'status_id',
                            'label' => 'Estado',
                            'filter' => ArrayHelper::map(status::find()->asArray()->orderBy('id_status ASC')->all(), 'id_status','statusDesc'),
                            'content' => function($model, $index, $dataColumn) {
                                return $status = "<div class='status_".$model->status_id."'><span class='circle'></span><span>".$model->getStatusDesc()["statusDesc"]."</span><span class='clearAll'></span></div>";
                            },                           
                            
                        ],
                        // 'date_close',
                        // 'store_id',
                        // 'priority',
                        // 'budget',
                        // 'maxBudget',
                        // 'total',

                        ['class' => 'yii\grid\ActionColumn',
                            'template' => $template
                        ],
                    ],

                    /*'rowOptions' => function ($model, $index, $widget, $grid){
                        return ['class' => 'status_'.$model->status_id];
                    },*/
                    'filterModel' => $searchModel,
                    'headerRowOptions' =>['class'=>'listHeader'],
                    'options' => [
                        'class' => 'grid_listing',
                    ]
                ]); ?>

            </div>
        </div>
    </div>
   <?php 

    if (isset($modelRepair) && !empty($modelRepair) && $modelRepair!=null){

        switch($requestType){
            //IF IS A NEW REPAIR
            case "newEl":
        ?>
            <!-- visible-print-block -->
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12" id="printEntry">
                <div class="row header">
                    <div class="col-lg-6 col-xs-6 col-sm-6 col-md-6"><img src="<?php echo Yii::$app->request->baseUrl;?>/img/logo.jpg" alt=""></div>
                    <div class="col-lg-6 col-xs-6 col-sm-6 col-md-6"> 
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Entrada</td>
                                    <td>Nº <?php echo $modelRepair[0]['id_repair'];?></td>
                                </tr>
                                <tr>
                                    <td>Data</td>
                                    <td><?php echo $modelRepair[0]['date_entry'];?></td>
                                </tr>
                                <tr>
                                    <td>Local</td>
                                    <td><?php echo $modelRepair[0]['storeDesc'];?></td>
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
                                    <td colspan="2"><?php echo $modelRepair[0]['cliName'];?></td>
                                </tr>
                                <tr>
                                    <td>Morada</td>
                                    <td colspan="2"><?php echo $modelRepair[0]['cliAdress'];?></td>
                                </tr>
                                <tr>
                                    <td rowspan="3">Contacto</td>
                                    <td class="setTableTitle">Fixo</td>
                                    <td><?php echo $modelRepair[0]['cliConFix'];?></td>
                                </tr>
                                <tr>
                                    <td>Móvel1</td>
                                    <td><?php echo $modelRepair[0]['cliConMov1'];?></td>
                                </tr>
                                <tr>
                                    <td>Móvel 2</td>
                                    <td><?php echo $modelRepair[0]['cliConMov2'];?></td>
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
                                    <td><?php echo $modelRepair[0]['equipDesc'];?></td>
                                    <td><?php echo $modelRepair[0]['brandName'];?></td>
                                    <td><?php echo $modelRepair[0]['modelName'];?></td>
                                    <td><?php echo $modelRepair[0]['inveSN'];?></td>
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
                                    <td colspan="3" rowspan="3">asd<?php echo $modelRepair[0]['obs'];?></td>
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

                        <table class="table table-bordered repairDesc">
                            <thead>                    
                                <tr>
                                    <td>Avaria</td>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td><?php echo $modelRepair[0]['repair_desc'];?></td>
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
                                    <td>Entrada</td>
                                    <td>Nº <?php echo $modelRepair[0]['id_repair'];?></td>
                                </tr>
                                <tr>
                                    <td>Data</td>
                                    <td><?php echo $modelRepair[0]['date_entry'];?></td>
                                </tr>
                                <tr>
                                    <td>Local</td>
                                    <td><?php echo $modelRepair[0]['storeDesc'];?></td>
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
                        setTimeout(function () { window.location.href = window.location.href.split('?')[0]; }, 100);

                        document.body.innerHTML = originalContents;
                    }
              
            </script>
        <?php
            break;

            //IF IS A CLOSING ELEMENT
            case "closeEl":?>
                <!-- visible-print-block -->
                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 visible-print-block" id="printEntry">
                    <div class="row header">
                        <div class="col-lg-6 col-xs-6 col-sm-6 col-md-6"><img src="<?php echo Yii::$app->request->baseUrl;?>/img/logo.jpg" alt=""></div>
                        <div class="col-lg-6 col-xs-6 col-sm-6 col-md-6"> 
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Entrada</td>
                                        <td>Nº <?php echo $modelRepair[0]['id_repair'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Data</td>
                                        <td><?php echo $modelRepair[0]['date_entry'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Local</td>
                                        <td><?php echo $modelRepair[0]['storeDesc'];?></td>
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
                                        <td colspan="2"><?php echo $modelRepair[0]['cliName'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Morada</td>
                                        <td colspan="2"><?php echo $modelRepair[0]['cliAdress'];?></td>
                                    </tr>
                                    <tr>
                                        <td rowspan="3">Contacto</td>
                                        <td class="setTableTitle">Fixo</td>
                                        <td><?php echo $modelRepair[0]['cliConFix'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Móvel1</td>
                                        <td><?php echo $modelRepair[0]['cliConMov1'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Móvel 2</td>
                                        <td><?php echo $modelRepair[0]['cliConMov2'];?></td>
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
                                        <td><?php echo $modelRepair[0]['equipDesc'];?></td>
                                        <td><?php echo $modelRepair[0]['brandName'];?></td>
                                        <td><?php echo $modelRepair[0]['modelName'];?></td>
                                        <td><?php echo $modelRepair[0]['inveSN'];?></td>
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
                                        <td colspan="3" rowspan="3"><?php echo $modelRepair[0]['obs'];?></td>
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

                                    <tr>
                                        <td>Orçamento</td>
                                        <td colspan="4" class="priceTag"><?php echo $modelRepair[0]['budget'];?></td>
                                    </tr>
                                    
                                </tbody>
                            </table>

                            <table class="table table-bordered repairDesc">
                                <thead>                    
                                    <tr>
                                        <td>Avaria</td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td><?php echo $modelRepair[0]['repair_desc'];?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <?php if (isset($items) && sizeof($items)>0){?>
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
                                        <td><?php echo $item['partCode'];?></td>
                                        <td><?php echo $item['partQuant'];?></td>
                                        <td><?php echo $item['partDesc'];?></td>
                                        <td class="priceTag"><?php echo $item['partPrice'];?></td>
                                                                        
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
                                        <td class="priceTag"><?php echo $modelRepair[0]['total'];?></td>
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
                            setTimeout(function () { window.location.href = window.location.href.split('?')[0]; }, 100);

                            document.body.innerHTML = originalContents;
                        }
                  
                </script>


        <?php
            break;
        }
    }?>
</section>

<script>
    $(document).ready(function(){
        $(".deleteBtn").click(function(){
            var urlBase = '<?php echo Yii::$app->request->baseUrl;?>';
            var urlDest = urlBase+'/repair/delajax';

            //get all selected elements
            var idList = $('input[type=checkbox][name="selection\\[\\]"]:checked').map(function () {
                return $(this).val();
            }).get();
            //var idList = $("input[type=checkbox]:checked").val();
            console.log(idList);
            //if exists
            if(idList!="")
            {
                if(confirm("Deseja realmente excluir este item?"))
                {
                    $.ajax({
                        url: urlDest,
                        type:"POST",
                        dataType: 'json',
                        data:{ list: idList},
                        success: function(data){
                            console.log(data);
                            if (data=="done"){
                                $(".overlay").css("display","block");
                                $(".ajaxMes").css("display","block");
                                $(".ajaxMes").delay(2000).fadeOut(500,function(){
                                    window.location = window.location.href;
                                });
                            }
                        },
                        error: function(){

                        }
                    });
                }
            }
        });
    });
</script>