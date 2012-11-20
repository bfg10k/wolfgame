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
    <li><a href="<?php echo url_for('juego/index'); ?>"><i class="icon-home"></i> Inicio</a></li>
    <li><a href="<?php echo url_for('juego/rueda'); ?>"><i class="icon-screenshot"></i> Rueda de objetivos</a></li>
    <li class="active"><a href="<?php echo url_for('juego/blog'); ?>"><i class="icon-eye-open"></i> Killer News</a></li>
    </ul>
</div>

<div id="content-user">
  
<h1>Killer News</h1>

    <?php foreach($sf_data->getRaw('noticias') as $noticia): ?>
    <div class="span8">
        <h1><?php echo $noticia->getTitulo(); ?></h1>
        <?php $foto = $noticia->getFotoNoticia(); if(!empty($foto)):?><img src="<?php echo image_path('../uploads/news/'.$noticia->getFotoNoticia()); ?> " /><?php endif ?>
        <p><?php echo $noticia->getNoticia(); ?></p>
        <div>
            <span class="badge badge-success">Publicado <?php echo $noticia->getFecha('d-m-Y H:i'); ?></span>
            <span class="badge badge-success badge-comentarios"><?php echo $noticia->countKillComentarioss(); ?> comentarios</span>
        </div> 
        <div id="div_comentarios" class="span4" style="float:right; text-align: right; display: none;">
          <?php foreach($noticia->getKillComentarioss() as $comentario): ?>
              <?php echo $comentario->getTexto(); ?>
              <hr/>
          <?php endforeach ?>
          <div id="new_comment">
            <form method="POST" action="<?php echo url_for('juego/comentar')?>">
              <input type="hidden" name="id_noticia" value="<?php echo $noticia->getId(); ?>" />
              <textarea name="texto" class="input-xlarge"></textarea>
              <button type="submit" class="btn btn-success">Comentar de forma anónima</button>
            </form>
          </div>
        </div>
        <hr class="span8" />
    </div>
<?php endforeach ?>


</div>


<script>
$(document).ready(function(){
  $(".badge-comentarios").click(function(eventData,handler){
    $(this).parent().parent().children("#div_comentarios").toggle();
  });
});
</script>

