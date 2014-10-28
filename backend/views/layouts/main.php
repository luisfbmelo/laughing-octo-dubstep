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
                    <div class="col-lg-5 col-xs-10 col-sm-5 col-md-5">
                        <img src="img/logo.jpg" alt="" class="src">
                    </div>

                    <div class="col-lg-2 col-xs-2 col-sm-2 col-md-2">
                        <nav class="navbar" role="navigation">
                            <div class="navbar-header">
                              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#leftMenu">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                              </button>
                            </div> 
                        </nav>
                    </div>

                    <div class="col-lg-5 col-xs-12 col-sm-5 col-md-5 profileBox">
                        <div class="userLoged fRight">Bem vindo <strong>Paulo Belém</strong>.</div>
                        <div class="notifications fRight">
                            <span>4</span>
                        </div>
                        <div class="clearAll"></div>
                        <a href="<?php echo Yii::$app->getUrlManager()->createUrl('site/logout'); ?>" class="logout">Sair</a>
                    </div>
                    
                </div>
            
                <div class="row">
                    <div class="col-lg-2 col-xs-12 col-sm-4 col-md-4 clearPad">
                        

                        <!-- Side Menu -->
                        <div class="accordion collapse navbar-collapse clearPad" id="leftMenu">
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-parent="#leftMenu" href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['repair/index']); ?>">
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
