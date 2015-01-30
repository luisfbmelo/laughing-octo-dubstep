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
use common\models\SearchRepair;


use kartik\daterange\DateRangePicker;




setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
date_default_timezone_set('Atlantic/Azores');

//get user group and define buttons
if (\Yii::$app->session->get('user.group')!=3){ 
    $template = '{view}{update}{delete}';
}else{
    $template = '{view}';
}

//set default dates
$datesDefault = [date("d-m-Y",strtotime("-1 month")),date("d-m-Y")];

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Equipamentos que entraram';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="col-lg-10 col-xs-12 col-sm-9 col-md-9">


    <div class="row hidden-print">
        <div class="col-lg-12">
             <div class="repair-index">
                <h1 class="sectionTitle"><?= Html::encode($this->title) ?></h1> 

                <!--STATS BOX-->
                <div class="row statBlocks">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="block">
                            <ul>
                                <li class="iconContainer">
                                    <i class="fa fa-pencil"></i>
                                </li>

                                <li class="statsBox">
                                    <strong>
                                        <?php echo $stats[0]['repairTotal'];?>
                                    </strong>
                                    <p>
                                        Entradas
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--END STATS-->
                

                <!--SELETOR DE DATA-->
                
                <div class="dateSelection">
                    <form name="dateForm" id="dateForm" action="entry" method="get"> 
                        <?php 
                        echo '<div class="input-group drp-container">';
                        echo DateRangePicker::widget([
                            'name'=>'SearchRepair[date_range]',
                            'hideInput'=>true,
                            'value'=>$dates[0].' a '.$dates[1],
                            'convertFormat'=>true,
                            'useWithAddon'=>true,
                            'pluginOptions'=>[
                                'format'=>'d-m-Y',
                                'separator'=>' a ',
                                'opens'=>'right',
                                'startDate' => $dates[0],
                                'endDate' => $dates[1]
                            ],
                            'i18n' => [
                                'class' => 'yii\i18n\PhpMessageSource',
                                'basePath' => '@kvdrp/messages',
                                'forceTranslation' => true
                            ],
                            'language'=>'pt',
                            
                        ]);
                        echo Html::submitButton('<span class="glyphicon glyphicon-search"></span>',array('class'=>'btn btn-success dateBtn','id'=>'submit'));
                        echo '</div>'; 
                        ?>        
                    </form>
                </div>
                <!--FIM DE SELETOR-->
                
                <?php if (isset($_GET['SearchRepair'])){?>
                    <a href="<?php echo Yii::$app->request->baseUrl;?>/stats/entry?SearchRepair%5Bdate_range%5D=<?php echo $datesDefault[0]."+a+".$datesDefault[1];?>" class="btn btn-default clearBtn">
                        <span>Limpar</span>
                    </a>
                    
                <?php } ?>
                    <div class="clear"></div>


                    <?php
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

<script>
    $(document).ready(function(){
        $("input[name='SearchRepair[date_range]']").on("change", function(){
            $( ".dateBtn" ).trigger( "click" );
        });

    });
</script>