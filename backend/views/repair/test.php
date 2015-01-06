<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\helpers\Url;
use common\models;
use yii\helpers\ArrayHelper;

use common\models\Stores;
use common\models\Status;
use common\models\Repair;
use common\models\Client;

echo $modelRepair->date_entry;

?>

<button>Teste</button>

<script>
	$(document).ready(function(){
		$("button").click(function(){
			var urlBase = '<?php echo Yii::$app->request->baseUrl;?>';
            var urlDest = urlBase+'/repair/index';

			$.ajax({
                url: urlDest,
                type:"POST",
                success: function(data){
                    console.log(data);

                },
                error: function(){

                }
            });
		});
	});
</script>