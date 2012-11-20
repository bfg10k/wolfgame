<?php

/**
 * KillDepartamentos form base class.
 *
 * @method KillDepartamentos getObject() Returns the current form's model object
 *
 * @package    killer
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseKillDepartamentosForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'departamento' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'departamento' => new sfValidatorString(array('max_length' => 255)),
    ));

    $this->widgetSchema->setNameFormat('kill_departamentos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'KillDepartamentos';
  }


}
