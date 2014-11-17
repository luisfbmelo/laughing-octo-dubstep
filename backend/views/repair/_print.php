<?php 
use yii\helpers\Html;
 ?>
<!-- visible-print-block -->
        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 " id="printEntry">
            <div class="row header">
                <div class="col-lg-6 col-xs-6 col-sm-6 col-md-6"><img src="<?php echo Yii::$app->request->baseUrl;?>/img/logo.jpg" alt=""></div>
                <div class="col-lg-6 col-xs-6 col-sm-6 col-md-6"> 
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Entrada</th>
                                <th>Nº 9999</th>
                            </tr>
                            <tr>
                                <th>Data</th>
                                <th>31-12-2014</th>
                            </tr>
                            <tr>
                                <th>Local</th>
                                <th>Angra</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row client_data_table">
                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Nome</th>
                                <th colspan="2">Paulo Belem</th>
                            </tr>
                            <tr>
                                <th>Morada</th>
                                <th colspan="2">Rua da Cruz Dourada</th>
                            </tr>
                            <tr>
                                <th rowspan="3">Contacto</th>
                                <th>Fixo</th>
                                <th>295 000 000</th>
                            </tr>
                            <tr>
                                <th>Móvel1</th>
                                <th>000000000</th>
                            </tr>
                            <tr>
                                <th>Móvel 2</th>
                                <th>00000000</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row repair_details_table">
                <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Telemovel</th>
                                <th>Nokia</th>
                                <th>Lumia 654</th>
                                <th>00000000</th>
                            </tr>
                            <tr>
                                <th>Bateria</th>
                                <th><span class="glyphicon glyphicon-ok-sign"></span></th>
                                <th colspan="2" rowspan="3">Observações</th>
                            </tr>
                            <tr>
                                <th>Carregador</th>
                                <th><span class="glyphicon glyphicon-ok-sign"></span></th>
                            </tr>
                            <tr>
                                <th>Outro</th>
                                <th>Cabos, capa</th>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <thead>                    
                            <tr>
                                <th>Avaria</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <th>Descrição da avaria</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row foote">
                <div class="col-lg-6 col-xs-6 col-sm-6 col-md-6"><img src="<?php echo Yii::$app->request->baseUrl;?>/img/logo.jpg" alt=""></div>
                <div class="col-lg-6 col-xs-6 col-sm-6 col-md-6"> 
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Entrada</th>
                                <th>Nº 9999</th>
                            </tr>
                            <tr>
                                <th>Data</th>
                                <th>31-12-2014</th>
                            </tr>
                            <tr>
                                <th>Local</th>
                                <th>Angra</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
           
                //print showing div
                //printDiv("printEntry");
                
                function printDiv(divName) {
                     var printContents = document.getElementById(divName).innerHTML;
                     var originalContents = document.body.innerHTML;

                     document.body.innerHTML = printContents;

                     window.print();

                     document.body.innerHTML = originalContents;
                }
          
        </script>