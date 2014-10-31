<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lista de reparações';
$this->params['breadcrumbs'][] = $this->title;
?>
<!--ACTION MESSAGES-->
<?php if(Yii::$app->session->hasFlash('addedProj')): ?>
<div class="statusBox">
    <div class="statusMessage flash-success">
        <?php echo Yii::app()->session->getFlash('addedProj'); ?>
    </div>
</div>
<?php endif; ?>

<?php if(Yii::$app->session->hasFlash('updatedProj')): ?>
<div class="statusBox">
    <div class="statusMessage flash-success">
        <?php echo Yii::$app->session->getFlash('updatedProj'); ?>
    </div>
</div>
<?php endif; ?>

<?php if(Yii::$app->session->hasFlash('deleteProj')): ?>
    <div class="statusBox">
    <div class="statusMessage flash-success">
        <?php echo Yii::$app->session->getFlash('deleteProj'); ?>
    </div>
    </div>
<?php endif; ?>
<div class="statusBox ajaxMes">
    <div class="statusMessage flash-success">
        Projeto eliminado com sucesso.
    </div>
</div>
<!--END ACTION MESSAGES-->

<section class="col-lg-10 col-xs-12 col-sm-8 col-md-8">
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

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        //['class' => 'yii\grid\SerialColumn'],
                        ['class' => CheckboxColumn::className()],
                        'id_repair',
                        //'type_id',
                        //'client_id',
                        //'inve_id',
                        'status',
                        'user_id',
                        'repair_desc:ntext',
                        'date_entry',
                        // 'date_close',
                        // 'store_id',
                        // 'priority',
                        // 'budget',
                        // 'maxBudget',
                        // 'total',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                    'filterModel' => $dataProvider,
                    'headerRowOptions' =>['class'=>'listHeader'],
                    'options' => [
                        'class' => 'gridView',
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
            var urlDest = urlBase+'/repair/delete';

            //get all selected elements
            var idList = $('input[type=checkbox]:checked').map(function () {
                return $(this).val();
            }).get();
            //var idList = $("input[type=checkbox]:checked").val();

            //if exists
            if(idList1="")
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