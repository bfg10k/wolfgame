<?php

/**
 * HlComentarios filter form base class.
 *
 * @package    killer
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseHlComentariosFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_jugador' => new sfWidgetFormPropelChoice(array('model' => 'HlJugadores', 'add_empty' => true)),
      'id_noticia' => new sfWidgetFormPropelChoice(array('model' => 'HlNoticias', 'add_empty' => true)),
      'texto'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fecha'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'id_jugador' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'HlJugadores', 'column' => 'id')),
      'id_noticia' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'HlNoticias', 'column' => 'id')),
      'texto'      => new sfValidatorPass(array('required' => false)),
      'fecha'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('hl_comentarios_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HlComentarios';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'id_jugador' => 'ForeignKey',
      'id_noticia' => 'ForeignKey',
      'texto'      => 'Text',
      'fecha'      => 'Date',
    );
  }
}
