<?php

/**
 * KillNoticias form base class.
 *
 * @method KillNoticias getObject() Returns the current form's model object
 *
 * @package    killer
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseKillNoticiasForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'id_jugador'   => new sfWidgetFormPropelChoice(array('model' => 'KillJugadores', 'add_empty' => false)),
      'fecha'        => new sfWidgetFormDateTime(),
      'titulo'       => new sfWidgetFormInputText(),
      'noticia'      => new sfWidgetFormTextarea(),
      'foto_noticia' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'id_jugador'   => new sfValidatorPropelChoice(array('model' => 'KillJugadores', 'column' => 'id')),
      'fecha'        => new sfValidatorDateTime(),
      'titulo'       => new sfValidatorString(array('max_length' => 255)),
      'noticia'      => new sfValidatorString(),
      'foto_noticia' => new sfValidatorString(array('max_length' => 255)),
    ));

    $this->widgetSchema->setNameFormat('kill_noticias[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'KillNoticias';
  }


}
