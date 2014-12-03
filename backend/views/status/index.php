<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Estados';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="col-lg-10 col-xs-12 col-sm-9 col-md-9">
    <div class="row">
        <div class="col-lg-12">
             <div class="repair-index">
                <h1 class="sectionTitle"><?= Html::encode($this->title) ?></h1>  

                <!-- <input type="button" value="Eliminar" class="btn btn-danger deleteBtn"/> --> 
                <?= Html::a('<span class="glyphicon glyphicon-plus"></span>', ['create'], ['class' => 'btn btn-success addBtn']) ?>

                <div class="btn btn-danger deleteBtn">
                    <span class="glyphicon glyphicon-trash"></span>
                </div>

                <?php if (isset($_GET['StatusSearch'])){?>
                    <a href="<?php echo Yii::$app->request->baseUrl;?>/status/index" class="btn btn-default clearBtn">
                        <span>Limpar</span>
                    </a>
                <?php } ?>

                <?php
                    $types = array(
                    0=>array('id'=>"1",'desc'=>'Normal'),
                    1=>array('id'=>"2",'desc'=>'Terminado'),
                    2=>array('id'=>"3",'desc'=>'Fecho'));
                ?>
                <?=                

                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'headerRowOptions' =>['class'=>'listHeader'],
                    'options' => [
                        'class' => 'grid_listing',
                    ],
                    'columns' => [
                        ['class' => CheckboxColumn::className()],
                        'id_status',
                        [
                            'attribute' => 'statusDesc',
                            'label' => 'Estado',
                            'content' => function($model, $index, $dataColumn) {
                                return $status = "<div class='status-color'><span class='circle' style='background-color:#".$model->color.";'></span><span>".$model->statusDesc."</span><span class='clearAll'></span></div>";
                            },                           
                            
                        ],

                        [
                            'attribute' => 'type',
                            'label' => 'Tipo de estado',
                            'filter' => ArrayHelper::map($types, 'id', 'desc'),
                            'content' => function($model, $index, $dataColumn) {
                                return $model->convertType();
                            },                           
                            
                        ],

                        ['class' => 'yii\grid\ActionColumn',
                            'template' => '{update}{delete}'
                        ],                      

                    ],
                ]); ?>

            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        $(".deleteBtn").click(function(){
            var urlBase = '<?php echo Yii::$app->request->baseUrl;?>';
            var urlDest = urlBase+'/status/delajax';

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
