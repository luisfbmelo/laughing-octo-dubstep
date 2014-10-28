<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\repair */

$this->title = 'Create Repair';
$this->params['breadcrumbs'][] = ['label' => 'Repairs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-10">
	<div class="repair-create">

	    <h1><?= Html::encode($this->title) ?></h1>

	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>

	</div>
</div>
