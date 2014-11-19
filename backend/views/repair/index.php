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


setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
date_default_timezone_set('Atlantic/Azores');


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

                <input type="button" value="Eliminar" class="btn btn-danger deleteBtn"/>      

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
                            'attribute' => 'user_id',
                            'label' => 'Entrada por:',
                            'content' => function($model, $index, $dataColumn) {
                                return $model->getUserName()["username"];
                            }

                        ],

                        [
                            'attribute' => 'date_entry'/*,
                            'label' => 'Entrada',
                            'content' => function($model, $index, $dataColumn){
                                return $model->getArrangedDate();
                            }*/
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

                        ['class' => 'yii\grid\ActionColumn'],
                    ],

                    /*'rowOptions' => function ($model, $index, $widget, $grid){
                        return ['class' => 'status_'.$model->status_id];
                    },*/
                    'filterModel' => $searchModel,
                    'headerRowOptions' =>['class'=>'listHeader'],
                    'options' => [
                        'class' => 'repairsGrid',
                    ]
                ]); ?>

            </div>
        </div>
    </div>
   <?php 
    if (isset($modelRepair) && !empty($modelRepair) && $modelRepair!=null){
        ?>
        <!-- visible-print-block -->
        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 visible-print-block" id="printEntry">
            <div class="row header">
                <div class="col-lg-6 col-xs-6 col-sm-6 col-md-6"><img src="<?php echo Yii::$app->request->baseUrl;?>/img/logo.jpg" alt=""></div>
                <div class="col-lg-6 col-xs-6 col-sm-6 col-md-6"> 
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Entrada</th>
                                <th>Nº <?php echo $modelRepair[0]['id_repair'];?></th>
                            </tr>
                            <tr>
                                <th>Data</th>
                                <th><?php echo $modelRepair[0]['date_entry'];?></th>
                            </tr>
                            <tr>
                                <th>Local</th>
                                <th><?php echo $modelRepair[0]['storeDesc'];?></th>
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
                                <th colspan="2"><?php echo $modelRepair[0]['cliName'];?></th>
                            </tr>
                            <tr>
                                <th>Morada</th>
                                <th colspan="2"><?php echo $modelRepair[0]['cliAdress'];?></th>
                            </tr>
                            <tr>
                                <th rowspan="3">Contacto</th>
                                <th class="setTableTitle">Fixo</th>
                                <th><?php echo $modelRepair[0]['cliConFix'];?></th>
                            </tr>
                            <tr>
                                <th>Móvel1</th>
                                <th><?php echo $modelRepair[0]['cliConMov1'];?></th>
                            </tr>
                            <tr>
                                <th>Móvel 2</th>
                                <th><?php echo $modelRepair[0]['cliConMov2'];?></th>
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
                                <th><?php echo $modelRepair[0]['equipDesc'];?></th>
                                <th><?php echo $modelRepair[0]['brandName'];?></th>
                                <th><?php echo $modelRepair[0]['modelName'];?></th>
                                <th><?php echo $modelRepair[0]['inveSN'];?></th>
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
                                <th colspan="3" rowspan="3">asd<?php echo $modelRepair[0]['obs'];?></th>
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
                                <th><?php echo $modelRepair[0]['repair_desc'];?></th>
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
                                <th>Nº <?php echo $modelRepair[0]['id_repair'];?></th>
                            </tr>
                            <tr>
                                <th>Data</th>
                                <th><?php echo $modelRepair[0]['date_entry'];?></th>
                            </tr>
                            <tr>
                                <th>Local</th>
                                <th><?php echo $modelRepair[0]['storeDesc'];?></th>
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