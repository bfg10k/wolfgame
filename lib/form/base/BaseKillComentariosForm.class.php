<?php

/**
 * KillComentarios form base class.
 *
 * @method KillComentarios getObject() Returns the current form's model object
 *
 * @package    killer
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseKillComentariosForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'id_jugador' => new sfWidgetFormPropelChoice(array('model' => 'KillJugadores', 'add_empty' => false)),
      'id_noticia' => new sfWidgetFormPropelChoice(array('model' => 'KillNoticias', 'add_empty' => false)),
      'texto'      => new sfWidgetFormTextarea(),
      'fecha'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'id_jugador' => new sfValidatorPropelChoice(array('model' => 'KillJugadores', 'column' => 'id')),
      'id_noticia' => new sfValidatorPropelChoice(array('model' => 'KillNoticias', 'column' => 'id')),
      'texto'      => new sfValidatorString(),
      'fecha'      => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorPropelUnique(array('model' => 'KillComentarios', 'column' => array('id_jugador'))),
        new sfValidatorPropelUnique(array('model' => 'KillComentarios', 'column' => array('id_noticia'))),
      ))
    );

    $this->widgetSchema->setNameFormat('kill_comentarios[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'KillComentarios';
  }


}
