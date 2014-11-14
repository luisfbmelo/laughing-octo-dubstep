<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Parts */

$this->title = 'Create Parts';
$this->params['breadcrumbs'][] = ['label' => 'Parts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
