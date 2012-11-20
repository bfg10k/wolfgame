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
    <li><a href="<?php echo url_for('juego/rueda'); ?>"><i class="icon-screenshot"></i> Rueda de objetivos</a></li>
    <li><a href="<?php echo url_for('juego/blog'); ?>"><i class="icon-eye-open"></i> Killer News</a></li>  
    <li><a href="<?php echo url_for('juego/nuevoPost'); ?>"><i class="icon-pencil"></i>Escribe en el blog</a></li>
    <li><a href="<?php echo url_for('juego/normas'); ?>"><i class="icon-align-justify"></i> Normativa</a></li>
    <li><a href="<?php echo url_for('juego/rangos'); ?>"><i class="icon-certificate"></i> Rango mafioso</a></li>
    <li><a href="<?php echo url_for('juego/ranking'); ?>"><i class="icon-signal"></i> Clasificación</a></li>
    </ul>
</div>

<div id="content-user">
  <form class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo url_for('juego/grabarDatos'); ?>">
    <fieldset>
      <div id="legend" class="">
        <legend class="">Edita tu perfil más asesino</legend>
      </div>
        
      <?php if(!empty($aviso)): ?>
        <p class="alert"><?php echo $aviso; ?></p>
      <?php endif ?>
        
        
    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">Nombre</label>
          <div class="controls">
            <input type="text" name="nombre" value="<?php echo $nombre;?>" placeholder="tu nombre real" class="input-xlarge">
            <p class="help-block">Tu nombre real para que puedan identificarte junto con el departamento</p>
          </div>
        </div><div class="control-group">

          <!-- Select Basic -->
          <label class="control-label">Departamento</label>
          <div class="controls">
            <select name="departamento" class="input-xlarge">
            <option value="">(Indica tu departamento)</option>
            <?php foreach($departamentos as $dep): ?>
                <?php if($dep->getId() == $departamento): ?>
                <option value="<?php echo $dep->getId(); ?>" selected="selected"><?php echo $dep->getDepartamento(); ?></option>
                <?php else: ?>
                <option value="<?php echo $dep->getId(); ?>"><?php echo $dep->getDepartamento(); ?></option>
                <?php endif?>
            <?php endforeach ?>
            </select>    
            <p class="help-block">Tu departamento para que puedan identificarte junto con el nombre</p>
          </div>

        </div><div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">Alias</label>
          <div class="controls">
            <input type="text" name="alias" value="<?php echo $alias;?>" placeholder="alias" class="input-xlarge">
            <p class="help-block">Un alias mafioso/divertido para que nadie pueda identificarte</p>
          </div>
        </div><div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">Biografía</label>
          <div class="controls">
            <textarea name="biografia" rows="8" class="input-xxlarge" placeholder="escribe tu biografía" ><?php echo $biografia;?></textarea>
            <p class="help-block">Escribe una breve biografía para que salga en tu ficha de asesino.</p>
            <p class="help-block">Utiliza la etiqueta &lt;p&gt; de html para mejorar la lectura.</p>
          </div>
        </div><div class="control-group">
          <label class="control-label">Sube una foto (max. 100k)</label>

          <!-- File Upload -->
          <div class="controls">
            <input name="foto" class="input-file" id="fileInput" type="file">
            <img width="70" src="<?php echo image_path("fotos/".$foto); ?>" />
            <p class="help-block">La redimensionaremos a 70 x 70 píxeles.</p> 
          </div>
        </div><div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">Email</label>
          <div class="controls">
            <input type="text" name="email" value="<?php echo $email;?>" placeholder="email" class="input-xlarge">
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
    
</div>

