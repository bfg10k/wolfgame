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
  
</div>

<h1>Votaciones</h1>
  <?php for($ronda=$min_ronda;$ronda<=$max_ronda;$ronda++): ?>
  <h3>Ronda <?php echo $ronda ?></h3>
  <?php $num_jugadores = count($jugadores);?>
    <table>
      <tr>
        <th></th>
        <?php foreach($jugadores as $col => $jugador): ?>
        <th><div class="vertical"><?php echo $jugador->getNombre() ?></div></th>
        <?php $cols[$jugador->getId()]=$col;?>
        <?php endforeach; ?>
      </tr>
      
      <?php foreach($jugadores as $f => $jugador): ?>
      <tr>
        <td><div><?php echo $jugador->getNombre() ?></div></td>
        <?php for($c=0;$c<$num_jugadores;$c++): ?>
        <td id="<?php echo $ronda.'_'.$f.'_'.$c?>"></td>
        <?php endfor ?>
      <?php $jugador_votado = $jugador->getVotoRonda($ronda); if($jugador_votado>0) $col_voto = $cols[$jugador->getVotoRonda($ronda)]; else $col_voto = 'X'; ?>   
      <script type="text/javascript">$('#<?php echo $ronda.'_'.$f.'_'.$col_voto?>').addClass('votado');</script>
      </tr>
      <?php endforeach; ?>

    </table>
  
  <?php endfor ?>
  
   
  </div>

  
  
