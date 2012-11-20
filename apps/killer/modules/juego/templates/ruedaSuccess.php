<div id="user"> 
    <div class="btn-group">
        <a class="btn btn-info" href="<?php echo url_for('juego/index'); ?>"><i class="icon-user icon-white"></i> <?php echo $nombre ?></a>
        <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo url_for('juego/editar'); ?>"><i class="icon-pencil"></i> Editar perfil</a></li>
            <li><a href="<?php echo url_for('juego/salir'); ?>"><i class="icon-ban-circle"></i> Salir</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo url_for('juego/rellenarInforme'); ?>"><i class="i"></i> Certifica la muerte de tu objetivo</a></li>
        </ul>
    </div>

</div>


<div id="nav-user">
    <ul class="nav nav-list">
        <li><a href="<?php echo url_for('juego/index'); ?>"><i class="icon-home"></i> Inicio</a></li>
        <li class="active"><a href="<?php echo url_for('juego/rueda'); ?>"><i class="icon-screenshot icon-white"></i> Rueda de objetivos</a></li>
        <li><a href="<?php echo url_for('juego/blog'); ?>"><i class="icon-eye-open"></i> Killer News</a></li> 
        <li><a href="<?php echo url_for('juego/nuevoPost'); ?>"><i class="icon-pencil"></i>Escribe en el blog</a></li> 
        <li><a href="<?php echo url_for('juego/normas'); ?>"><i class="icon-align-justify"></i> Normativa</a></li>
        <li><a href="<?php echo url_for('juego/rangos'); ?>"><i class="icon-certificate"></i> Rango mafioso</a></li>
        <li><a href="<?php echo url_for('juego/ranking'); ?>"><i class="icon-signal"></i> Clasificación</a></li>

    </ul>
</div>


<div id="content-user">
    <h1>Killers - League of Legends</h1>
    <canvas id="myCanvas" width="800" height="850" style="border:1px solid #d3d3d3;">
        Tu navegador todavía no soporta la etiqueta canvas de HTML5.</canvas>

    <script>

        var c=document.getElementById("myCanvas");
        var ctx=c.getContext("2d");

        var cr = 350; //radio de la circunferencia
        var x=400-70/2;
        var y=400-70/2;

<?php $i = -M_PI / 2;
$paso = 2 * M_PI / (count($otrosjugadores) + 1); ?>
        var img = new Image();
        img.src="<?php echo image_path('fotos/' . $jugador->getFoto()); ?>";
        img.width="70";
        img.height="70";
        posx = Math.round(cr*Math.cos(<?php echo $i ?>))+x;
        posy = Math.round(cr*Math.sin(<?php echo $i ?>))+y;
        ctx.drawImage(img,posx,posy,70,70);
        
        <?php if($jugador->getActivo() === 0):?>
                    var img = new Image();
                    img.src="<?php echo image_path('fotos/eliminado.png'); ?>";
                    img.width="70";
                    img.height="70";
                    posx = Math.round(cr*Math.cos(<?php echo $i ?>))+x;
                    posy = Math.round(cr*Math.sin(<?php echo $i ?>))+y;
                    ctx.drawImage(img,posx,posy,70,70);
        <?php endif; ?>
    <?php $numMuertes = $jugador->countKillMuertessRelatedByIdAsesino();?>
    <?php if($numMuertes <= 2): ?>
                var img = new Image();
                img.src="<?php echo image_path('muertes/'.$numMuertes.'.png'); ?>";
                img.width="70";
                img.height="70";
                posx = Math.round(cr*Math.cos(<?php echo $i ?>))+x;
                posy = Math.round(cr*Math.sin(<?php echo $i ?>))+y;
                ctx.drawImage(img,posx,posy,70,70);
    <?php elseif($numMuertes > 2 && $numMuertes <=4):?>
                var img = new Image();
                img.src="<?php echo image_path('muertes/2+.png'); ?>";
                img.width="70";
                img.height="70";
                posx = Math.round(cr*Math.cos(<?php echo $i ?>))+x;
                posy = Math.round(cr*Math.sin(<?php echo $i ?>))+y;
                ctx.drawImage(img,posx,posy,70,70);
    <?php elseif($numMuertes > 4):?>
                var img = new Image();
                img.src="<?php echo image_path('muertes/overkill.png'); ?>";
                img.width="70";
                img.height="70";
                posx = Math.round(cr*Math.cos(<?php echo $i ?>))+x;
                posy = Math.round(cr*Math.sin(<?php echo $i ?>))+y;
                ctx.drawImage(img,posx,posy,70,70);
    <?php endif;?>
        
        //ctx.font="16px Arial";
        //ctx.fillText("<?php //echo $jugador->getAlias(); ?>",posx,posy+92);      
