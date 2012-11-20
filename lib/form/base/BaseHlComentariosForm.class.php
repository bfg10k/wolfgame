<?php

/**
 * HlComentarios form base class.
 *
 * @method HlComentarios getObject() Returns the current form's model object
 *
 * @package    killer
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHlComentariosForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'id_jugador' => new sfWidgetFormPropelChoice(array('model' => 'HlJugadores', 'add_empty' => true)),
      'id_noticia' => new sfWidgetFormPropelChoice(array('model' => 'HlNoticias', 'add_empty' => false)),
      'texto'      => new sfWidgetFormTextarea(),
      'fecha'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'id_jugador' => new sfValidatorPropelChoice(array('model' => 'HlJugadores', 'column' => 'id', 'required' => false)),
      'id_noticia' => new sfValidatorPropelChoice(array('model' => 'HlNoticias', 'column' => 'id')),
      'texto'      => new sfValidatorString(),
      'fecha'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('hl_comentarios[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HlComentarios';
  }


}
