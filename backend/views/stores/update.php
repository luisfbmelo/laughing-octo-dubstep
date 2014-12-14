<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\Stores */

$this->title = 'Atualizar loja: ' . ' ' . $model->storeDesc;
$this->params['breadcrumbs'][] = ['label' => 'Lojas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->storeDesc];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<section class="col-lg-10 col-xs-12 col-sm-9 col-md-9">
    <div class="row">
    	<div class="col-lg-12">
    		<?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
    	</div>
    	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
    		<div class="row repairFields">

    			<h1 class="sectionTitle col-lg-12"><?= Html::encode($this->title) ?></h1>

    		    <?= $this->render('_formEdit', [
			        'model' => $model,
			    ]) ?>

    		</div>
    	</div>
    </div>
</section>