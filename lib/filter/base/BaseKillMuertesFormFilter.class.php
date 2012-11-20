<?php

/**
 * KillMuertes filter form base class.
 *
 * @package    killer
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseKillMuertesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_asesino'   => new sfWidgetFormPropelChoice(array('model' => 'KillJugadores', 'add_empty' => true)),
      'id_victima'   => new sfWidgetFormPropelChoice(array('model' => 'KillJugadores', 'add_empty' => true)),
      'fecha_muerte' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'arma'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'lugar'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'id_asesino'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'KillJugadores', 'column' => 'id')),
      'id_victima'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'KillJugadores', 'column' => 'id')),
      'fecha_muerte' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'arma'         => new sfValidatorPass(array('required' => false)),
      'lugar'        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('kill_muertes_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'KillMuertes';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'id_asesino'   => 'ForeignKey',
      'id_victima'   => 'ForeignKey',
      'fecha_muerte' => 'Date',
      'arma'         => 'Text',
      'lugar'        => 'Text',
    );
  }
}
