<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\repair */

$this->title = 'Update Repair: ' . ' ' . $model->id_repair;
$this->params['breadcrumbs'][] = ['label' => 'Repairs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_repair, 'url' => ['view', 'id' => $model->id_repair]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-lg-10">
	<div class="repair-update">

	    <h1><?= Html::encode($this->title) ?></h1>

	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>

	</div>
</div>
