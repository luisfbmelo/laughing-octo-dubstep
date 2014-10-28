<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Repairs';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-lg-10">
    <div class="repair-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Create Repair', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id_repair',
                'type_id',
                'client_id',
                'inve_id',
                'status',
                // 'user_id',
                // 'repair_desc:ntext',
                // 'date_entry',
                // 'date_close',
                // 'store_id',
                // 'priority',
                // 'budget',
                // 'maxBudget',
                // 'total',

                ['class' => 'yii\grid\ActionColumn'],
            ],
            'filterModel' => $dataProvider,
        ]); ?>

    </div>
</div>


