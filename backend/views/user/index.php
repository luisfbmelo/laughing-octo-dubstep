<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\helpers\ArrayHelper;

use common\models\Groups;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Utilizadores';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="col-lg-10 col-xs-12 col-sm-9 col-md-9">
    <div class="row">
        <div class="col-lg-12">
             <div class="repair-index">
                <h1 class="sectionTitle"><?= Html::encode($this->title) ?></h1>  

                <!-- <input type="button" value="Eliminar" class="btn btn-danger deleteBtn"/> --> 
                <?= Html::a('<span class="glyphicon glyphicon-plus"></span>', ['create'], ['class' => 'btn btn-success createUserBtn']) ?>

                <div class="btn btn-danger deleteBtn">
                    <span class="glyphicon glyphicon-trash"></span>
                </div>

                

                <?php if (isset($_GET['SearchRepair'])){?>
                    <a href="<?php echo Yii::$app->request->baseUrl;?>/repair/index" class="btn btn-default clearBtn">
                        <span>Limpar</span>
                    </a>
                <?php } ?>



                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'headerRowOptions' =>['class'=>'listHeader'],
                    'options' => [
                        'class' => 'grid_listing',
                    ],
                    'columns' => [
                        //['class' => 'yii\grid\SerialColumn'],
                        ['class' => CheckboxColumn::className()],

                        //'id_users',
                        'username',
                        'email:email',
                        //'password_hash',
                        [
                            'attribute' => 'group_id',
                            'label' => 'Privilégios',
                            'filter' => ArrayHelper::map(groups::find()->asArray()->orderBy('id_group ASC')->all(), 'id_group','groupType'),
                            'content' => function($model, $index, $dataColumn) {
                                return $model->getThisGroup()['groupType'];
                            },                           
                            
                        ],
                        // 'password_reset_token',
                        // 'status',
                        // 'auth_key',
                        // 'role',
                         'created_at',
                        // 'updated_at',

                        ['class' => 'yii\grid\ActionColumn',
                            'template' => '{update}{delete}'
                        ],
                    ],
                ]); ?>

            </div>
        </div>
    </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(".deleteBtn").click(function(){
            var urlBase = '<?php echo Yii::$app->request->baseUrl;?>';
            var urlDest = urlBase+'/user/delajax';

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
