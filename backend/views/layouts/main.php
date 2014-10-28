<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
        <?php
            if (!Yii::$app->user->isGuest) {            
        ?>
            <div class="container-fluid">
                
                <div class="row brandHeader">
                    <div class="col-lg-6"><img src="img/logo.jpg" alt="" class="src"></div>
                    <div class="col-lg-6">
                        <div class="notifications">4</div>
                        <div class="userLoged">Bem vindo <strong>Paulo Belém</strong>.</div>
                        <a href="<?php echo Yii::$app->getUrlManager()->createUrl('site/logout'); ?>" class="logout">Sair</a>
                    </div>
                </div>
            </div>
        <?php }else{?>
            <div class="container-fluid loginContainer">
        <?php } ?>

        <?= $content ?>
            </div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
