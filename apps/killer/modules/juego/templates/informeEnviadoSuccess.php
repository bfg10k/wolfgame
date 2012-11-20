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
    <li class="active"><a href="<?php echo url_for('juego/index'); ?>"><i class="icon-home"></i> Inicio</a></li>
    <li><a href="<?php echo url_for('juego/rueda'); ?>"><i class="icon-screenshot"></i> Rueda de objetivos</a></li>
    <li><a href="<?php echo url_for('juego/blog'); ?>"><i class="icon-eye-open"></i> Killer News</a></li> 
    <li><a href="<?php echo url_for('juego/nuevoPost'); ?>"><i class="icon-pencil"></i>Escribe en el blog</a></li> 
    <li><a href="<?php echo url_for('juego/normas'); ?>"><i class="icon-align-justify"></i> Normativa</a></li>
    <li><a href="<?php echo url_for('juego/rangos'); ?>"><i class="icon-certificate"></i> Rango mafioso</a></li>
    <li><a href="<?php echo url_for('juego/ranking'); ?>"><i class="icon-signal"></i> Clasificación</a></li>
    </ul>
</div>


<div id="content-user">

    <h3>Espera a que la víctima confirme su asesinato para que te den tu siguiente objetivo. Métele prisa si hace falta.</h3>
    <a href="<?php echo url_for('juego/index'); ?>"class="btn btn-success">Aceptar</a>
</div>

