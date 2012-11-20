<?php

/**
 * HlNoticias filter form base class.
 *
 * @package    killer
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseHlNoticiasFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_jugador'   => new sfWidgetFormFilterInput(),
      'fecha'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'titulo'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'noticia'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'foto_noticia' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'id_jugador'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fecha'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'titulo'       => new sfValidatorPass(array('required' => false)),
      'noticia'      => new sfValidatorPass(array('required' => false)),
      'foto_noticia' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('hl_noticias_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HlNoticias';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'id_jugador'   => 'Number',
      'fecha'        => 'Date',
      'titulo'       => 'Text',
      'noticia'      => 'Text',
      'foto_noticia' => 'Text',
    );
  }
}
