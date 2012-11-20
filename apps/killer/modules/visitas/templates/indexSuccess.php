<div id="nav">
    <ul class="nav nav-tabs">
        <li class="active"><a href="<?php echo url_for('visitas/index'); ?>">Jugadores</a></li>
        <li><a href="<?php echo url_for('visitas/blog'); ?>">Killer News</a></li>
        <li><a href="<?php echo url_for('visitas/normas'); ?>">Normativa</a></li>

    </ul>
</div>	
<div id="main_content">
    <h1>Jugadores</h1>

    <?php foreach ($jugadores as $jugador): ?>  
           <div id="jugador" style="min-width: 70px;">
              <p><?php echo $jugador->getNombre(); ?></p>
              <p><?php //echo $jugador->getHlDepartamentos()->getNombre(); ?></p>
              
            </div>	

        
    <?php endforeach ?>

</div>





