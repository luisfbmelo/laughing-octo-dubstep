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

<section class="col-lg-10 col-xs-12 col-sm-8 col-md-8">
    <div class="row">
        <div class="col-lg-4 col-xs-4 col-sm-4 col-md-4">
            <a href="<?php echo Url::to(['repair/create']); ?>" class="topBtn">
                <div class="btnEl">

                    <?php //Html::a('Nova reparação', ['create'], ['class' => 'btn btn-success']) ?>
                    <div class="glyphicon glyphicon-pencil"></div>   
                    <div class="bButtonTitle">Nova reparação</div>

                </div>
                
            </a>
        </div>
        <div class="col-lg-4 col-xs-4 col-sm-4 col-md-4">
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


