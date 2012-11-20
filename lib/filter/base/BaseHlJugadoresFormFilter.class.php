<?php

/**
 * HlJugadores filter form base class.
 *
 * @package    killer
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseHlJugadoresFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_departamento'     => new sfWidgetFormPropelChoice(array('model' => 'HlDepartamentos', 'add_empty' => true)),
      'alias'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'foto'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'usuario'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'contrasena'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'descripcion'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_victima'          => new sfWidgetFormFilterInput(),
      'confirmacion_muerte' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'activo'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'nombre'              => new sfValidatorPass(array('required' => false)),
      'id_departamento'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'HlDepartamentos', 'column' => 'id')),
      'alias'               => new sfValidatorPass(array('required' => false)),
      'foto'                => new sfValidatorPass(array('required' => false)),
      'usuario'             => new sfValidatorPass(array('required' => false)),
      'contrasena'          => new sfValidatorPass(array('required' => false)),
      'email'               => new sfValidatorPass(array('required' => false)),
      'descripcion'         => new sfValidatorPass(array('required' => false)),
      'id_victima'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'confirmacion_muerte' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'activo'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('hl_jugadores_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HlJugadores';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'nombre'              => 'Text',
      'id_departamento'     => 'ForeignKey',
      'alias'               => 'Text',
      'foto'                => 'Text',
      'usuario'             => 'Text',
      'contrasena'          => 'Text',
      'email'               => 'Text',
      'descripcion'         => 'Text',
      'id_victima'          => 'Number',
      'confirmacion_muerte' => 'Number',
      'activo'              => 'Number',
    );
  }
}
