<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\equipaments */

$this->title = $model->id_equip;
$this->params['breadcrumbs'][] = ['label' => 'Equipaments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipaments-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_equip], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_equip], [
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
            'id_equip',
            'equipDesc:ntext',
            'status',
        ],
    ]) ?>

</div>
