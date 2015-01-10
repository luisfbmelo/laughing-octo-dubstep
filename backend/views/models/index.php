<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $searchModel common\models\Models */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Modelos';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="col-lg-10 col-xs-12 col-sm-9 col-md-9">
    <div class="row">
        <div class="col-lg-12">
             <div class="repair-index">
                <h1 class="sectionTitle"><?= Html::encode($this->title) ?></h1>  

                <!-- <input type="button" value="Eliminar" class="btn btn-danger deleteBtn"/> --> 

                <div class="btn btn-danger deleteBtn">
                    <span class="glyphicon glyphicon-trash"></span>
                </div>

                <?php if (isset($_GET['SearchModels'])){?>
                    <a href="<?php echo Yii::$app->request->baseUrl;?>/models/index" class="btn btn-default clearBtn">
                        <span>Limpar</span>
                    </a>
                    <div class="clear"></div>
                <?php } ?>

            
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'headerRowOptions' =>['class'=>'listHeader'],
                    'options' => [
                        'class' => 'grid_listing',
                    ],
                    'columns' => [
                        ['class' => CheckboxColumn::className()],
                        [
                            'attribute' => 'id_model',
                            'label' => 'Nº do modelo',                        
                        ],
                        
                        'modelName:ntext',

                        ['class' => 'yii\grid\ActionColumn',
                            'template' => '{delete}'
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
            var urlDest = urlBase+'/models/delajax';

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
                            if (data=="done"){
                                $(".overlay").css("display","block");
                                $(".ajaxSucc").css("display","block");
                                $(".ajaxSucc").delay(5000).fadeOut(500,function(){
                                    window.location = window.location.href;
                                });
                            }else{
                                $(".overlay").css("display","block");
                                $(".ajaxError").css("display","block");
                                $(".ajaxError").delay(5000).fadeOut(500,function(){
                                   $(this).css("display","none");
                                   $(".overlay").css("display","none");
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
