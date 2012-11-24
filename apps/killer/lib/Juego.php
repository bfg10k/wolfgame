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
  
  public static function sortearLobo($num)
  {
    $c = new Criteria();
    $c->add(HlJugadoresPeer::ACTIVO,1);
    $c->add(HlJugadoresPeer::HOMBRELOBO,0);
    $c->add(HlJugadoresPeer::VIDENTE,0);
    $c->add(HlJugadoresPeer::BRUJA,0);
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
  
}

?>
