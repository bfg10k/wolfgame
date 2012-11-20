<?php

/**
 * HlMuertes filter form base class.
 *
 * @package    killer
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseHlMuertesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_asesino'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_victima'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fecha_muerte' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'arma'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'lugar'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'id_asesino'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'id_victima'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fecha_muerte' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'arma'         => new sfValidatorPass(array('required' => false)),
      'lugar'        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('hl_muertes_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HlMuertes';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'id_asesino'   => 'Number',
      'id_victima'   => 'Number',
      'fecha_muerte' => 'Date',
      'arma'         => 'Text',
      'lugar'        => 'Text',
    );
  }
}
