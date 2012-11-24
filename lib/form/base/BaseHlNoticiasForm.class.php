<?php

/**
 * HlNoticias form base class.
 *
 * @method HlNoticias getObject() Returns the current form's model object
 *
 * @package    killer
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHlNoticiasForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'id_jugador'   => new sfWidgetFormPropelChoice(array('model' => 'HlJugadores', 'add_empty' => true)),
      'fecha'        => new sfWidgetFormDateTime(),
      'titulo'       => new sfWidgetFormInputText(),
      'noticia'      => new sfWidgetFormTextarea(),
      'foto_noticia' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'id_jugador'   => new sfValidatorPropelChoice(array('model' => 'HlJugadores', 'column' => 'id', 'required' => false)),
      'fecha'        => new sfValidatorDateTime(),
      'titulo'       => new sfValidatorString(array('max_length' => 255)),
      'noticia'      => new sfValidatorString(),
      'foto_noticia' => new sfValidatorString(array('max_length' => 255)),
    ));

    $this->widgetSchema->setNameFormat('hl_noticias[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HlNoticias';
  }


}