<?php $i = $i + $paso; ?>
<?php $victimaEncontrada = false; ?>
<?php foreach ($otrosjugadores as $otrojugador): ?>

    <?php if ($victimaEncontrada || $jugador->getActivo() === 0): ?>
                        var img = new Image();
                        img.src="<?php echo image_path('fotos/killer_misterioso_peq.jpg'); ?>";
                        img.width="70";
                        img.height="70";
                        posx = Math.round(cr*Math.cos(<?php echo $i ?>))+x;
                        posy = Math.round(cr*Math.sin(<?php echo $i ?>))+y;
                        ctx.drawImage(img,posx,posy,70,70);
                        //ctx.font="16px Arial";
                        //ctx.fillText("<?php //echo $otrojugador->getAlias(); ?>",posx,posy+92);
//    <?php //else: ?> 
//        <?php //if ($otrojugador->getActivo() === 0): ?>
//                    var img = new Image();
//                    img.src="<?php //echo image_path('fotos/' . $otrojugador->getFoto()); ?>";
//                    img.width="70";
//                    img.height="70";
//                    posx = Math.round(cr*Math.cos(<?php //echo $i ?>))+x;
//                    posy = Math.round(cr*Math.sin(<?php //echo $i ?>))+y;
//                    ctx.drawImage(img,posx,posy,70,70);
//                    
//                    var img = new Image();
//                    img.src="<?php //echo image_path('fotos/eliminado.png'); ?>";
//                    img.width="70";
//                    img.height="70";
//                    posx = Math.round(cr*Math.cos(<?php //echo $i ?>))+x;
//                    posy = Math.round(cr*Math.sin(<?php //echo $i ?>))+y;
//                    ctx.drawImage(img,posx,posy,70,70);
            <?php else: ?>
            <?php $victimaEncontrada = true; ?>
                var img = new Image();
                img.src="<?php echo image_path('fotos/' . $otrojugador->getFoto()); ?>";
                img.width="70";
                img.height="70";
                posx = Math.round(cr*Math.cos(<?php echo $i ?>))+x;
                posy = Math.round(cr*Math.sin(<?php echo $i ?>))+y;
                ctx.drawImage(img,posx,posy,70,70);
        <?php //endif; ?>
    <?php endif; ?>
    <?php $numMuertes = $otrojugador->countKillMuertessRelatedByIdAsesino();?>
    <?php if($numMuertes <= 2): ?>
                var img = new Image();
                img.src="<?php echo image_path('muertes/'.$numMuertes.'.png'); ?>";
                img.width="70";
                img.height="70";
                posx = Math.round(cr*Math.cos(<?php echo $i ?>))+x;
                posy = Math.round(cr*Math.sin(<?php echo $i ?>))+y;
                ctx.drawImage(img,posx,posy,70,70);
    <?php elseif($numMuertes > 2 && $numMuertes <=4):?>
                var img = new Image();
                img.src="<?php echo image_path('muertes/2+.png'); ?>";
                img.width="70";
                img.height="70";
                posx = Math.round(cr*Math.cos(<?php echo $i ?>))+x;
                posy = Math.round(cr*Math.sin(<?php echo $i ?>))+y;
                ctx.drawImage(img,posx,posy,70,70);
    <?php elseif($numMuertes > 4):?>
                var img = new Image();
                img.src="<?php echo image_path('muertes/overkill.png'); ?>";
                img.width="70";
                img.height="70";
                posx = Math.round(cr*Math.cos(<?php echo $i ?>))+x;
                posy = Math.round(cr*Math.sin(<?php echo $i ?>))+y;
                ctx.drawImage(img,posx,posy,70,70);
    <?php endif;?>
    <?php $i = $i + $paso; ?>
<?php endforeach ?>

        //La flecha de dirección de giro
        var img = new Image();
        img.src="<?php echo image_path('flecha_rueda.png'); ?>";
        posx = 530;
        posy = 180;
        ctx.drawImage(img,posx,posy,70,70);
    </script>
    
    <div id="losers" style="display: inline-block; float:left;">
    <h1>Los que nos han dejado</h1>
    <?php foreach ($muertos as $rango => $jugadores): ?>  
        <?php foreach ($jugadores as $jugador): ?>  
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
        <?php endforeach ?>
    <?php endforeach ?>

    </div>
</div>



