<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\equipaments */

$this->title = 'Update Equipaments: ' . ' ' . $model->id_equip;
$this->params['breadcrumbs'][] = ['label' => 'Equipaments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_equip, 'url' => ['view', 'id' => $model->id_equip]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="equipaments-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
