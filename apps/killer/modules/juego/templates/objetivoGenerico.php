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
    <li><a href="<?php echo url_for('juego/index'); ?>"><i class="icon-home icon-white"></i> Inicio</a></li>
    <li class="active"><a href="<?php echo url_for('juego/objetivo'); ?>"><i class="icon-screenshot"></i>Tu objetivo</a></li>
    <li><a href="<?php echo url_for('juego/blog'); ?>"><i class="icon-eye-open"></i>INTEF News</a></li> 
    </ul>
</div>
  

<div id="content-objetivo" class="rounded-corners">
  <div>
  Objetivo: Descubrir y sacrificar al hombre-lobo
  
  Función: Cada nuevo día, mientras el hombre-lobo siga vivo, 
  debéis sacrificar al habitante del pueblo que creáis que es el hombre lobo. 
  La elección de la persona sacrificada será mediante el sistema de votaciones.
  </div>
  
  <?php if($jugador->esVidente()):?>
  <div>
    <dt>Rol</dt><dd>Vidente</dd>
  
  <dt>Videncia</dt><dd> Una vez cada día puedes utilizar tus poderes de videncia para 
  averiguar el rol o roles de un jugador.</dd> 
  
  <div>
    <form method="post" action="<?php echo url_for('juego/videncia'); ?>">
      <label>Utilizar videncia con: </label>
      <?php echo $sf_data->getRaw('selectJugadoresVivos')->render('id_victima'); ?>  
      <button type="submit" class="btn btn-primary">Aceptar</button>
      </form>
  </div>
  
  </div>
  <?php endif ?>
  
  <?php if($jugador->esBruja()):?>
  <div>
    <dt>Rol</dt><dd>Bruja</dd>
  
  <dt>Poción resucitadora</dt><dd> Dispones de una única poción para revivir a un jugador a tu elección.</dd> 
  <dt>Poción mortífera</dt><dd> Dispones de una única poción para matar a un jugador a tu elección.</dd> 
  <dt>Embrujo</dt><dd> Una vez durante la partida puedes embrujar a un jugador para hablar y votar en su lugar.</dd> 
  
  </div>
  <?php endif ?>
  
  <?php if($jugador->esCazador()):?>
  <div>
    <dt>Rol</dt><dd>Cazador</dd>
  
  <dt>Escopeta</dt><dd>Cuando te maten, cómo acto reflejo tienes la posibilidad de 
    utilizar tu escopeta y matar a un jugador a tu elección. Tú morirás igualmente.</dd> 
  
  </div>
  <?php endif ?>
  
  <?php if($jugador->estaEnamorado()):?>
  <div>
    <dt>Rol</dt><dd>Enamorado</dd>
  
  <div>Estás enamorado/a de: <?php echo $jugador->getAmante() ?>.
    Si <?php echo $jugador->getAmante()->getNombre() ?> muere, tú morirás de pena inmediatamente.</div> 
  
  </div>
  <?php endif ?>
  
  
</div>

  
  