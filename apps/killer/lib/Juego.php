<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Juego
 *
 * @author carlos
 */
class Juego {
  
  public static function nextFase($next=null)
  {
    $estado = HlEstadoPeer::retrieveByPK(1);
    $fase_actual = $estado->getFase();
    if(!is_null($next))
    {
      //Cambiar a una fase concreta
      $estado->setFase($next);
      $estado->save();
    }
    else
    {
      //Lógica de cambios de fase
      switch($fase_actual)
      {
        case "noche":
          if(Juego::todosLobosHanJugado())
          {
            if(Juego::cazadorAcabaDeMorir()) $estado->setFase('cazador');
            else $estado->setFase('dia');
            $estado->save();
          } 
          break;
        case "cazador":
          break;
        case "dia":
          break;
        case "desempate":
          break;
      }
    }
  }
  
  public static function registraEvento($texto)
  {
    $estado = HlEstadoPeer::retrieveByPK(1);
    $fase = $estado->getFase();
    $ronda = $estado->getRonda();
    
    $noticia = new HlNoticias();
    $noticia->setTitulo("Ronda $ronda - $fase");
    $noticia->setNoticia($texto);
    $noticia->setFecha(date());
    $noticia->save();
  }
  
  public static function getRonda()
  {
    $estado = HlEstadoPeer::retrieveByPK(1);
    return $estado->getRonda();
  }
  
  public static function resetear()
  {
    $estado = HlEstadoPeer::retrieveByPK(1);
    $estado->setRonda(0);
    $estado->setFase('noche');
    $estado->setVidente(1);
    $estado->setPocionVida(1);
    $estado->setPocionMuerte(1);
    $estado->save();
    
    HlVotosPeer::doDeleteAll();
    
    $jugadores = HlJugadoresPeer::doSelect(new Criteria());
    foreach ($jugadores as $jugador) {
      $jugador->setActivo(1);
      $jugador->setAccion(0);
      $jugador->setHombrelobo(0);
      $jugador->setAlcalde(0);
      $jugador->setBruja(0);
      $jugador->setCazador(0);
      $jugador->setEnamorado(0);
      $jugador->setEnfermo(0);
      $jugador->setProtegido(0);
      $jugador->setVidente(0);
      $jugador->setGuardaespaldas(0);
      $jugador->setEndemoniado(0);
      $jugador->setHipnotizador(0);
      $jugador->save();
    }
  }
  
  public static function sortearLobo($num)
  {
    $c = new Criteria();
    $c->add(HlJugadoresPeer::ACTIVO,1);
    $c->add(HlJugadoresPeer::HOMBRELOBO,0);
    $c->add(HlJugadoresPeer::VIDENTE,0);
    $c->add(HlJugadoresPeer::BRUJA,0);
    $c->add(HlJugadoresPeer::CAZADOR,0);
    $c->add(HlJugadoresPeer::ENAMORADO,0);
    $c->add(HlJugadoresPeer::GUARDAESPALDAS,0);
    $c->add(HlJugadoresPeer::ENDEMONIADO,0);
    $c->add(HlJugadoresPeer::HIPNOTIZADOR,0);
    $jugadores = HlJugadoresPeer::doSelect($c);
    
    shuffle($jugadores);
    
    $i=0;
    for($i=0;$i<$num;$i++)
    {
      $jugadores[$i]->setHombrelobo($i+1);
      $jugadores[$i]->setAccion(1);
      $jugadores[$i]->save();
    }
  }
  
  public static function sortearAlcalde($num)
  {
    $c = new Criteria();
    $c->add(HlJugadoresPeer::ACTIVO,1);
    $jugadores = HlJugadoresPeer::doSelect($c);
    
    shuffle($jugadores);
    
    $jugadores[0]->setAlcalde(1);
    $jugadores[0]->save();
    Juego::registraEvento($jugadores[0]->getNombre().' es el nuevo Alcalde.');
  }
  
  public static function sortearVidente($num)
  {
    $c = new Criteria();
    $c->add(HlJugadoresPeer::ACTIVO,1);
    $c->add(HlJugadoresPeer::HOMBRELOBO,0);
    $c->add(HlJugadoresPeer::VIDENTE,0);
    $c->add(HlJugadoresPeer::BRUJA,0);
    $c->add(HlJugadoresPeer::CAZADOR,0);
    $c->add(HlJugadoresPeer::ENAMORADO,0);
    $c->add(HlJugadoresPeer::GUARDAESPALDAS,0);
    $c->add(HlJugadoresPeer::ENDEMONIADO,0);
    $c->add(HlJugadoresPeer::HIPNOTIZADOR,0);
    $jugadores = HlJugadoresPeer::doSelect($c);
    
    shuffle($jugadores);
    
    $i=0;
    for($i=0;$i<$num;$i++)
    {
      $jugadores[$i]->setVidente($i+1);
      $jugadores[$i]->save();
    }
  }
  
