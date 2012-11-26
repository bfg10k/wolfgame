<div id="nav">
          <ul class="nav nav-tabs">
            <li><a href="<?php echo url_for('visitas/index'); ?>">Jugadores</a></li>
            <li><a href="<?php echo url_for('visitas/blog'); ?>">INTEF News</a></li>
            <li><a href="<?php echo url_for('visitas/normas'); ?>">Normativa</a></li>
            <li class="active"><a href="<?php echo url_for('visitas/historia'); ?>">Historia</a></li>

                      
          </ul>
</div>
  

<div id="content-objetivo" class="rounded-corners">
  
</div>

<h1>Votaciones</h1>
  <?php for($ronda=$max_ronda;$ronda>=$min_ronda;$ronda--): ?>
  <h3>Ronda <?php echo $ronda ?></h3>
  <?php //$num_jugadores_votados = count($jugadores_votados);?>
    <table>
      <tr>
        <th></th>
        <?php foreach($jugadores_votados as $id => $jugador_votado): ?>
        <th><div class="vertical"><?php echo $jugador_votado->getNombre() ?></div></th>
        <?php //$cols[$jugador->getId()]=$col;?>
        <?php endforeach; ?>
      </tr>
      
      <?php foreach($jugadores as $f => $jugador): ?>
      <tr>
        <td><div><?php echo $jugador->getNombre() ?></div></td>
        <?php foreach($jugadores_votados as $c => $jugador_votado): ?>
        <td id="<?php echo $ronda.'_'.$f.'_'.$c?>"></td>
        <?php endforeach ?>
      <?php $id_jugador_votado = $jugador->getVotoRonda($ronda); //if($id_jugador_votado>0) $col_voto = $id_jugador_votado; else $col_voto = 'X'; ?>   
      <script type="text/javascript">$('#<?php echo $ronda.'_'.$f.'_'.$id_jugador_votado?>').addClass('votado');</script>
      </tr>
      <?php endforeach; ?>

    </table>
  
  <?php endfor ?>
  
   
  </div>

  
  
