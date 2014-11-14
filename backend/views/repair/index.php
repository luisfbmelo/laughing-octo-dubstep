<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\helpers\Url;
use common\models;
use yii\helpers\ArrayHelper;

use common\models\Stores;
use common\models\Status;



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
            <a href="<?php echo Url::to(['repair/create']); ?>" class="topBtn">
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
    if (isset($_GET['sd']) && !empty($_GET['sd']) && is_numeric($_GET['sd']) && isset($_GET['a']) && !empty($_GET['a'])){
        switch($_GET['a']){
            case 'n':
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
                                <th>Nº 9999</th>
                            </tr>
                            <tr>
                                <th>Data</th>
                                <th>31-12-2014</th>
                            </tr>
                            <tr>
                                <th>Local</th>
                                <th>Angra</th>
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
                                <th colspan="2">Paulo Belem</th>
                            </tr>
                            <tr>
                                <th>Morada</th>
                                <th colspan="2">Rua da Cruz Dourada</th>
                            </tr>
                            <tr>
                                <th rowspan="3">Contacto</th>
                                <th>Fixo</th>
                                <th>295 000 000</th>
                            </tr>
                            <tr>
                                <th>Móvel1</th>
                                <th>000000000</th>
                            </tr>
                            <tr>
                                <th>Móvel 2</th>
                                <th>00000000</th>
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
                                <th>Telemovel</th>
                                <th>Nokia</th>
                                <th>Lumia 654</th>
                                <th>00000000</th>
                            </tr>
                            <tr>
                                <th>Bateria</th>
                                <th><span class="glyphicon glyphicon-ok-sign"></span></th>
                                <th colspan="2" rowspan="3">Observações</th>
                            </tr>
                            <tr>
                                <th>Carregador</th>
                                <th><span class="glyphicon glyphicon-ok-sign"></span></th>
                            </tr>
                            <tr>
                                <th>Outro</th>
                                <th>Cabos, capa</th>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <thead>                    
                            <tr>
                                <th>Avaria</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <th>Descrição da avaria</th>
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
                                <th>Nº 9999</th>
                            </tr>
                            <tr>
                                <th>Data</th>
                                <th>31-12-2014</th>
                            </tr>
                            <tr>
                                <th>Local</th>
                                <th>Angra</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
           
                //print showing div
                //printDiv("printEntry");
                
                function printDiv(divName) {
                     var printContents = document.getElementById(divName).innerHTML;
                     var originalContents = document.body.innerHTML;

                     document.body.innerHTML = printContents;

                     window.print();

                     document.body.innerHTML = originalContents;
                }
          
        </script>

        <?php break; 
}}?>
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