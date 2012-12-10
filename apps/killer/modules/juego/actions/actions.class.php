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
            if(!($jugador->esCazador() && $jugador->getAccion()==1))
              return "Success";
        }
        
        $this->jugador = $jugador;
        $this->nombre = $jugador->getNombre();
        
        $c = new Criteria();
        $c->add(HlJugadoresPeer::ACTIVO,1);
        $c->addAscendingOrderByColumn(HlJugadoresPeer::NOMBRE);
        $this->selectJugadoresVivos = new sfWidgetFormPropelChoice(array('model'=>'HlJugadores','criteria'=>$c));

        $estado = HlEstadoPeer::retrieveByPK(1);
        $fase = $estado->getFase();
        $ronda = $estado->getRonda();
        switch($fase)
        {
          case "noche":
            $this->setTemplate("noche");
            if($jugador->esHombrelobo()) return "Lobo";
            else return "Generico";
            break;
          case "dia":
            $c = new Criteria();
            $c->add(HlVotosPeer::ID_RONDA,$ronda);
            $this->votos = HlVotosPeer::doSelect($c);
            $this->setTemplate("dia");
            if($jugador->esAlcalde()) return "Alcalde"; //Tiene botón de cerrar votaciones
            //elseif($jugador->esLobo()) return "Lobo"; //Que no pueda votar a los otros lobos
            //¡¡¡Un jugador podría ser alcalde y lobo a la vez!!!
            else return "Generico";
            break;
          case "desempate":
            $conexion = Propel::getConnection();

            $sql = "SELECT hl_votos.id_victima as id_victima, count(*) as num_votos 
                    FROM hl_votos 
                    WHERE id_ronda = $ronda
                    GROUP BY id_victima
                    ORDER BY num_votos desc
                    LIMIT 1
                   ;";

            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();

            $tRegistro = $sentencia->fetch();
            $max_num_votos = $tRegistro['num_votos'];

            $sql = "SELECT hl_votos.id_victima as id_victima, count(*) as num_votos
                    FROM hl_votos 
                    WHERE id_ronda = $ronda
                    GROUP BY id_victima
                    having num_votos = $max_num_votos
                    ORDER BY num_votos desc
                   ;";

            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();

            $num_victimas = $sentencia->rowCount();
            
            $victimas = array();
            while($tRegistro = $sentencia->fetch())
            {
              $victimas[] = HlJugadoresPeer::retrieveByPK($tRegistro['id_victima']);
            }
            
            $this->victimas = $victimas;
            $this->setTemplate("desempate");
            if($jugador->esAlcalde()) return "Alcalde";
            else return "Generico";
          case "cazador":
            $this->setTemplate("cazador");
            if($jugador->esCazador()) return "Cazador";
            else return "Generico";
          default:
            return "Error"; //No ha sido posible definir la fase
            break;
            
        }
        
        if($jugador->esHombrelobo()) return "Lobo";
        else return "Generico";
          
        
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
        $c->addAscendingOrderByColumn(HlJugadoresPeer::NOMBRE);
        $this->selectJugadoresVivos = new sfWidgetFormPropelChoice(array('model'=>'HlJugadores','criteria'=>$c));

        $c = new Criteria();
        $c->add(HlJugadoresPeer::ACTIVO,0);
        $c->addAscendingOrderByColumn(HlJugadoresPeer::NOMBRE);
        $this->selectJugadoresMuertos = new sfWidgetFormPropelChoice(array('model'=>'HlJugadores','criteria'=>$c));

        if($jugador->esGuardaespaldas()) 
        {
          $c = new Criteria();
          $c->add(HlJugadoresPeer::PROTEGIDO,$jugador->getGuardaespaldas());
          $protegido = HlJugadoresPeer::doSelectOne($c);
          if($protegido instanceof HlJugadores)
          {
            $this->id_protegido = $protegido->getId();
          }
          else
          {
            $this->id_protegido = null;
          }
        }
        
        if($jugador->esHipnotizador()) 
        {
          $c = new Criteria();
          $c->add(HlJugadoresPeer::HIPNOTIZADO,$jugador->getHipnotizador());
          $this->jugador_hipnotizado = HlJugadoresPeer::doSelectOne($c);
        }
        
        
        
        $this->setTemplate('objetivo');
        if($jugador->esHombrelobo()) 
        {
          $c = new Criteria();
          $c->add(HlJugadoresPeer::HOMBRELOBO,1,CRITERIA::GREATER_EQUAL);
          $this->lobos = HlJugadoresPeer::doSelect($c);
          return "Lobo";
        }
        else return "Generico";
        
          
        
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
        
        if($jugador->getActivo() === 0) $this->redirect('visitas/index');
        if(!$jugador->esHombrelobo()) $this->redirect('visitas/index');
        
        $id_victima = $request->getParameter('id_victima');
        $victima = HlJugadoresPeer::retrieveByPK($id_victima);
        if($victima instanceof HlJugadores)
        {
          if($victima->estaProtegido())
          {
            Juego::registraEvento('Un hombre lobo ha intentado matar.');
            Juego::registraEvento('El hombre lobo ha huído sin conseguir matar.');
            $jugador->setAccion(0); //Indica que ya ha utilizado su acción de matar
            $jugador->save();
          }
          else
          {
            Juego::registraEvento('Un hombre lobo ha matado.');
            $victima->muere();
            $victima->save();
            $jugador->setAccion(0); //Indica que ya ha matado
            $jugador->save();
          }
          Juego::nextFase();   
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
        
        if ($jugador->getActivo() === 0) {
            $this->redirect('visitas/index');
        }
        
        
        $estado = HlEstadoPeer::retrieveByPK(1);
        if($estado->getFase()!="dia")
        {
            $this->redirect('visitas/index');
        }
        
        $ronda = $estado->getRonda();
        $id_victima = $request->getParameter('id_victima');
        $c = new Criteria();
        $c->add(HlVotosPeer::ID_JUGADOR,$id_jugador);
        $c->add(HlVotosPeer::ID_RONDA,$ronda);
        $voto = HlVotosPeer::doSelectOne($c);
        if(!($voto instanceof HlVotos))
        {
          $voto = new HlVotos();
          $voto->setIdJugador($id_jugador);
          $voto->setIdRonda($ronda);
        }
        $voto->setIdVictima($id_victima);
        $voto->save();
        
        $victima = HlJugadoresPeer::retrieveByPK($id_victima);
        Juego::registraEvento($jugador->getNombre().' ha votado a '.$victima->getNombre().'.');
        
        $this->redirect('juego/index');
    }
    
    public function executeVotarHipnotizado(sfWebRequest $request)
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
        
        if ($jugador->getActivo() === 0) {
            $this->redirect('visitas/index');
        }
        
        
        $estado = HlEstadoPeer::retrieveByPK(1);
        if($estado->getFase()!="dia")
        {
            $this->redirect('juego/index');
        }
        
        $ronda = $estado->getRonda();
        $id_hipnotizado = $request->getParameter('id_hipnotizado');
        $id_victima = $request->getParameter('id_victima');
        $c = new Criteria();
        $c->add(HlVotosPeer::ID_JUGADOR,$id_hipnotizado);
        $c->add(HlVotosPeer::ID_RONDA,$ronda);
        $voto = HlVotosPeer::doSelectOne($c);
        if(!($voto instanceof HlVotos))
        {
          $voto = new HlVotos();
          $voto->setIdJugador($id_hipnotizado);
          $voto->setIdRonda($ronda);
        }
        $voto->setIdVictima($id_victima);
        $voto->save();
        
        $jugador_hipnotizado = HlJugadoresPeer::retrieveByPK($id_hipnotizado);
        $victima = HlJugadoresPeer::retrieveByPK($id_victima);
        Juego::registraEvento($jugador_hipnotizado->getNombre().' ha votado a '.$victima->getNombre().'.');
        
        $this->redirect('juego/index');
    }
    
    public function executeCerrarVotacion(sfWebRequest $request)
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
        
        $estado = HlEstadoPeer::retrieveByPK(1);
        $ronda = $estado->getRonda();
        $conexion = Propel::getConnection();

        $sql = "SELECT hl_votos.id_victima as id_victima, count(*) as num_votos 
                FROM hl_votos 
                WHERE id_ronda = $ronda
                GROUP BY id_victima
                ORDER BY num_votos desc
                LIMIT 1
               ;";

        $sentencia = $conexion->prepare($sql);
        $sentencia->execute();
                
        $tRegistro = $sentencia->fetch();
        $max_num_votos = $tRegistro['num_votos'];
     
        $sql = "SELECT hl_votos.id_victima as id_victima, count(*) as num_votos
                FROM hl_votos 
                WHERE id_ronda = $ronda
                GROUP BY id_victima
                having num_votos = $max_num_votos
                ORDER BY num_votos desc
               ;";
        
        $sentencia = $conexion->prepare($sql);
        $sentencia->execute();
                
        $num_victimas = $sentencia->rowCount(); //rowcount no en todas las bbdd funciona con selects

        if($num_victimas < 1)
        {
          //No debería entrar aquí 
          $this->redirect('juego/index');
        }
        elseif($num_victimas > 1)
        {
          //Hay empate
          Juego::registraEvento('Se cierran las votaciones. Ha habido empate.');
          $estado->setFase('desempate');
          $estado->save();
          $this->redirect('juego/index');
        }
        elseif($num_victimas == 1)
        {
          Juego::registraEvento('Se cierran las votaciones.');
          $tRegistro = $sentencia->fetch();
          $id_victima = $tRegistro['id_victima'];

          $victima = HlJugadoresPeer::retrieveByPK($id_victima);
          if($victima instanceof HlJugadores)
          {
            $victima->muere();
            $victima->save();
            $estado->setRonda($estado->getRonda()+1);
            $estado->setFase('noche');
            $estado->save();
            Juego::activarHombresLobo();
            Juego::activarVidencia();
            Juego::activarBrujeria();
            Juego::deshipnotizarJugadores();
            Juego::activarHipnosis();
          }
          $this->redirect('juego/index');
        }
        else
        {
          //Error inesperado
          $this->redirect('juego/index');
        }

        $this->redirect('juego/index');
    }
    
    public function executeDesempatar(sfWebRequest $request)
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
        
      /** @todo Comprobar que tiene el rol de alcalde */
        Juego::registraEvento('El Alcalde ya ha elegido quién debe morir.');
        $id_victima = $request->getParameter('id_victima');
        $victima = HlJugadoresPeer::retrieveByPK($id_victima);
        if($victima instanceof HlJugadores)
        {
          $victima->muere();
          $victima->save();
          $estado = HlEstadoPeer::retrieveByPK(1);
          $estado->setRonda($estado->getRonda()+1);
          $estado->setFase('noche');
          $estado->save();
          Juego::activarHombresLobo();
          Juego::activarVidencia();
          Juego::activarBrujeria();
          Juego::deshipnotizarJugadores();
          Juego::activarHipnosis();
        }
        $this->redirect('juego/index');
        /** @todo escribir muerte en el blog */
    }
    
    public function executeVidencia(sfWebRequest $request)
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
        
        $this->jugador = $jugador;
        $this->nombre = $jugador->getNombre();
        
        if($jugador->getActivo() === 0) $this->redirect('visitas/index');
        if(!$jugador->esVidente()) $this->redirect('visitas/index');
        
        
        $id_victima = $request->getParameter('id_victima');
        $victima = HlJugadoresPeer::retrieveByPK($id_victima);
        $estado = HlEstadoPeer::retrieveByPK(1);
        if($estado->getVidente()==0)
        {
          $this->mensaje = "Ya has utilizado la videncia en este turno";
          return "Error";
        }
        elseif(!($victima instanceof HlJugadores))
        {
          $this->mensaje = "Error en la elección de la víctima.";
          return "Error";
        }
        elseif($victima->getActivo() === 0)
        {
          $this->mensaje = "Debes elegir un jugador que todavía esté activo.";
          return "Error";
        }
        else
        {
          $this->victima = $victima;
          Juego::desactivarVidencia();
          return "Success";
        }
    }
    
    public function executeProteger(sfWebRequest $request)
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
        
        $this->jugador = $jugador;
        $this->nombre = $jugador->getNombre();
        
        if($jugador->getActivo() === 0) $this->redirect('visitas/index');
        if(!$jugador->esGuardaespaldas()) $this->redirect('visitas/index');
        
        //La acción de protección se puede cambiar tanto de día como de noche
        //Justo cuando mate el hombre lobo es cuando se mira si la víctima está protegida o no
        $id_victima = $request->getParameter('id_victima');
        $victima = HlJugadoresPeer::retrieveByPK($id_victima);
        $estado = HlEstadoPeer::retrieveByPK(1);
        if(!($victima instanceof HlJugadores))
        {
          $this->mensaje = "Error en la elección de la víctima.";
          return "Error";
        }
        elseif($victima->getActivo() === 0)
        {
          $this->mensaje = "Debes elegir un jugador que todavía esté activo.";
          return "Error";
        }
        else
        {
          //Se protege al jugador elegido
          $jugador->proteger($victima);
          $jugador->save();
          $this->redirect('juego/objetivo');
        }
    }
    
    public function executeHipnotizar(sfWebRequest $request)
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
        
        $this->jugador = $jugador;
        $this->nombre = $jugador->getNombre();
        
        if($jugador->getActivo() === 0) $this->redirect('visitas/index');
        if(!$jugador->esHipnotizador()) $this->redirect('visitas/index');
        
        $id_victima = $request->getParameter('id_victima');
        $victima = HlJugadoresPeer::retrieveByPK($id_victima);
        $estado = HlEstadoPeer::retrieveByPK(1);
        if($jugador->getAccion()==0)
        {
          $this->mensaje = "Ya has utilizado la hipnosis en este turno";
          return "Error";
        }
        elseif(!($victima instanceof HlJugadores))
        {
          $this->mensaje = "Error en la elección de la víctima.";
          return "Error";
        }
        elseif($victima->getActivo() === 0)
        {
          $this->mensaje = "Debes elegir un jugador que todavía esté activo.";
          return "Error";
        }
        else
        {
          //Se protege al jugador elegido
          $jugador->hipnotizar($victima);
          $jugador->setAccion(0);
          $jugador->save();
          $this->redirect('juego/objetivo');
        }
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
        
        //$this->redirect('juego/index'); //Inhabilitación del método

        Juego::resetear();
        Juego::sortearLobo(2);
        Juego::sortearAlcalde(1);
        Juego::sortearEnamorados(2); //Número de parejas
        Juego::sortearVidente(1);
        Juego::sortearBruja(1);
        Juego::sortearCazador(1);
        Juego::sortearGuardaespaldas(1);
        Juego::sortearEndemoniado(1);
        Juego::sortearHipnotizador(1);
        Juego::activarHombresLobo();
        Juego::activarVidencia();
        Juego::activarBrujeria();
        Juego::activarHipnosis();

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
    
    public function executeHistoricoVotaciones(sfWebRequest $request)
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
        
        $this->jugador = $jugador;
        $this->nombre = $jugador->getNombre();
        
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
      $sql = "SELECT DISTINCT id_victima
              FROM hl_votos
             ;";

      $sentencia = $conexion->prepare($sql);
      $sentencia->execute();
      $jugadores_votados = array();
      while($tRegistro = $sentencia->fetch())
      {
        $jugadores_votados[$tRegistro['id_victima']] = HlJugadoresPeer::retrieveByPK($tRegistro['id_victima']);
      }
      $this->jugadores_votados = $jugadores_votados;
      
    }
    
    public function executeRenunciaHombrelobo()
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
        
        $jugador->setHombrelobo(0);
        $jugador->save();
        Juego::sortearLobo(1);
        $this->redirect('juego/index');
    }
    
    public function executePocionMuerte(sfWebRequest $request) {
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
        
        $id_victima = $request->getParameter('id_victima');
        $victima = HlJugadoresPeer::retrieveByPK($id_victima);
        $estado = HlEstadoPeer::retrieveByPK(1);
        if($estado->getPocionMuerte()==0)
        {
          $this->mensaje = "Ya has utilizado esta poción.";
          return "Error";
        }
        elseif(!($victima instanceof HlJugadores))
        {
          $this->mensaje = "Error en la elección de la víctima.";
          return "Error";
        }
        elseif($victima->getActivo() === 0)
        {
          $this->mensaje = "Debes elegir un jugador que todavía esté activo.";
          return "Error";
        }
        else
        {
          Juego::registraEvento('La bruja utiliza su poción de muerte.');
          $victima->muere();
          $jugador->setAccion(0);
          $jugador->save();
          $estado->setPocionMuerte($estado->getPocionMuerte()-1);
          $estado->save();
        }
        $this->redirect('juego/blog');
    }
    
    public function executePocionVida(sfWebRequest $request) {
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
        
        $id_victima = $request->getParameter('id_victima');
        $victima = HlJugadoresPeer::retrieveByPK($id_victima);
        $estado = HlEstadoPeer::retrieveByPK(1);
        if($estado->getPocionVida()==0)
        {
          $this->mensaje = "Ya has utilizado esta poción.";
          return "Error";
        }
        elseif(!($victima instanceof HlJugadores))
        {
          $this->mensaje = "Error en la elección del jugador.";
          return "Error";
        }
        elseif($victima->getActivo() === 1)
        {
          $this->mensaje = "Debes elegir un jugador que esté muerto.";
          return "Error";
        }
        else
        {
          Juego::registraEvento('La bruja utiliza su poción de vida.');
          $victima->revive();
          $jugador->setAccion(0);
          $jugador->save();
          $estado->setPocionVida($estado->getPocionVida()-1);
          $estado->save();
        }
        $this->redirect('juego/blog');
    }
    
    public function executeEscopeta(sfWebRequest $request) {
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
        
        $id_victima = $request->getParameter('id_victima');
        $victima = HlJugadoresPeer::retrieveByPK($id_victima);
        $estado = HlEstadoPeer::retrieveByPK(1);
        if(!($victima instanceof HlJugadores))
        {
          $this->mensaje = "Error en la elección del jugador.";
          return "Error";
        }
        elseif($victima->getActivo() === 0)
        {
          $this->mensaje = "Debes elegir un jugador que esté vivo.";
          return "Error";
        }
        else
        {
          Juego::registraEvento('El cazador disparó su escopeta.');
          $victima->muere();
          $jugador->setAccion(0);
          $jugador->save();
          $estado->setFase('dia');
          $estado->save();
        }
        $this->redirect('juego/blog');
    }
    
    public function executeNoescopeta(sfWebRequest $request) {
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
        
        Juego::registraEvento('El cazador no disparó su escopeta.');
        $jugador->setAccion(0);
        $jugador->save();
        $estado = HlEstadoPeer::retrieveByPK(1);
        $estado->setFase('dia');
        $estado->save();
        
        $this->redirect('juego/blog');
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
