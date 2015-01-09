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
            <div class="container-fluid fHeight">
                
                <nav class="row brandHeader hidden-print">
                    <div class="col-lg-5 col-xs-10 col-sm-5 col-md-5">
                        <a href="/"><img src="<?php echo Yii::$app->request->baseUrl;?>/img/logo.jpg" alt="" class="src"></a>
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
                        <div class="userInfo">
                            <div class="userLoged">Bem vindo <strong><?php echo \Yii::$app->session->get('user.name');?></strong>.</div>
                            <!-- <div class="notifications">
                                <span>4</span>
                            </div> -->
                        </div>
                       <div class="clearAll"></div>
                        <div class="logoutButton">
                            <a href="<?php echo Yii::$app->getUrlManager()->createUrl('site/logout'); ?>" class="logout">Sair</a>
                        </div>
                        
                    </div>
                    
                </nav>
            
                <aside class="row menuBox">
                    <div class="col-lg-2 col-xs-12 col-sm-3 col-md-3 clearPad menuContainer hidden-print">
                        

                        <!-- Side Menu -->
                        <div class="accordion collapse navbar-collapse clearPad" id="leftMenu">
                            <div class="accordion-group">
                                <div class="accordion-heading <?php echo Yii::$app->controller->isActive(['repair']); ?>">
                                    <a class="accordion-toggle" data-parent="#leftMenu" href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['repair/index']); ?>">
                                          <span class="glyphicon glyphicon-home"></span> 
                                          <span>Início</span>
                                    </a>
                                </div>
                            </div>

                            <div class="accordion-group">
                                <div class="accordion-heading <?php echo Yii::$app->controller->isActive(['repair2']); ?>">
                                    <a class="accordion-toggle" data-parent="#leftMenu" href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['repair/index?list=1']); ?>">
                                        <span class="glyphicon glyphicon-wrench"></span> 
                                        <span>Reparações</span>
                                    </a>
                                </div>
                            </div>

                            <div class="accordion-group">
                                <div class="accordion-heading <?php echo Yii::$app->controller->isActive(['repair3']); ?>">
                                    <a class="accordion-toggle" data-parent="#leftMenu" href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['repair/index?list=5']); ?>">
                                        <span class="glyphicon glyphicon-trash"></span> 
                                        <span>Eliminadas</span>
                                    </a>
                                </div>
                            </div>

                            <!-- RESTRICTED -->
                            <?php if (\Yii::$app->session->get('user.group')==1){ ?>
                            <div class="accordion-group">
                                <div class="accordion-heading <?php echo Yii::$app->controller->isActive(['user']); ?>">
                                    <a class="accordion-toggle" data-parent="#leftMenu" href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['user/index']); ?>">
                                        <span class="glyphicon glyphicon-user"></span> 
                                        <span>Utilizadores</span>
                                    </a>
                                </div>       
                            </div>
                            

                            <div class="accordion-group">
                                <div class="accordion-heading <?php echo Yii::$app->controller->isActive(['status','stores']); ?>">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#collapseFive">
                                        <span class="glyphicon glyphicon-cog"></span> 
                                        <span class="glyphicon glyphicon-<?= (Yii::$app->controller->isActive(['status','stores']) != "activeTop") ? 'plus' : 'minus' ?> secondGliph"></span>
                                        <span>Configurações</span>
                                    </a>
                                </div>
                                <div id="collapseFive" class="accordion-body collapse <?= (Yii::$app->controller->isActive(['status','stores']) == "activeTop") ? 'in"' : ' ' ?>" <?= (Yii::$app->controller->isActive(['status','stores']) != "activeTop") ? 'style="height:0px;"' : ' ' ?>>
                                    <div class="accordion-inner">
                                        <ul>
                                            <li class="<?php echo Yii::$app->controller->isActive(['stores']); ?>"><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['stores/index']); ?>">Lojas</a></li>
                                        </ul>                 
                                    </div>
                                 </div>
                            </div>

                            <div class="accordion-group">
                                <div class="accordion-heading <?php echo Yii::$app->controller->isActive(['warranty','topickup']); ?>">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#collapseSix">
                                        <span class="glyphicon glyphicon-warning-sign"></span> 
                                        <span class="glyphicon glyphicon-<?= (Yii::$app->controller->isActive(['warranty','topickup']) != "activeTop") ? 'plus' : 'minus' ?> secondGliph"></span>
                                        <span>Avisos</span>
                                    </a>
                                </div>
                                <div id="collapseSix" class="accordion-body collapse <?= (Yii::$app->controller->isActive(['warranty','topickup']) == "activeTop") ? 'in"' : ' ' ?>" <?= (Yii::$app->controller->isActive(['warranty','topickup']) != "activeTop") ? 'style="height:0px;"' : ' ' ?>>
                                    <div class="accordion-inner">
                                        <ul>
                                            <li class="<?php echo Yii::$app->controller->isActive(['warranty']); ?>"><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['warning/warranty']); ?>">Garantia</a></li>
                                        </ul>  
                                        <ul>
                                            <li class="<?php echo Yii::$app->controller->isActive(['topickup']); ?>"><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['warning/pickup']); ?>">Por levantar</a></li>
                                        </ul>                 
                                    </div>
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
                            <?php } ?>
                        </div>
                    </div>

            
                    <?= $content ?>
                </aside>
            </div>
        <?php }else{?>
            <div class="container-fluid loginContainer">
                <?= $content ?>
            </div>
        <?php } ?>

    <!--ACTION MESSAGES-->
    <div class="overlay"></div>
    <?php if(Yii::$app->session->hasFlash('actionSuccess')): ?>
        <div class="statusBox dinFlash">
            <div class="statusMessage flash-success">
                <div class="glyphicon glyphicon-ok" style="font-size:3em;margin-bottom:0.5em;"></div>
                <div><?php echo Yii::$app->session->getFlash('actionSuccess'); ?></div>
                <div class="closeBtn">
                    <span class="glyphicon glyphicon-remove"></span>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if(Yii::$app->session->hasFlash('errorHasRepair')): ?>
        <div class="statusBox dinFlash">
            <div class="statusMessage flash-error">
                <div class="glyphicon glyphicon-warning-sign" style="font-size:3em;margin-bottom:0.5em;"></div>
                <div><?php echo Yii::$app->session->getFlash('errorHasRepair'); ?></div>
                <div class="closeBtn">
                    <span class="glyphicon glyphicon-remove"></span>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!--CONSTANT SUCCESS-->
    
    <div class="statusBox ajaxSucc const">
        <div class="statusMessage flash-success">
            <div class="glyphicon glyphicon-ok" style="font-size:3em;margin-bottom:0.5em;"></div>
            <div>Elemento eliminado com sucesso.</div>
            <div class="closeBtn">
                <span class="glyphicon glyphicon-remove"></span>
            </div>
        </div>
    </div> 

    <!--CONSTANT ERROR-->
    <div class="statusBox ajaxError const">
        <div class="statusMessage flash-error">
            <div class="glyphicon glyphicon-ok" style="font-size:3em;margin-bottom:0.5em;"></div>
            <div><strong>Não foi possível eliminar.</strong><br/>Verifique se existe alguma reparação ou utilizador associados.</div>
            <div class="closeBtn">
                <span class="glyphicon glyphicon-remove"></span>
            </div>
        </div>
    </div> 
    <!--END ACTION MESSAGES-->     

    <script>
    $(document).ready(function(){
        if ($(".dinFlash").length){
            $(".overlay").css("display","block");
            $(".dinFlash").delay(5000).fadeOut(500,function(){
                $(".overlay").css("display","none");
                $(this).remove();
            });
        }

        $(".closeBtn").on("click",function(){
            if ($(this).parent().parent().hasClass("const")){
                window.location = window.location.href;
            }else{
                $(this).parent().parent().remove();
                $(".overlay").css("display","none");
            }
            
        });
        
    });
    </script>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
