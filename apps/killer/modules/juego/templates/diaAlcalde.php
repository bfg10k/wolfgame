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
  <form method="post" action="<?php echo url_for('juego/votar');?>">
    <label>Elige a la persona que creas que es el licántropo: </label>
    <?php echo $sf_data->getRaw('selectJugadoresVivos')->render('id_victima'); ?>     
    <button type="submit" class="btn btn-primary">Votar</button>
  </form>
  Puedes cambiar de voto todas las veces que quieras mientras esté abierto el periodo de votación.
  <div>
    <h3>Votaciones</h3>
    <div>
      <?php foreach($votos as $voto): ?>
      <div>
        <span><?php echo $voto->getHlJugadoresRelatedByIdJugador();?></span>
        <span> vota a </span>
        <span><?php echo $voto->getHlJugadoresRelatedByIdVictima();?></span>
      </div>
      <?php endforeach; ?>
    </div>
    <a class="btn btn-primary" href="<?php echo url_for('juego/cerrarVotacion'); ?>">Cerrar la votación</a>
  </div>
</div>

  
  
