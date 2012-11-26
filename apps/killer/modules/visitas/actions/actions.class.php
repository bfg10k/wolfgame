<?php

/**
 * visitas actions.
 *
 * @package    killer
 * @subpackage visitas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class visitasActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(HlJugadoresPeer::NOMBRE);
    $this->jugadores = HlJugadoresPeer::doSelect($c);
  }
  
  public function executeRegistroX(sfWebRequest $request)
  {
      
      $criteria = new Criteria();
      $this->departamentos = HlDepartamentosPeer::doSelect($criteria);
      
      $this->aviso = $this->getUser()->getFlash('notice');
  }

  public function executeRegistrado(sfWebRequest $request)
  {
    
    $nombre = $request->getParameter('nombre');
    if(empty($nombre)) 
    {
        $this->getUser()->setFlash('notice','El nombre es obligatorio');
        $this->redirect('visitas/registro');
    }
        
    $departamento = $request->getParameter('departamento');
    if(empty($departamento)) 
    {
        $this->getUser()->setFlash('notice','El departamento es obligatorio');
        $this->redirect('visitas/registro');
    }
    
    
    
    $usuario = $request->getParameter('usuario');
    if(empty($usuario)) 
    {
        $this->getUser()->setFlash('notice','El usuario es obligatorio');
        $this->redirect('visitas/registro');
    }
    
    $contrasena = $request->getParameter('contrasena');
    if(empty($contrasena)) 
    {
        $this->getUser()->setFlash('notice','La contraseña es obligatoria');
        $this->redirect('visitas/registro');
    }
    
    $contrasena2 = $request->getParameter('contrasena2');
    if(empty($contrasena2)) 
    {
        $this->getUser()->setFlash('notice','La contraseña es obligatoria');
        $this->redirect('visitas/registro');
    }
    if(($contrasena2 != $contrasena)) 
    {
        $this->getUser()->setFlash('notice','Las contraseñas no coinciden');
        $this->redirect('visitas/registro');
    }
    
    $email = $request->getParameter('email');
    if(empty($email)) 
    {
        $this->getUser()->setFlash('notice','El email es obligatorio');
        $this->redirect('visitas/registro');
    }
    
    
            

    //Comprobar que el usuario no está repetido
    $c = new Criteria();
    $c->add(HlJugadoresPeer::USUARIO,$usuario);
    $jugador = HlJugadoresPeer::doSelectOne($c);
    if($jugador instanceof HlJugadores)
    {
        $this->getUser()->setFlash('notice','Ese nombre de usuario ya existe.');
        $this->redirect('visitas/registro');
    }

    

    $jugador_nuevo = new HlJugadores();
    $jugador_nuevo->setNombre($nombre);
    $jugador_nuevo->setIdDepartamento($departamento);
    
    $jugador_nuevo->setUsuario($usuario);
    $jugador_nuevo->setContrasena(md5($contrasena));
    $jugador_nuevo->setEmail($email);
   
    $jugador_nuevo->setActivo(1);    
    $jugador_nuevo->save();
    
    
    
    
  }

  public function executeBlog(sfWebRequest $request)
  {
    $criteria = new Criteria();
    $criteria->addDescendingOrderByColumn(HlNoticiasPeer::ID);
    $this->noticias = HlNoticiasPeer::doSelect($criteria);
  }
  
  public function executeComentar(sfWebRequest $request)
  {
    $texto = $request->getParameter('texto');
    if(!empty($texto))
    {
      $noticia = KillNoticiasPeer::retrieveByPK($request->getParameter('id_noticia',null));
      if($noticia instanceof KillNoticias)
      {
        $comentario = new KillComentarios();
        $comentario->setTexto($texto);
        $noticia->addKillComentarios($comentario);
        $noticia->save();
      }
    }
    $this->redirect('visitas/blog');
  }

  public function executeNormas(sfWebRequest $request)
  {

  }
  
  public function executeHistoria(sfWebRequest $request)
  {

  }
  
  public function executeHistoricoVotaciones(sfWebRequest $request)
  {
      //Rondas en juego
      $c = new Criteria();
      $c->addAscendingOrderByColumn(HlJugadoresPeer::NOMBRE);
      $this->jugadores = HlJugadoresPeer::doSelect($c);

      $conexion = Propel::getConnection();

      $sql = "SELECT min(id_ronda) min_ronda, max(id_ronda) max_ronda
              FROM hl_votos 
             ;";

      $sentencia = $conexion->prepare($sql);
      $sentencia->execute();

      $tRegistro = $sentencia->fetch();
      $this->min_ronda = $tRegistro['min_ronda'];
      $this->max_ronda = $tRegistro['max_ronda'];
      
      //Jugadores votados

  }
  
  public function executeLogin(sfWebRequest $request)
  {
    $usuario = $request->getParameter('username',null);
    if(empty($usuario)) 
    {
      $this->redirect('visitas/index');
    }

    $password = $request->getParameter('password',null);
    if(empty($password)) 
    {
      $this->redirect('visitas/index');
    }

    $c = new Criteria();
    $c->add(HlJugadoresPeer::USUARIO,$usuario);
    $jugador = HlJugadoresPeer::doSelectOne($c);
    if(!($jugador instanceof HlJugadores))
    {
      $this->redirect('visitas/index');
    }


    if(md5($password)==$jugador->getContrasena())  
    {
      $this->getUser()->setAuthenticated(true);
      $this->getUser()->setAttribute('user_id',$jugador->getId());
      $this->redirect('juego/index');
    }
    else
    {
      $this->getUser()->setAuthenticated(false);
      $this->redirect('visitas/index');
    }
  }
  
}
