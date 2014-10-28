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
            
                <div class="row">
                    <div class="col-lg-2 clearPad">
                        <!-- Side Menu -->
                        <div class="accordion" id="leftMenu">
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#">
                                          <span class="glyphicon glyphicon-home"></span> 
                                          <span>Início</span>
                                    </a>
                                </div>
                            </div>

                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#">
                                        <span class="glyphicon glyphicon-envelope"></span> 
                                        <span>Mensagens</span>
                                    </a>
                                </div>
                            </div>

                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#">
                                        <span class="glyphicon glyphicon-th"></span> 
                                        <span>Inventário</span>
                                    </a>
                                </div>
                            </div>

                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#">
                                        <span class="glyphicon glyphicon-user"></span> 
                                        <span>Utilizadores</span>
                                    </a>
                                </div>       
                            </div>

                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#collapseFive">
                                        <span class="glyphicon glyphicon-cog"></span> 
                                        <span class="glyphicon glyphicon-plus secondGliph"></span>
                                        <span>Configurações</span>
                                    </a>
                                </div>
                                <div id="collapseFive" class="accordion-body collapse" style="height: 0px; ">
                                    <div class="accordion-inner">
                                        <ul>
                                            <li><a href="">Lojas</a></li>
                                            <li><a href="">Estados</a></li>
                                            <li><a href="">Equipamentos</a></li>
                                        </ul>                 
                                    </div>
                                 </div>
                            </div>

                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#">
                                        <span class="glyphicon glyphicon-warning-sign"></span> 
                                        <span>Avisos</span>
                                    </a>
                                </div>
                            </div>

                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#">
                                        <span class="glyphicon glyphicon-stats"></span> 
                                        <span>Estatísticas</span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

            
                    <?= $content ?>
                </div>
            </div>
        <?php }else{?>
            <div class="container-fluid loginContainer">
                <?= $content ?>
            </div>
        <?php } ?>

        

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
