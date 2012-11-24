<!DOCTYPE html>
<html lang="es">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
  </head>
  <body>
      
      <div id="header">
          
          <div id="nav_login">
                <form class="form-inline"action='<?php echo url_for('visitas/login'); ?>' method="POST">
                    <fieldset>
                        <input type="text" name="username" class="input-small" placeholder="Username">
                        <input type="password" name="password" class="input-small" placeholder="Password">
                        
                        <button type="submit" class="btn btn-success">Login</button>
                        <a href="<?php echo url_for('visitas/registro'); ?>" class="btn btn-info">Registro</a>
                        
                    </fieldset>
                </form>
            </div>
          
          
            
      </div><!-- /#header -->
      
          
      <div id="content_killer" class="autoclear">
          
          <?php echo $sf_content ?>
          
      </div><!-- /#content_killer --> 
  </body>
</html>
