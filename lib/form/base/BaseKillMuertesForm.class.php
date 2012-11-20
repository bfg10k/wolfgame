<?php

/**
 * KillMuertes form base class.
 *
 * @method KillMuertes getObject() Returns the current form's model object
 *
 * @package    killer
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseKillMuertesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'id_asesino'   => new sfWidgetFormPropelChoice(array('model' => 'KillJugadores', 'add_empty' => false)),
      'id_victima'   => new sfWidgetFormPropelChoice(array('model' => 'KillJugadores', 'add_empty' => false)),
      'fecha_muerte' => new sfWidgetFormDateTime(),
      'arma'         => new sfWidgetFormInputText(),
      'lugar'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'id_asesino'   => new sfValidatorPropelChoice(array('model' => 'KillJugadores', 'column' => 'id')),
      'id_victima'   => new sfValidatorPropelChoice(array('model' => 'KillJugadores', 'column' => 'id')),
      'fecha_muerte' => new sfValidatorDateTime(),
      'arma'         => new sfValidatorString(array('max_length' => 50)),
      'lugar'        => new sfValidatorString(array('max_length' => 100)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'KillMuertes', 'column' => array('id')))
    );

    $this->widgetSchema->setNameFormat('kill_muertes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'KillMuertes';
  }


}
