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
    $estado->save();
    
    $jugadores = HlJugadoresPeer::doSelect(new Criteria());
    foreach ($jugadores as $jugador) {
      $jugador->setActivo(1);
      $jugador->setAccion(0);
      $jugador->setAlcalde(0);
      $jugador->setBruja(0);
      $jugador->setCazador(0);
      $jugador->setEnamorado(0);
      $jugador->setEnfermo(0);
      $jugador->setHombrelobo(0);
      $jugador->setPuta(0);
      $jugador->setVidente(0);
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
    $c->add(HlJugadoresPeer::ENAMORADO,0);
    $jugadores = HlJugadoresPeer::doSelect($c);
    
    shuffle($jugadores);
    
    $i=0;
    for($i=0;$i<$num;$i++)
    {
      $jugadores[$i]->setHombrelobo($i+1);
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
    $c->add(HlJugadoresPeer::ENAMORADO,0);
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
    $c->add(HlJugadoresPeer::ENAMORADO,0);
    $jugadores = HlJugadoresPeer::doSelect($c);
    
    shuffle($jugadores);
    
    $i=0;
    for($i=0;$i<$num;$i++)
    {
      $jugadores[$i]->setBruja($i+1);
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
    $c->add(HlJugadoresPeer::HOMBRELOBO,0);
    $c->add(HlJugadoresPeer::VIDENTE,0);
    $c->add(HlJugadoresPeer::BRUJA,0);
    $c->add(HlJugadoresPeer::ENAMORADO,0);
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
  
}

?>
