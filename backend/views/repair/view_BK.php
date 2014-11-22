<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\repair */

$this->title = $model->id_repair;
$this->params['breadcrumbs'][] = ['label' => 'Repairs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-10">
    <div class="repair-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id_repair], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id_repair], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id_repair',
                'type_id',
                'client_id',
                'inve_id',
                'status_id',
                'user_id',
                'repair_desc:ntext',
                'date_entry',
                'date_close',
                'store_id',
                'priority',
                'budget',
                'maxBudget',
                'total',
                'obs'
            ],
        ]) ?>

    </div>
</div>

