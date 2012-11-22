<?php

/**
 * juego actions.
 *
 * @package    killer
 * @subpackage juego
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class juegoActions extends sfActions {

    /**
     * Página de inicio de la parte privada
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }

        if ($jugador->getActivo() === 0) {
            $this->setTemplate('indexMuerto');
            $this->jugador = $jugador;
            $this->nombre = $jugador->getNombre();
            return "Success";
        }
        
        $this->jugador = $jugador;
        $this->nombre = $jugador->getNombre();
        
        $c = new Criteria();
        $c->add(HlJugadoresPeer::ACTIVO,1);
        $this->selectJugadoresVivos = new sfWidgetFormPropelChoice(array('model'=>'HlJugadores','criteria'=>$c));

        $estado = HlEstadoPeer::retrieveByPK(1);
        $fase = $estado->getFase();
        switch($fase)
        {
          case "noche":
            $this->setTemplate("noche");
            break;
          case "dia":
            $this->votos = HlVotosPeer::doSelect(new Criteria());
            $this->setTemplate("dia");
            break;
          default:
            $this->setTemplate("noche");
            break;
            
        }
        
        $rol="lobo";
        switch ($rol) {
          case "lobo":
            return "Lobo";
            break;
          
//          case "alcalde":
//            return "Alcalde";
//            break;
//          
//          case "vidente":
//            return "Vidente";
//            break;
//          
//          case "enamorado":
//            return "Enamorado";
//            break;  
          
          default:
            return "Pueblerino";
            break;
        }
          
        
    }
    
    public function executeObjetivo(sfWebRequest $request) {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }

        if ($jugador->getActivo() === 0) {
            $this->setTemplate('indexMuerto');
            $this->jugador = $jugador;
            $this->nombre = $jugador->getNombre();
            return "Success";
        }
        
        $this->jugador = $jugador;
        $this->nombre = $jugador->getNombre();
        
        $c = new Criteria();
        $c->add(HlJugadoresPeer::ACTIVO,1);
        $this->selectJugadoresVivos = new sfWidgetFormPropelChoice(array('model'=>'HlJugadores','criteria'=>$c));

               
        
        $rol="lobo";
        switch ($rol) {
          case "lobo":
            return "Lobo";
            break;
          
//          case "alcalde":
//            return "Alcalde";
//            break;
//          
//          case "vidente":
//            return "Vidente";
//            break;
//          
//          case "enamorado":
//            return "Enamorado";
//            break;  
          
          default:
            return "Pueblerino";
            break;
        }
          
        
    }
    
    public function executeMatarHL(sfWebRequest $request)
    {
      $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }
        
        $id_victima = $request->getParameter('id_victima');
        $victima = HlJugadoresPeer::retrieveByPK($id_victima);
        if($victima instanceof HlJugadores)
        {
          $victima->setActivo(0);
          $victima->save();
          $estado = HlEstadoPeer::retrieveByPK(1);
          $estado->setFase('dia');
          $estado->save();
        }
        
        $this->redirect('juego/index');
    }
    
    public function executeVotar(sfWebRequest $request)
    {
      $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }
        
        $id_victima = $request->getParameter('id_victima');
        $c = new Criteria();
        $c->add(HlVotosPeer::ID_JUGADOR,$id_jugador);
        $voto = HlVotosPeer::doSelectOne($c);
        if(!($voto instanceof HlVotos))
        {
          $voto = new HlVotos();
          $voto->setIdJugador($id_jugador);
        }
        $voto->setIdVictima($id_victima);
        $voto->save();
        
        $this->redirect('juego/index');
    }
    
    public function executeMatarPueblo(sfWebRequest $request)
    {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }
        
        $conexion = Propel::getConnection();

        $sql = "SELECT hl_votos.id_victima as id_victima, count(*) as num_votos 
                FROM hl_votos 
                GROUP BY id_victima
                ORDER BY num_votos desc
                LIMIT 1
               ;";

        $sentencia = $conexion->prepare($sql);
        $sentencia->execute();

        $tRegistro = $sentencia->fetch();
        $id_victima = $tRegistro['id_victima'];
     
        
        
        $victima = HlJugadoresPeer::retrieveByPK($id_victima);
        if($victima instanceof HlJugadores)
        {
          $victima->setActivo(0);
          $victima->save();
          HlVotosPeer::doDeleteAll();
          $estado = HlEstadoPeer::retrieveByPK(1);
          $estado->setFase('noche');
          $estado->save();
        }
        
        $this->redirect('juego/index');
    }

    public function executeSortear(sfWebRequest $request) {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }

        if ($jugador->getIdVictima() == 0) {//Solamente en este caso se realiza el sorteo
            $todos = HlJugadoresPeer::doSelect(new Criteria());
            foreach ($todos as $asesino) {
                $arrayasesinos[$asesino->getId()] = $asesino->getIdDepartamento();
            }

            do {
                $arraysorteado = $this->ashuffle($arrayasesinos);
            } while (!$this->comprobar($arraysorteado));

            $orden = array_keys($arraysorteado);
            foreach ($orden as $pos => $idJugador) {
                $jugador = HlJugadoresPeer::retrieveByPK($idJugador);
                $jugador->setIdVictima($orden[($pos + 1) % count($orden)]);
                $jugador->save();
            }
        }

        $this->redirect('juego/index');
    }

    private function ashuffle($array) {
        $keys = array_keys($array);
        shuffle($keys);
        $random = array();
        foreach ($keys as $key)
            $random[$key] = $array[$key];
        return $random;
    }

    private function comprobar($array) {
        $salida = true;
        $value_ant = end($array);
        foreach ($array as $value) {
            if ($value === $value_ant)
                return false;
            $value_ant = $value;
        }
        return $salida;
    }

    /**
     * Presenta informe de objetivo cumplido
     *
     * @param sfRequest $request A request object
     */
    public function executeRellenarInforme(sfWebRequest $request) {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }
        $this->nombre = $jugador->getNombre();

        $this->aviso = $this->getUser()->getFlash('notice');
    }

    /**
     * Guarda el informe y redirige al mensaje de info de espera de confirmación
     * 
     * No tiene vista
     *
     * @param sfRequest $request A request object
     */
    public function executeGuardarInforme(sfWebRequest $request) {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }

        //Guardar el informe. 
        $forward_error = "juego/rellenarInforme";

        $lugar = $request->getParameter('lugar');
        if (empty($lugar)) {
            $this->getUser()->setFlash('notice', 'Por favor, indica el lugar en el que ocurrio la "tragedia".');
            $this->redirect($forward_error);
        }

        $arma = $request->getParameter('arma');
        if (empty($arma)) {
            $this->getUser()->setFlash('notice', 'Por favor, indica el arma o método utilizado.');
            $this->redirect($forward_error);
        }

        $titulo = $request->getParameter('titulo');
        if (empty($titulo)) {
            $this->getUser()->setFlash('notice', 'Por favor, pon un titular al relato.');
            $this->redirect($forward_error);
        }

        $relato = trim($request->getParameter('relato'));
        if (empty($relato)) {
            $this->getUser()->setFlash('notice', 'Por favor, escribe un relato.');
            $this->redirect($forward_error);
        }

        //Si va bien -> redirigir a executeInformeEnviado
        $victima = $jugador->getHlJugadoresRelatedByIdVictima();
        if ($victima instanceof HlJugadores) {
            $victima->getActivo();

            while (!$victima->getActivo()) {
                $victima = $victima->getHlJugadoresRelatedByIdVictima();
            }
        }
        $victima->setConfirmacionMuerte(1);
        $victima->save();

        $noticia = new HlNoticias();
        $noticia->setIdJugador($jugador->getId());
        $noticia->setTitulo($titulo);
        $noticia->setNoticia($relato);
        $noticia->setFecha(date());
        $noticia->save();

        $muerte = new HlMuertes();
        $muerte->setIdAsesino($jugador->getId());
        $muerte->setIdVictima($jugador->getIdVictima());
        $muerte->setArma($arma);
        $muerte->setLugar($lugar);
        $muerte->setFechaMuerte(date());
        $muerte->save();

        $this->redirect('juego/informeEnviado');
    }

    /**
     * Presenta un aviso de espera de confirmación
     *
     * @param sfRequest $request A request object
     */
    public function executeInformeEnviado(sfWebRequest $request) {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }
        $this->nombre = $jugador->getNombre();
    }

    /**
     * Confirma una muerte
     *
     * @param sfRequest $request A request object
     */
    public function executeConfirmarMuerte(sfWebRequest $request) {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }
        $this->nombre = $jugador->getNombre();

        //Matamos al jugador:
        $jugador->setConfirmacionMuerte(0);
        $jugador->setActivo(0);
        $jugador->save();

        $this->redirect('juego/index');
    }

    /**
     * Confirma una muerte
     *
     * @param sfRequest $request A request object
     */
    public function executeDesmentirMuerte(sfWebRequest $request) {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }
        $this->nombre = $jugador->getNombre();

        //Quitamos la marca de confirmación del jugador:
        $jugador->setConfirmacionMuerte(0);
        $jugador->save();

        $this->redirect('juego/index');
    }

    /**
     * Página de inicio de la parte privada
     *
     * @param sfRequest $request A request object
     */
    public function executeRueda(sfWebRequest $request) {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }

        $this->nombre = $jugador->getNombre();

