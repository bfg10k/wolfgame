<div id="user"> 
    <div class="btn-group">
    <a class="btn btn-info" href="<?php echo url_for('juego/index'); ?>"><i class="icon-user icon-white"></i> <?php echo $nombre ?></a>
    <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
    <ul class="dropdown-menu">
    <li><a href="<?php echo url_for('juego/editar'); ?>"><i class="icon-pencil"></i> Editar perfil</a></li>
    <li><a href="<?php echo url_for('juego/salir'); ?>"><i class="icon-ban-circle"></i> Salir</a></li>
    </ul>
    </div>

</div>

<div id="nav-user">
    <ul class="nav nav-list">
    <li class="active"><a href="<?php echo url_for('juego/index'); ?>"><i class="icon-home icon-white"></i> Inicio</a></li>
    <li><a href="<?php echo url_for('juego/objetivo'); ?>"><i class="icon-screenshot"></i>Tu personaje</a></li>
    <li><a href="<?php echo url_for('juego/blog'); ?>"><i class="icon-eye-open"></i>INTEF News</a></li> 
    </ul>
</div>
  


<div id="content-objetivo" class="rounded-corners">
  Has muerto. Tienes derecho a utilizar la escopeta justo antes de morir.
  <form method="post" action="<?php echo url_for('juego/escopeta');?>">
    <label>Elige a quién disparas: </label>
    <?php echo $sf_data->getRaw('selectJugadoresVivos')->render('id_victima'); ?>     
    <button type="submit" class="btn btn-danger">Disparar</button>
    <a class="btn btn-info" href="<?php echo url_for('juego/noescopeta') ?>">No disparar</a>
  </form>
</div>
  
  