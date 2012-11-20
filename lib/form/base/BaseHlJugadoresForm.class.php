<?php

/**
 * HlJugadores form base class.
 *
 * @method HlJugadores getObject() Returns the current form's model object
 *
 * @package    killer
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHlJugadoresForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'nombre'              => new sfWidgetFormInputText(),
      'id_departamento'     => new sfWidgetFormPropelChoice(array('model' => 'HlDepartamentos', 'add_empty' => false)),
      'alias'               => new sfWidgetFormInputText(),
      'foto'                => new sfWidgetFormInputText(),
      'usuario'             => new sfWidgetFormInputText(),
      'contrasena'          => new sfWidgetFormInputText(),
      'email'               => new sfWidgetFormInputText(),
      'descripcion'         => new sfWidgetFormTextarea(),
      'id_victima'          => new sfWidgetFormInputText(),
      'confirmacion_muerte' => new sfWidgetFormInputText(),
      'activo'              => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'nombre'              => new sfValidatorString(array('max_length' => 40)),
      'id_departamento'     => new sfValidatorPropelChoice(array('model' => 'HlDepartamentos', 'column' => 'id')),
      'alias'               => new sfValidatorString(array('max_length' => 40)),
      'foto'                => new sfValidatorString(array('max_length' => 255)),
      'usuario'             => new sfValidatorString(array('max_length' => 128)),
      'contrasena'          => new sfValidatorString(array('max_length' => 128)),
      'email'               => new sfValidatorString(array('max_length' => 40)),
      'descripcion'         => new sfValidatorString(),
      'id_victima'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'confirmacion_muerte' => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'activo'              => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('hl_jugadores[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HlJugadores';
  }


}
