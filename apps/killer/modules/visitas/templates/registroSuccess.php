<div id="nav">
          <ul class="nav nav-tabs">
            <li class="active"><a href="<?php echo url_for('visitas/index'); ?>">Jugadores</a></li>
            <li><a href="<?php echo url_for('visitas/blog'); ?>">Killer News</a></li>
            <li><a href="<?php echo url_for('visitas/normas'); ?>">Normativa</a></li>
                      
          </ul>
</div>

  <form class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo url_for('visitas/registrado'); ?>">
    <fieldset>
      <div id="legend" class="">
        <legend class="">Regístrate</legend>
      </div>
      
      <?php if(!empty($aviso)): ?>
        <p class="alert"><?php echo $aviso; ?></p>
      <?php endif ?>
        
        
    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">Nombre</label>
          <div class="controls">
            <input type="text" name="nombre" placeholder="tu nombre real" class="input-xlarge">
            <p class="help-block">Tu nombre real para que puedan identificarte junto con el departamento</p>
          </div>
        </div><div class="control-group">

          <!-- Select Basic -->
          <label class="control-label">Departamento</label>
          <div class="controls">
            <select name="departamento" class="input-xlarge">
            <option value="">(Indica tu departamento)</option>
            <?php foreach($departamentos as $dep): ?>
                <option value="<?php echo $dep->getId(); ?>"><?php echo $dep->getDepartamento(); ?></option>
            <?php endforeach ?>
            </select>    
            <p class="help-block">Tu departamento para que puedan identificarte junto con el nombre</p>
          </div>

        </div>

    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">Usuario</label>
          <div class="controls">
            <input type="text" name="usuario" placeholder="placeholder" class="input-xlarge">
            <p class="help-block"></p>
          </div>
        </div><div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="contrasena">Contraseña</label>
          <div class="controls">
            <input type="password" name="contrasena" placeholder="placeholder" class="input-xlarge">
            <p class="help-block"></p>
          </div>
        </div><div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">Repite la contraseña</label>
          <div class="controls">
            <input type="password" name="contrasena2" placeholder="placeholder" class="input-xlarge">
            <p class="help-block"></p>
          </div>
        </div><div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">Email</label>
          <div class="controls">
            <input type="text" name="email" placeholder="email" class="input-xlarge">
            <p class="help-block">El de aquí o uno personal, como tú prefieras.</p>
          </div>
        </div><div class="control-group">
          <label class="control-label"></label>

          <!-- Button -->
          <div class="controls">
            <button class="btn btn-success">Aceptar</button>
          </div>
        </div>

    

    </fieldset>
  </form>

