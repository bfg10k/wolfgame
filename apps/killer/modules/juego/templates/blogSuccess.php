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
    <li><a href="<?php echo url_for('juego/objetivo'); ?>"><i class="icon-screenshot"></i> Tu personaje</a></li>
    <li class="active"><a href="<?php echo url_for('juego/blog'); ?>"><i class="icon-book"></i> Bitácora</a></li>
    <li><a href="<?php echo url_for('juego/historicoVotaciones'); ?>"><i class="icon-eye-open"></i> Votaciones</a></li> 
    </ul>
</div>

<div id="content-user">
  
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

