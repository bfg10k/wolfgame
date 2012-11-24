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
    <li class="active"><a href="<?php echo url_for('juego/index'); ?>"><i class="icon-home icon-white"></i> Inicio</a></li>
    <li><a href="<?php echo url_for('juego/objetivo'); ?>"><i class="icon-screenshot"></i>Tu objetivo</a></li>
    <li><a href="<?php echo url_for('juego/blog'); ?>"><i class="icon-eye-open"></i>INTEF News</a></li> 
    </ul>
</div>
  

<div id="content-objetivo" class="rounded-corners">
  Rol: Hombre-Lobo
  
  Objetivo: Matar a todos los habitantes del pueblo.
  
  Función: Cada vez que llega la noche, te transformas en lobo y matas a un habitante del pueblo.
  
  <?php if($jugador->esAlcalde()):?>
  <div>
    <dt>Rol</dt><dd>Alcalde</dd>
    <div>Eres el encargado de cerrar las votaciones y de decidir en caso de empate.</div> 
    </div>
  <?php endif ?>
  
</div>

  
  
