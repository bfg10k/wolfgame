<div id="nav">
    <ul class="nav nav-tabs">
        <li class="active"><a href="<?php echo url_for('visitas/index'); ?>">Jugadores</a></li>
        <li><a href="<?php echo url_for('visitas/blog'); ?>">Killer News</a></li>
        <li><a href="<?php echo url_for('visitas/normas'); ?>">Normativa</a></li>

    </ul>
</div>	
<div id="main_content">
    <h1>Jugadores</h1>

    <?php foreach ($jugadores as $jugador): ?>  
        <?php if ($jugador->getActivo() !== 0): ?>
            <div id="jugador">
                <img width="70" class="foto_visitas foto" id="<?php echo $jugador->getId(); ?>" src="<?php echo image_path('fotos/' . $jugador->getFoto()); ?>" title="<?php echo $jugador->getAlias(); ?>" />
                <p><?php echo $jugador->getAlias(); ?></p>
            </div>	

        <?php else: ?>
            <?php //calculo de la altura del div auxiliar?>
            <?php $datosImg = getimagesize(image_path('fotos/' . $jugador->getFoto(), true)) ?>
            <?php $altoImg = round(($datosImg[1] * 70) / $datosImg[0]) ?>
            <div id="jugador">
                <div id="muerto" style="position: relative; height: <?php echo $altoImg;?>">
                    <img width="70" class="sobre foto" id="<?php echo $jugador->getId(); ?>" src="<?php echo image_path('fotos/eliminado.png'); ?>" title="<?php echo $jugador->getAlias(); ?>" />
                    <img width="70" class="foto_visitas foto" id="<?php echo $jugador->getId(); ?>" src="<?php echo image_path('fotos/' . $jugador->getFoto()); ?>" title="<?php echo $jugador->getAlias(); ?>" />
                </div>
                <p style="position: relative; bottom: 0px;"><?php echo $jugador->getAlias(); ?></p>
            </div>
        <?php endif; ?>
    <?php endforeach ?>

</div>

<div id="ficha_ajax">

</div>

<script>
    $(document).ready(function(){
        $(".foto").click(function(eventData,handler){
            $('#ficha_ajax').hide();
            $("#ficha_ajax").load("<?php echo url_for('visitas/fichaAjax'); ?>?id="+this.id);
            if( eventData.pageX < (window.innerWidth/2)){
                $('#ficha_ajax').css('top', eventData.pageY).css('left',eventData.pageX).show(cierraFicha);
            }else{
                $('#ficha_ajax').css('top', eventData.pageY).css('left',(eventData.pageX-500)).show(cierraFicha);
            }
        });
    });
    
    cierraFicha = function(){
        $(".fichaClose").click(function(eventData,handler){
            $('#ficha_ajax').hide();
        });
    }
</script>