  public static function sortearBruja($num)
  {
    $c = new Criteria();
    $c->add(HlJugadoresPeer::ACTIVO,1);
    $c->add(HlJugadoresPeer::HOMBRELOBO,0);
    $c->add(HlJugadoresPeer::VIDENTE,0);
    $c->add(HlJugadoresPeer::BRUJA,0);
    $c->add(HlJugadoresPeer::CAZADOR,0);
    $c->add(HlJugadoresPeer::ENAMORADO,0);
    $c->add(HlJugadoresPeer::GUARDAESPALDAS,0);
    $c->add(HlJugadoresPeer::ENDEMONIADO,0);
    $c->add(HlJugadoresPeer::HIPNOTIZADOR,0);
    $jugadores = HlJugadoresPeer::doSelect($c);
    
    shuffle($jugadores);
    
    $i=0;
    for($i=0;$i<$num;$i++)
    {
      $jugadores[$i]->setBruja($i+1);
      $jugadores[$i]->save();
    }
  }
  
  public static function sortearCazador($num)
  {
    $c = new Criteria();
    $c->add(HlJugadoresPeer::ACTIVO,1);
    $c->add(HlJugadoresPeer::HOMBRELOBO,0);
    $c->add(HlJugadoresPeer::VIDENTE,0);
    $c->add(HlJugadoresPeer::BRUJA,0);
    $c->add(HlJugadoresPeer::CAZADOR,0);
    $c->add(HlJugadoresPeer::ENAMORADO,0);
    $c->add(HlJugadoresPeer::GUARDAESPALDAS,0);
    $c->add(HlJugadoresPeer::ENDEMONIADO,0);
    $c->add(HlJugadoresPeer::HIPNOTIZADOR,0);
    $jugadores = HlJugadoresPeer::doSelect($c);
    
    shuffle($jugadores);
    
    $i=0;
    for($i=0;$i<$num;$i++)
    {
      $jugadores[$i]->setCazador($i+1);
      $jugadores[$i]->save();
    }
  }
  
  /**
   *
   * @param type $num Cuántas parejas de enamorados
   */
  public static function sortearEnamorados($num)
  {
    $c = new Criteria();
    $c->add(HlJugadoresPeer::ACTIVO,1);
//    $c->add(HlJugadoresPeer::HOMBRELOBO,0);
//    $c->add(HlJugadoresPeer::VIDENTE,0);
//    $c->add(HlJugadoresPeer::BRUJA,0);
//    $c->add(HlJugadoresPeer::CAZADOR,0);
    $c->add(HlJugadoresPeer::ENAMORADO,0);
//    $c->add(HlJugadoresPeer::GUARDAESPALDAS,0);
//    $c->add(HlJugadoresPeer::ENDEMONIADO,0);
//    $c->add(HlJugadoresPeer::HIPNOTIZADOR,0);
    $jugadores = HlJugadoresPeer::doSelect($c);
    
    shuffle($jugadores);
    
    $i=0; $j=0;
    for($i=0;$i<$num;$i++)
    {
      $jugadores[$j]->setEnamorado($i+1);
      $jugadores[$j]->save();
      $j++;
      $jugadores[$j]->setEnamorado($i+1);
      $jugadores[$j]->save();
      $j++;
    }
  }
  
  public static function sortearGuardaespaldas($num)
  {
    $c = new Criteria();
    $c->add(HlJugadoresPeer::ACTIVO,1);
    $c->add(HlJugadoresPeer::HOMBRELOBO,0);
    $c->add(HlJugadoresPeer::VIDENTE,0);
    $c->add(HlJugadoresPeer::BRUJA,0);
    $c->add(HlJugadoresPeer::CAZADOR,0);
    $c->add(HlJugadoresPeer::ENAMORADO,0);
    $c->add(HlJugadoresPeer::GUARDAESPALDAS,0);
    $c->add(HlJugadoresPeer::ENDEMONIADO,0);
    $c->add(HlJugadoresPeer::HIPNOTIZADOR,0);
    $jugadores = HlJugadoresPeer::doSelect($c);
    
    shuffle($jugadores);
    
    $i=0;
    for($i=0;$i<$num;$i++)
    {
      $jugadores[$i]->setGuardaespaldas($i+1);
      $jugadores[$i]->save();
    }
  }
  
