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
    <li><a href="<?php echo url_for('juego/index'); ?>"><i class="icon-home"></i> Inicio</a></li>
    <li class="active"><a href="<?php echo url_for('juego/objetivo'); ?>"><i class="icon-screenshot"></i> Tu personaje</a></li>
    <li><a href="<?php echo url_for('juego/blog'); ?>"><i class="icon-book"></i> Bitácora</a></li>
    <li><a href="<?php echo url_for('juego/historicoVotaciones'); ?>"><i class="icon-eye-open"></i> Votaciones</a></li> 
    </ul>
</div>
  

<div id="content-objetivo" class="rounded-corners">
  <div>
  <p>Objetivo: Descubrir y sacrificar al hombre-lobo</p>
  
  <p>Función: Cada nuevo día, mientras el hombre-lobo siga vivo, 
  debéis sacrificar al habitante del pueblo que creáis que es el hombre lobo. 
  La elección de la persona sacrificada será mediante el sistema de votaciones.</p>
  </div>
  
  <?php if($jugador->esAlcalde()):?>
  <div>
    <dt>Rol</dt><dd>Alcalde</dd>
    <div>Eres el encargado de cerrar las votaciones y de decidir en caso de empate.</div> 
    </div>
  <?php endif ?>
  
  <?php if($jugador->esVidente()):?>
  <div>
    <div>
    <img id="card" class="pic-1" src="<?php echo image_path("vidente.jpg"); ?>" width="200" height="320" />
    </div>
    
    <div id="rol">
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
  </div>
  <?php endif ?>
  
  <?php if($jugador->esBruja()):?>
  <div>
    <div>
    <img id="card" class="pic-1" src="<?php echo image_path("bruja.jpg"); ?>" width="200" height="320" />
    </div>
      
    <div id="rol">
    <dt>Rol</dt><dd>Bruja</dd>
  
    <div>Dispones de dos pociones de un único uso cada una. Solamente puedes utilizar una poción por ronda.</div>  
  
    <?php if($jugador->getAccion()==1): ?>
    
    <?php if(Juego::puedeUtilizarPocionVida()): ?>
    <dt>Poción resucitadora</dt><dd>Utiliza esta poción para revivir a un jugador a tu elección.</dd>
  <form method="post" action="<?php echo url_for('juego/pocionVida'); ?>">
      <label>Utilizar poción resucitadora en: </label>
      <?php echo $sf_data->getRaw('selectJugadoresMuertos')->render('id_victima'); ?>  
      <button type="submit" class="btn btn-primary">Aceptar</button>
  </form>
    <?php endif ?>
    
    <?php if(Juego::puedeUtilizarPocionMuerte()): ?>
  <dt>Poción mortífera</dt><dd>Utiliza esta poción para matar a un jugador a tu elección.</dd> 
  <form method="post" action="<?php echo url_for('juego/pocionMuerte'); ?>">
      <label>Utilizar poción mortífera contra: </label>
      <?php echo $sf_data->getRaw('selectJugadoresVivos')->render('id_victima'); ?>  
      <button type="submit" class="btn btn-primary">Aceptar</button>
  </form>
  <?php endif ?>
  
  <?php endif ?>
  

  <?php endif ?>
    </div>
  </div>
  <?php if($jugador->esCazador()):?>
  <div>
    <div>
    <img id="card" class="pic-1" src="<?php echo image_path("cazador.jpg"); ?>" width="200" height="320" />
    </div>
      
    <div id="rol">
    <dt>Rol</dt><dd>Cazador</dd>
  
  <dt>Escopeta</dt><dd>Cuando te maten, cómo acto reflejo tienes la posibilidad de 
    utilizar tu escopeta y matar a un jugador a tu elección. Tú morirás igualmente.</dd> 
    </div>
  </div>
  <?php endif ?>
  
  <?php if($jugador->estaEnamorado()):?>
  <div>
    <div>
    <img float="right" class="pic-2" src="<?php echo image_path("corazon.png"); ?>" width="80" />
    </div>
      
    <div id="rol">
    <dt>Rol</dt><dd>Enamorado</dd>
  
  <div>Estás enamorado/a de: <?php echo $jugador->getAmante() ?>.
    Si <?php echo $jugador->getAmante()->getNombre() ?> muere, tú morirás de pena inmediatamente.</div> 
    </div>
  </div>
  <?php endif ?>
  
  
</div>

  
  
