<div id="nav">
          <ul class="nav nav-tabs">
            <li ><a href="<?php echo url_for('visitas/index'); ?>">Jugadores</a></li>
            <li class="active"><a href="<?php echo url_for('visitas/blog'); ?>">Killer News</a></li>
            <li><a href="<?php echo url_for('visitas/normas'); ?>">Normativa</a></li>
                      
          </ul>
</div>

<div id="main_content">

<h1>Killer News</h1>

<?php foreach($sf_data->getRaw('noticias') as $noticia): ?>
    <div class="span8">
        <h1><?php echo $noticia->getTitulo(); ?></h1>
        <?php $foto = $noticia->getFotoNoticia(); if(!empty($foto)):?><img src="<?php echo image_path('../uploads/news/'.$noticia->getFotoNoticia()); ?> " /><?php endif ?>
        <p><?php echo $noticia->getNoticia(); ?></p>
        <div>
            <span class="badge badge-success">Publicado el <?php echo $noticia->getFecha('d-m-Y H:i'); ?></span>
            <span class="badge badge-success badge-comentarios"><?php echo $noticia->countKillComentarioss(); ?> comentarios</span>
        </div> 
        <div id="div_comentarios" class="span4" style="float:right; text-align: right; display: none;">
          <?php foreach($noticia->getKillComentarioss() as $comentario): ?>
              <?php echo $comentario->getTexto(); ?>
              <hr/>
          <?php endforeach ?>
          <div id="new_comment">
            <form method="POST" action="<?php echo url_for('visitas/comentar')?>">
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


