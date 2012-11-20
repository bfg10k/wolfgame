<?php

/**
 * KillDepartamentos filter form base class.
 *
 * @package    killer
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseKillDepartamentosFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'departamento' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'departamento' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('kill_departamentos_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'KillDepartamentos';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'departamento' => 'Text',
    );
  }
}
