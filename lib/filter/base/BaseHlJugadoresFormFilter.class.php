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
      'nombre'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_departamento' => new sfWidgetFormPropelChoice(array('model' => 'HlDepartamentos', 'add_empty' => true)),
      'alias'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'foto'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'usuario'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'contrasena'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'descripcion'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'activo'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'hombrelobo'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'alcalde'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'vidente'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'enamorado'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'bruja'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cazador'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'enfermo'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'puta'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'nombre'          => new sfValidatorPass(array('required' => false)),
      'id_departamento' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'HlDepartamentos', 'column' => 'id')),
      'alias'           => new sfValidatorPass(array('required' => false)),
      'foto'            => new sfValidatorPass(array('required' => false)),
      'usuario'         => new sfValidatorPass(array('required' => false)),
      'contrasena'      => new sfValidatorPass(array('required' => false)),
      'email'           => new sfValidatorPass(array('required' => false)),
      'descripcion'     => new sfValidatorPass(array('required' => false)),
      'activo'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'hombrelobo'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'alcalde'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'vidente'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'enamorado'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'bruja'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cazador'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'enfermo'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'puta'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
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
      'id'              => 'Number',
      'nombre'          => 'Text',
      'id_departamento' => 'ForeignKey',
      'alias'           => 'Text',
      'foto'            => 'Text',
      'usuario'         => 'Text',
      'contrasena'      => 'Text',
      'email'           => 'Text',
      'descripcion'     => 'Text',
      'activo'          => 'Number',
      'hombrelobo'      => 'Number',
      'alcalde'         => 'Number',
      'vidente'         => 'Number',
      'enamorado'       => 'Number',
      'bruja'           => 'Number',
      'cazador'         => 'Number',
      'enfermo'         => 'Number',
      'puta'            => 'Number',
    );
  }
}
