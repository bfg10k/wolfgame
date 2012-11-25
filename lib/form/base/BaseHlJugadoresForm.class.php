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
      'id'              => new sfWidgetFormInputHidden(),
      'nombre'          => new sfWidgetFormInputText(),
      'id_departamento' => new sfWidgetFormPropelChoice(array('model' => 'HlDepartamentos', 'add_empty' => false)),
      'alias'           => new sfWidgetFormInputText(),
      'foto'            => new sfWidgetFormInputText(),
      'usuario'         => new sfWidgetFormInputText(),
      'contrasena'      => new sfWidgetFormInputText(),
      'email'           => new sfWidgetFormInputText(),
      'descripcion'     => new sfWidgetFormTextarea(),
      'activo'          => new sfWidgetFormInputText(),
      'hombrelobo'      => new sfWidgetFormInputText(),
      'alcalde'         => new sfWidgetFormInputText(),
      'vidente'         => new sfWidgetFormInputText(),
      'enamorado'       => new sfWidgetFormInputText(),
      'bruja'           => new sfWidgetFormInputText(),
      'cazador'         => new sfWidgetFormInputText(),
      'enfermo'         => new sfWidgetFormInputText(),
      'puta'            => new sfWidgetFormInputText(),
      'accion'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'nombre'          => new sfValidatorString(array('max_length' => 40)),
      'id_departamento' => new sfValidatorPropelChoice(array('model' => 'HlDepartamentos', 'column' => 'id')),
      'alias'           => new sfValidatorString(array('max_length' => 40)),
      'foto'            => new sfValidatorString(array('max_length' => 255)),
      'usuario'         => new sfValidatorString(array('max_length' => 128)),
      'contrasena'      => new sfValidatorString(array('max_length' => 128)),
      'email'           => new sfValidatorString(array('max_length' => 40)),
      'descripcion'     => new sfValidatorString(),
      'activo'          => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'hombrelobo'      => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'alcalde'         => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'vidente'         => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'enamorado'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'bruja'           => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'cazador'         => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'enfermo'         => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'puta'            => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'accion'          => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
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
