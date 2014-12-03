<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InventorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventário ativo';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="col-lg-10 col-xs-12 col-sm-9 col-md-9">
    <div class="row">
        <div class="col-lg-12">
             <div class="repair-index">
                <h1 class="sectionTitle"><?= Html::encode($this->title) ?></h1>  
                <?php if (isset($_GET['InventorySearch'])){?>
                    <a href="<?php echo Yii::$app->request->baseUrl;?>/inventory/index" class="btn btn-default clearBtn">
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
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'equipName',
                            'label' => 'Equipamento',
                            'value' => 'equip.equipDesc'                         
                            
                        ],
                        [
                            'attribute' => 'brandName',
                            'label' => 'Marca',
                            'value' => 'brand.brandName'                           
                            
                        ],
                        [
                            'attribute' => 'modelName',
                            'label' => 'Modelo',
                            'value' => 'model.modelName'                          
                            
                        ],
                        'inveSN:ntext',
                        // 'status',

                  
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</section>