  public static function sortearEndemoniado($num)
  {
    $c = new Criteria();
    $c->add(HlJugadoresPeer::ACTIVO,1);
    $c->add(HlJugadoresPeer::HOMBRELOBO,0);
    $c->add(HlJugadoresPeer::VIDENTE,0);
    $c->add(HlJugadoresPeer::BRUJA,0);
    $c->add(HlJugadoresPeer::CAZADOR,0);
    $c->add(HlJugadoresPeer::ENAMORADO,0);
    $c->add(HlJugadoresPeer::GUARDAESPALDAS,0);
    $c->add(HlJugadoresPeer::ENDEMONIADO,0);
    $c->add(HlJugadoresPeer::HIPNOTIZADOR,0);
    $jugadores = HlJugadoresPeer::doSelect($c);
    
    shuffle($jugadores);
    
    $i=0;
    for($i=0;$i<$num;$i++)
    {
      $jugadores[$i]->setEndemoniado($i+1);
      $jugadores[$i]->save();
    }
  }
  
  public static function sortearHipnotizador($num)
  {
    $c = new Criteria();
    $c->add(HlJugadoresPeer::ACTIVO,1);
    $c->add(HlJugadoresPeer::HOMBRELOBO,0);
    $c->add(HlJugadoresPeer::VIDENTE,0);
    $c->add(HlJugadoresPeer::BRUJA,0);
    $c->add(HlJugadoresPeer::CAZADOR,0);
    $c->add(HlJugadoresPeer::ENAMORADO,0);
    $c->add(HlJugadoresPeer::GUARDAESPALDAS,0);
    $c->add(HlJugadoresPeer::ENDEMONIADO,0);
    $c->add(HlJugadoresPeer::HIPNOTIZADOR,0);
    $jugadores = HlJugadoresPeer::doSelect($c);
    
    shuffle($jugadores);
    
    $i=0;
    for($i=0;$i<$num;$i++)
    {
      $jugadores[$i]->setHipnotizador($i+1);
      $jugadores[$i]->save();
    }
  }
  
  public static function activarHombresLobo()
  {
    $c = new Criteria();
    $c->add(HlJugadoresPeer::ACTIVO,1);
    $c->add(HlJugadoresPeer::HOMBRELOBO,1,CRITERIA::GREATER_EQUAL);
    $hombreslobo = HlJugadoresPeer::doSelect($c);
    foreach ($hombreslobo as $hombrelobo)
    {
      $hombrelobo->setAccion(1);
      $hombrelobo->save();
    }
  }
  
  public static function activarBrujeria()
  {
    $c = new Criteria();
    $c->add(HlJugadoresPeer::ACTIVO,1);
    $c->add(HlJugadoresPeer::BRUJA,1,CRITERIA::GREATER_EQUAL);
    $brujas = HlJugadoresPeer::doSelect($c);
    foreach ($brujas as $bruja)
    {
      $bruja->setAccion(1);
      $bruja->save();
    }
  }
  
  public static function activarVidencia()
  {
    $estado = HlEstadoPeer::retrieveByPK(1);
    $estado->setVidente(1);
    $estado->save();
  }
  
  public static function desactivarVidencia()
  {
    $estado = HlEstadoPeer::retrieveByPK(1);
    $estado->setVidente(0);
    $estado->save();
  }
  
  public static function todosLobosHanJugado()
  {
    $c = new Criteria();
    $c->add(HlJugadoresPeer::ACTIVO,1);
    $c->add(HlJugadoresPeer::HOMBRELOBO,1,CRITERIA::GREATER_EQUAL);
    $c->add(HlJugadoresPeer::ACCION,1);
    $numLobosPorJugar = HlJugadoresPeer::doCount($c);
    return ($numLobosPorJugar == 0);
  }
  
  public static function puedeUtilizarPocionVida()
  {
    $estado = HlEstadoPeer::retrieveByPK(1);
    $num_pociones = $estado->getPocionVida();
    return $num_pociones > 0;
  }
  
  public static function puedeUtilizarPocionMuerte()
  {
    $estado = HlEstadoPeer::retrieveByPK(1);
    $num_pociones = $estado->getPocionMuerte();
    return $num_pociones > 0;
  }
  
  public static function cazadorAcabaDeMorir()
  {
    $c = new Criteria();
    $c->add(HlJugadoresPeer::ACTIVO,0);
    $c->add(HlJugadoresPeer::CAZADOR,1,CRITERIA::GREATER_EQUAL);
    $c->add(HlJugadoresPeer::ACCION,1);
    $numCazadoresRecienMuertos = HlJugadoresPeer::doCount($c);
    echo $numCazadoresRecienMuertos;
    return ($numCazadoresRecienMuertos > 0);
  }
  
}

?>
