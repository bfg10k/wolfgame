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

<?php $i=-M_PI/2; $paso = 2*M_PI/count($jugadores); ?>
<?php foreach($jugadores as $jugador): ?>  
	var img = new Image();
  img.src="<?php echo image_path('fotos/killer_misterioso_peq.jpg'); ?>";
	img.width="70";
	img.height="70";
  posx = Math.round(cr*Math.cos(<?php echo $i ?>))+x;
  posy = Math.round(cr*Math.sin(<?php echo $i ?>))+y;
	ctx.drawImage(img,posx,posy,70,70);
  ctx.font="16px Arial";
  //ctx.fillText("<?php //echo $jugador->getAlias();?>",posx,posy+92);      
  <?php $i = $i + $paso; ?>
<?php endforeach ?>

  
  ctx.font="26px Arial";
  ctx.fillText("El sorteo no se ha realizado todavía",200,400);    

</script>
</div>

