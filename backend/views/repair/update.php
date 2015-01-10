<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\repair */

$this->title = 'Editar reparação: ' . ' ' . $modelRepair->id_repair;
if (\Yii::$app->session->get('lastAction')=="warranty" || \Yii::$app->session->get('lastAction')=="pickup"){
    $this->params['breadcrumbs'][] = ['label' => 'Reparações', 'url' => ["warning/".\Yii::$app->session->get('lastAction')]];
}else{
    $this->params['breadcrumbs'][] = ['label' => 'Reparações', 'url' => [\Yii::$app->session->get('lastAction')]];
}
$this->params['breadcrumbs'][] = ['label' => $modelRepair->id_repair, 'url' => ['view', 'id' => $modelRepair->id_repair]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<section class="col-lg-10 col-xs-12 col-sm-9 col-md-9">
    <div class="row">
    	<div class="col-lg-12">
    		<?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
    	</div>
    	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
    		<div class="repairFields repairUpdate">

    			<h1 class="sectionTitle col-lg-12"><?= Html::encode($this->title) ?></h1>

    		    <?=
                
                 $this->render('_formEdit', [
    		        'modelRepair' => $modelRepair,
    		        'modelClient' => $modelClient,
                    'stores' => $allStores,
                    'types' => $allTypes,
                    'statusAll' => $allStatus,
                    'accessories' => $allAccess,
                    'modelStores' => $modelStores,
                    'modelBrands' => $modelBrands,
                    'modelEquip' => $modelEquip,
                    'modelModels' => $modelModels,
                    'modelTypes' => $modelTypes,
                    'modelInv' => $modelInv,
                    'modelAccess' => $modelAccess,
                    'modelRepairAccess' => $modelRepairAccess,
                    'modelStatus' => $modelStatus,
                    'modelParts' => $modelParts,
                    'isOk' => $isOk,
                    'items' => $items,
                    'invNewItem' => $invNewItem
    		    ]) ?>

    		</div>
    	</div>
    </div>
</section>