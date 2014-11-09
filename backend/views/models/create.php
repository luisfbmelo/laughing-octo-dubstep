<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\models */

$this->title = 'Create Models';
$this->params['breadcrumbs'][] = ['label' => 'Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="models-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
