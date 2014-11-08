<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\helpers\Url;
use common\models;


setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
date_default_timezone_set('Atlantic/Azores');


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lista de reparações';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="col-lg-10 col-xs-12 col-sm-9 col-md-9">
    <div class="row">


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
    <div class="row">
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
                            'attribute' => 'date_entry',
                            'label' => 'Entrada',
                            'content' => function($model, $index, $dataColumn){
                                return $model->getArrangedDate();
                            }
                        ],
                        
                        //'date_entry',
                        [
                            'attribute' => 'status_id',
                            'label' => 'Estado',
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
                    'filterModel' => $dataProvider,
                    'headerRowOptions' =>['class'=>'listHeader'],
                    'options' => [
                        'class' => 'repairsGrid',
                    ]
                ]); ?>

            </div>
        </div>
    </div>
   
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