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
    $noticia->setTitulo($ronda." - ".$fase);
    $noticia->setNoticia($texto);
    $noticia->setFecha(date());
    $noticia->save();
  }
  
  public static function sortearAlcalde()
  {
    $c = new Criteria();
    $c->add(HlJugadoresPeer::ACTIVO,1);
    $jugadores = HlJugadoresPeer::doSelect($c);
    
    shuffle($jugadores);
    
    $jugadores[0]->setAlcalde(1);
    $jugadores[0]->save();
    Juego::registraEvento($jugadores[0]->getNombre().' es el nuevo Alcalde.');
  }
}

?>
