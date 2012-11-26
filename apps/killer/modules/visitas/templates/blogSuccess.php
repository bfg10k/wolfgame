<div id="nav">
          <ul class="nav nav-tabs">
            <li><a href="<?php echo url_for('visitas/index'); ?>">Jugadores</a></li>
            <li class="active"><a href="<?php echo url_for('visitas/blog'); ?>">Bitácora</a></li>
            <li><a href="<?php echo url_for('visitas/normas'); ?>">Normativa</a></li>
            <li><a href="<?php echo url_for('visitas/historia'); ?>">Historia</a></li>
            <li><a href="<?php echo url_for('visitas/historicoVotaciones'); ?>">Votaciones</a></li>

                      
          </ul>
</div>

<div id="main_content">

<h1>Cuaderno de bitácora</h1>

    <?php foreach($sf_data->getRaw('noticias') as $noticia): ?>
    <div class="span8">
        <span><?php echo $noticia->getTitulo(); ?></span>:
        <span><?php echo $noticia->getNoticia(); ?></span> - 
        <span><?php echo $noticia->getFecha('d-m-Y H:i'); ?></span>
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