//    //Antes del sorteo vale esta consulta
//    $this->jugadores = HlJugadoresPeer::doSelect(new Criteria());
//    $this->numJugadores = count($this->jugadores);
//    $this->setTemplate('ruedaNoSorteo');
//    return "Success"; 
        //Para después del sorteo la rueda se tiene que dibujar en orden
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }

        $this->jugador = $jugador;
        $this->otrosjugadores = array();
        $this->muertos = array();
        $jugador = $jugador->getHlJugadoresRelatedByIdVictima();
        do {
            //$this->jugadores[] = array('id'=>$jugador->getId(),'alias'=>$jugador->getAlias(),'foto'=>$jugador->getFoto());
            if ($jugador->getActivo() === 1) {
                $this->otrosjugadores[] = $jugador;
            }else{
                $this->muertos[$jugador->countHlMuertessRelatedByIdAsesino()][] = $jugador;
            }
            $jugador = $jugador->getHlJugadoresRelatedByIdVictima();
        } while ($jugador->getId() != $id_jugador);

    }

    /**
     * Página de inicio de la parte privada
     *
     * @param sfRequest $request A request object
     */
    public function executeBlog(sfWebRequest $request) {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }

        $this->nombre = $jugador->getNombre();


        $criteria = new Criteria();
        $criteria->addDescendingOrderByColumn(HlNoticiasPeer::ID);
        $this->noticias = HlNoticiasPeer::doSelect($criteria);
    }

    /**
     * Página de inicio de la parte privada
     *
     * @param sfRequest $request A request object
     */
    public function executeComentar(sfWebRequest $request) {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }

        $this->nombre = $jugador->getNombre();


        $texto = $request->getParameter('texto');
        if (!empty($texto)) {
            $noticia = HlNoticiasPeer::retrieveByPK($request->getParameter('id_noticia', null));
            if ($noticia instanceof HlNoticias) {
                $comentario = new HlComentarios();
                $comentario->setTexto($texto);
                $noticia->addHlComentarios($comentario);
                $noticia->save();
            }
        }
        $this->redirect('juego/blog');
    }

    /**
     * Página de inicio de la parte privada
     *
     * @param sfRequest $request A request object
     */
    public function executeNuevoPost(sfWebRequest $request) {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }

        $this->nombre = $jugador->getNombre();
    }

    /**
     * Página de inicio de la parte privada
     *
     * @param sfRequest $request A request object
     */
    public function executeGrabarPost(sfWebRequest $request) {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }

        //Guardar el post. 
        $forward_error = "juego/nuevoPost";

        $titulo = $request->getParameter('titulo');
        if (empty($titulo)) {
            $this->getUser()->setFlash('notice', 'Por favor, pon un titular al relato.');
            $this->redirect($forward_error);
        }

        $relato = trim($request->getParameter('relato'));
        if (empty($relato)) {
            $this->getUser()->setFlash('notice', 'Por favor, escribe un relato.');
            $this->redirect($forward_error);
        }

        $noticia = new HlNoticias();
        $noticia->setIdJugador($jugador->getId());
        $noticia->setTitulo($titulo);
        $noticia->setNoticia($relato);
        $noticia->setFecha(date());
        $noticia->save();

        $this->redirect('juego/blog');
    }

    public function executeNormas(sfWebRequest $request) {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }

        $this->nombre = $jugador->getNombre();
    }

    public function executeEditar(sfWebRequest $request) {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }

        $criteria = new Criteria();
        $this->departamentos = HlDepartamentosPeer::doSelect($criteria);

        $this->aviso = $this->getUser()->getFlash('notice');

        $this->nombre = $jugador->getNombre();
        $this->departamento = $jugador->getIdDepartamento();
        $this->alias = $jugador->getAlias();
        $this->biografia = $jugador->getDescripcion();
        $this->email = $jugador->getEmail();
        $this->foto = $jugador->getFoto();
    }

    public function executeGrabarDatos(sfWebRequest $request) {
        $forward = "juego/editar";
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect($forward);
        }

        $nombre = $request->getParameter('nombre');
        if (empty($nombre)) {
            $this->getUser()->setFlash('notice', 'El nombre es obligatorio');
            $this->redirect($forward);
        }

        $departamento = $request->getParameter('departamento');
        if (empty($departamento)) {
            $this->getUser()->setFlash('notice', 'El departamento es obligatorio');
            $this->redirect($forward);
        }

        $alias = $request->getParameter('alias');
        if (empty($alias)) {
            $this->getUser()->setFlash('notice', 'El alias es obligatorio');
            $this->redirect($forward);
        }

        $biografia = $request->getParameter('biografia');
        if (empty($biografia)) {
            $this->getUser()->setFlash('notice', 'La biografía es obligatoria');
            $this->redirect($forward);
        }

        $email = $request->getParameter('email');
        if (empty($email)) {
            $this->getUser()->setFlash('notice', 'El email es obligatorio');
            $this->redirect($forward);
        }

        $fileName = $request->getFiles('foto');
        //print_r($fileName);exit;

        if (!empty($fileName['name'])) {//Solamente si han subido foto nueva haremos algo
            $fileSize = $fileName['size'];
            if ($fileSize <= 0) {
                $this->getUser()->setFlash('notice', 'La foto es obligatoria');
                $this->redirect($forward);
            }

            switch ($fileName['type']) {
                case 'image/jpeg':
                    $ext = 'jpg';
                    break;
                case 'image/png':
                    $ext = 'png';
                    break;
                case 'image/gif':
                    $ext = 'gif';
                    break;
                default:
                    $this->getUser()->setFlash('notice', 'La foto debe tener extensión jpg, gif o png');
                    $this->redirect($forward);
                    break;
            }

            if ($fileSize > 100000) {
                $this->getUser()->setFlash('notice', 'La foto no puede superar los 100 KB');
                $this->redirect($forward);
            }

            $fileType = $fileName['type'];
            $theFileName = $fileName['name'];
            $uploadDir = sfConfig::get("sf_web_dir");
            $fotosDir = $uploadDir . '/images/fotos';

            if (!is_dir($fotosDir))
                mkdir($fotosDir, 0777);
        }

        //Comprobar que el alias no está repetido
        $c = new Criteria();
        $c->add(HlJugadoresPeer::ALIAS, $alias);
        $c->add(HlJugadoresPeer::ID, $jugador->getId(), CRITERIA::NOT_EQUAL);
        $otro_jugador = HlJugadoresPeer::doSelectOne($c);
        if ($otro_jugador instanceof HlJugadores) {
            $this->getUser()->setFlash('notice', 'Ese alias ya existe.');
            $this->redirect($forward);
        }

        $jugador->setNombre($nombre);
        $jugador->setIdDepartamento($departamento);
        $jugador->setAlias($alias);
        $jugador->setDescripcion($biografia);
        $jugador->setEmail($email);

        $jugador->save();
        $this->getUser()->setFlash('notice', 'Datos modificados ;)');

        $idjugador = $jugador->getId();

        if (!empty($fileName['name'])) {
            move_uploaded_file($fileName['tmp_name'], "$fotosDir/foto$idjugador.$ext");
            $jugador->setFoto("foto$idjugador.$ext");
            $jugador->save();
        }
        $this->redirect($forward);
    }

    public function executeRangos(sfWebRequest $request) {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }

        $this->nombre = $jugador->getNombre();
    }

    public function executeRankingv1(sfWebRequest $request) {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }

        $this->nombre = $jugador->getNombre();
        
        $conexion = Propel::getConnection();

        $sql = "SELECT kill_jugadores.id as id_jugador, count(*) as num_muertes 
                FROM kill_jugadores INNER JOIN kill_muertes
                  ON kill_jugadores.id = kill_muertes.id_asesino
                GROUP BY id_jugador
                ORDER BY num_muertes desc, activo asc
               ;";

        $sentencia = $conexion->prepare($sql);
        $sentencia->execute();

        $ranking = array();
        while($tRegistro = $sentencia->fetch())
        {
             $ranking[] = HlJugadoresPeer::retrieveByPK($tRegistro['id_jugador']);
        }
        $this->ranking = $ranking;
 
    }
    
    public function executeRanking(sfWebRequest $request) {
        $id_jugador = $this->getUser()->getAttribute('user_id', null);
        if (is_null($id_jugador))
            $this->redirect('visitas/index');

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ID, $id_jugador);
        $jugador = HlJugadoresPeer::doSelectOne($c);
        if (!($jugador instanceof HlJugadores)) {
            $this->redirect('visitas/index');
        }

        $this->nombre = $jugador->getNombre();
        
        
        $conexion = Propel::getConnection();

        $sql = "SELECT kill_jugadores.id as id_jugador, count(*) as num_muertes 
                FROM kill_jugadores INNER JOIN kill_muertes
                  ON kill_jugadores.id = kill_muertes.id_asesino
                GROUP BY id_jugador
                HAVING num_muertes > 5
                ORDER BY num_muertes desc, activo asc
               ;";

        $sentencia = $conexion->prepare($sql);
        $sentencia->execute();

        $ranking6 = array();
        while($tRegistro = $sentencia->fetch())
        {
             $ranking6[] = HlJugadoresPeer::retrieveByPK($tRegistro['id_jugador']);
        }
        
        $sql = "SELECT kill_jugadores.id as id_jugador, count(*) as num_muertes 
                FROM kill_jugadores INNER JOIN kill_muertes
                  ON kill_jugadores.id = kill_muertes.id_asesino
                GROUP BY id_jugador
                HAVING num_muertes = 5
                ORDER BY num_muertes desc, activo asc
               ;";

        $sentencia = $conexion->prepare($sql);
        $sentencia->execute();

        $ranking5 = array();
        while($tRegistro = $sentencia->fetch())
        {
             $ranking5[] = HlJugadoresPeer::retrieveByPK($tRegistro['id_jugador']);
        }
        
        $sql = "SELECT kill_jugadores.id as id_jugador, count(*) as num_muertes 
                FROM kill_jugadores INNER JOIN kill_muertes
                  ON kill_jugadores.id = kill_muertes.id_asesino
                GROUP BY id_jugador
                HAVING num_muertes = 4
                ORDER BY num_muertes desc, activo asc
               ;";

        $sentencia = $conexion->prepare($sql);
        $sentencia->execute();

        $ranking4 = array();
        while($tRegistro = $sentencia->fetch())
        {
             $ranking4[] = HlJugadoresPeer::retrieveByPK($tRegistro['id_jugador']);
        }
        
        $sql = "SELECT kill_jugadores.id as id_jugador, count(*) as num_muertes 
                FROM kill_jugadores INNER JOIN kill_muertes
                  ON kill_jugadores.id = kill_muertes.id_asesino
                GROUP BY id_jugador
                HAVING num_muertes = 3
                ORDER BY num_muertes desc, activo asc
               ;";

        $sentencia = $conexion->prepare($sql);
        $sentencia->execute();

        $ranking3 = array();
        while($tRegistro = $sentencia->fetch())
        {
             $ranking3[] = HlJugadoresPeer::retrieveByPK($tRegistro['id_jugador']);
        }
        
        $sql = "SELECT kill_jugadores.id as id_jugador, count(*) as num_muertes 
                FROM kill_jugadores INNER JOIN kill_muertes
                  ON kill_jugadores.id = kill_muertes.id_asesino
                GROUP BY id_jugador
                HAVING num_muertes = 2
                ORDER BY num_muertes desc, activo asc
               ;";

        $sentencia = $conexion->prepare($sql);
        $sentencia->execute();

        $ranking2 = array();
        while($tRegistro = $sentencia->fetch())
        {
             $ranking2[] = HlJugadoresPeer::retrieveByPK($tRegistro['id_jugador']);
        }
        
        $sql = "SELECT kill_jugadores.id as id_jugador, count(*) as num_muertes 
                FROM kill_jugadores INNER JOIN kill_muertes
                  ON kill_jugadores.id = kill_muertes.id_asesino
                GROUP BY id_jugador
                HAVING num_muertes = 1
                ORDER BY num_muertes desc, activo asc
               ;";

        $sentencia = $conexion->prepare($sql);
        $sentencia->execute();

        while($tRegistro = $sentencia->fetch())
        {
             $ranking1[] = HlJugadoresPeer::retrieveByPK($tRegistro['id_jugador']);
        }
        
        $this->ranking1 = $ranking1;
        $this->ranking2 = $ranking2;
        $this->ranking3 = $ranking3;
        $this->ranking4 = $ranking4;
        $this->ranking5 = $ranking5;
        $this->ranking6 = $ranking6;
 
    }

    /**
     * Destruye la sesión y redirige al módulo de visitas
     *
     * @param sfRequest $request A request object
     */
    public function executeSalir(sfWebRequest $request) {
        //Borrar la sesión
        $this->getUser()->setAuthenticated(false);
        $this->getUser()->setAttribute('user_id', null);

        //Ir a visitas/index
        $this->redirect('visitas/index');
    }

}
