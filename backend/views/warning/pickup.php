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

$this->title = 'Equipamentos por levantar...';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="col-lg-10 col-xs-12 col-sm-9 col-md-9">


    <div class="row hidden-print">
        <div class="col-lg-12">
             <div class="repair-index">
                <h1 class="sectionTitle"><?= Html::encode($this->title) ?></h1>  

				<?php if (isset($_GET['SearchRepair'])){?>
                    <a href="<?php echo Yii::$app->request->baseUrl;?>/warning/pickup" class="btn btn-default clearBtn">
                        <span>Limpar</span>
                    </a>
                    <div class="clear"></div>
                <?php }

                   echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            //['class' => 'yii\grid\SerialColumn'],
                            ['class' => CheckboxColumn::className()],
                            
                            'id_repair',
                            //'type_id',
                            //'client_id',
                            //'inve_id',
                            
                            [
                                'attribute' => 'store_id',
                                'label' => 'Local',
                                'filter' => ArrayHelper::map(stores::find()->where(['status'=>1])->asArray()->orderBy('storeDesc ASC')->all(), 'id_store', 'storeDesc'),
                                'content' => function($model, $index, $dataColumn) {
                                    $text = $model->getStoreDesc($model->id_repair)["storeDesc"];
                                    $output = $model->abbreviate($text);
                                    return $output;
                                },

                            ],
                            [
                                'attribute' => 'equip',
                                'label' => 'Equipamento',
                                'content' => function($model, $index, $dataColumn) {
                                    return $model->getEquipName()["equipDesc"];
                                },                           
                                
                            ],
                            [
                                'attribute' => 'model',
                                'label' => 'Modelo',
                                'content' => function($model, $index, $dataColumn) {
                                    return $model->getModelName()["modelName"];
                                },                           
                                
                            ],
                            'repair_desc:ntext',
                            [
                                //data from other modules tables
                                'attribute' => 'client',
                                'label' => 'Cliente',
                                'value' => 'client.cliName'

                            ],

                            [
                                'attribute' => 'date_entry',
                                'content' => function($model, $index, $dataColumn){
                                    return date("Y-m-d", strtotime($model->date_entry));
                                }
                            ],
                            
                            
                            [
                            	'attribute' => 'datediffDeliver',
                                'label' => 'Dias após reparado',
                                'content' => function($model, $index, $dataColumn) {
                                	$time = $model->getTimeToDeliver($index);
                                    return  "<span style=\"color:red;font-weight:bold;\">".$time[0]['datediff']."</span>";          
                                    
                                },                           
                                
                            ],


                            ['class' => 'yii\grid\ActionColumn',
                                'template' => $template,
                                'controller' => 'repair',
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
                    ]);
                

                 ?>

            </div>
        </div>
    </div>
</section>