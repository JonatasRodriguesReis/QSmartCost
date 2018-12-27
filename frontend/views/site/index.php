<?php

/* @var $this yii\web\View */

use backend\controllers\SiteController;
use yii\helpers\Html;

$this->title = 'Q Smart';
?>

    <div class="site-index">
        <div class="jumbotron">
            <img src="../web/img/newLogo.png" style="width: 400px"><br><br><br>
			<div class="col-xs-4">
			</div>
			<div class="col-xs-4">
            <?= Html::input('text','produto','',['id'=>'produto','autofocus'=>'autofocus','placeholder'=>'Insira o Código de Barras', 'class'=>'form-control input-lg']) ?>
            </div>
			<?= Html::a('Buscar', [''], ['id'=>'click', 'style' => 'display:none']) ?>

        </div>
    </div>

<script>
    var setclick = document.getElementById("click");
    var valor = document.getElementById("produto");

    document.onkeydown = checkKey;
    function checkKey(e) {
        e = e || window.event;
        if (e.keyCode == '13') {
            setclick.setAttribute('href', "index.php?r=qualidade%2Fview&id="+valor.value);
            setclick.click();
        }
    }
</script>
