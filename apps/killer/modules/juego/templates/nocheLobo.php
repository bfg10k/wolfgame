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
    <li class="active"><a href="<?php echo url_for('juego/index'); ?>"><i class="icon-home"></i> Inicio</a></li>
    <li><a href="<?php echo url_for('juego/objetivo'); ?>"><i class="icon-screenshot"></i> Tu personaje</a></li>
    <li><a href="<?php echo url_for('juego/blog'); ?>"><i class="icon-book"></i> Bitácora</a></li>
    <li><a href="<?php echo url_for('juego/historicoVotaciones'); ?>"><i class="icon-eye-open"></i> Votaciones</a></li> 
    </ul>
</div>
  


<div id="content-objetivo" class="rounded-corners">
  <?php if(Juego::getRonda()==0): ?>
  <p>Eres un licántropo (hombre-lobo). Este rol es crucial e implica tener que entrar en la web todas 
  las tardes (laborables), ya sea desde el trabajo o desde casa. Si no lo haces, el juego se quedará parado.</p>
  <p>El juego puede llegar a durar 10 días (laborables). Si no crees que puedas dedicarte a él al menos
  una vez cada tarde-noche, por favor, renuncia a este rol por el bien de todos.</p>
  
  <a class="btn btn-inverse" href="<?php echo url_for('juego/renunciaHombrelobo'); ?>">Renuncio a ser hombre-lobo.</a>
  
  <p>Para aceptar el rol, simplemente empieza a jugar matando a uno de los jugadores.</p>
  <p>Consulta "Tu personaje" para obtener más información.</p>
  <?php endif ?>
    
    
  <?php if($jugador->getAccion()==1): ?>
    <form method="post" action="<?php echo url_for('juego/matarHL');?>">
      <label>Elige a tu siguiente víctima: </label>
      <?php echo $sf_data->getRaw('selectJugadoresVivos')->render('id_victima'); ?>     
      <button type="submit" class="btn btn-danger">Acabar con ella</button>
    </form>
  <?php else: ?>
    Espera a que el resto de hombres lobo actúen.
  <?php endif ?>
</div>
  
  
