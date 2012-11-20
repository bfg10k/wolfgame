<?php

/**
 * KillNoticias filter form base class.
 *
 * @package    killer
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseKillNoticiasFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_jugador'   => new sfWidgetFormPropelChoice(array('model' => 'KillJugadores', 'add_empty' => true)),
      'fecha'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'titulo'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'noticia'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'foto_noticia' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'id_jugador'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'KillJugadores', 'column' => 'id')),
      'fecha'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'titulo'       => new sfValidatorPass(array('required' => false)),
      'noticia'      => new sfValidatorPass(array('required' => false)),
      'foto_noticia' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('kill_noticias_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'KillNoticias';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'id_jugador'   => 'ForeignKey',
      'fecha'        => 'Date',
      'titulo'       => 'Text',
      'noticia'      => 'Text',
      'foto_noticia' => 'Text',
    );
  }
}
