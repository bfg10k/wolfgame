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
    <li><a href="<?php echo url_for('juego/rueda'); ?>"><i class="icon-screenshot"></i> Rueda de objetivos</a></li>
    <li><a href="<?php echo url_for('juego/blog'); ?>"><i class="icon-eye-open"></i> Killer News</a></li>  
    <li><a href="<?php echo url_for('juego/nuevoPost'); ?>"><i class="icon-pencil"></i>Escribe en el blog</a></li> 
    <li><a href="<?php echo url_for('juego/normas'); ?>"><i class="icon-align-justify"></i> Normativa</a></li>
    <li class="active"><a href="<?php echo url_for('juego/rangos'); ?>"><i class="icon-certificate icon-white"></i> Rango mafioso</a></li>
    <li><a href="<?php echo url_for('juego/ranking'); ?>"><i class="icon-signal"></i> Clasificación</a></li>
    </ul>
</div>
     
<div id="content-user">
    <h1>Escala de maldad</h1>
  <div id="rangos">
    <img src="<?php echo image_path('../images/don.png'); ?>"width="130" style=" float: left;"/><dt>Don</dt><dl>Es el jefe de la familia.</dl>
    <img src="<?php echo image_path('../images/sottocapo.png'); ?>"width="80" style="float: left;"/><dt>Sottocapo</dt><dl>Es la mano derecha del jefe. Hace de Don en caso de que esté incapacitado.</dl>
    <img src="<?php echo image_path('../images/consigliere.png'); ?>"width="65" style="float: left;"/><dt>Consigliere</dt><dl>Es el consejero del Don, le asesora en decisiones importantes.</dl>
    <img src="<?php echo image_path('../images/capo.png'); ?>"width="80" style="float: left;"/><dt>Caporegime</dt><dl>Es el superior al Capodecime.</dl>
    <img src="<?php echo image_path('../images/capo.png'); ?>"width="75" style="float: left;"/><dt>Capodecime</dt><dl>Dirige a una decena de hombres.</dl>
    <img src="<?php echo image_path('../images/soldato.png'); ?>"width="70" style="float: left;"/><dt>Soldato</dt><dl>Son los conocidos sicarios de la mafia.</dl>
    <img src="<?php echo image_path('../images/associato.png'); ?>"width="65" style="float: left;"/><dt>Associato</dt><dl>Aspirantes a soldato, aún no han sido admitidos en la familia.</dl>
  </div>
</div>
