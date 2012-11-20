<?php

/**
 * HlMuertes form base class.
 *
 * @method HlMuertes getObject() Returns the current form's model object
 *
 * @package    killer
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHlMuertesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'id_asesino'   => new sfWidgetFormInputText(),
      'id_victima'   => new sfWidgetFormInputText(),
      'fecha_muerte' => new sfWidgetFormDateTime(),
      'arma'         => new sfWidgetFormInputText(),
      'lugar'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'id_asesino'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_victima'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'fecha_muerte' => new sfValidatorDateTime(),
      'arma'         => new sfValidatorString(array('max_length' => 50)),
      'lugar'        => new sfValidatorString(array('max_length' => 100)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'HlMuertes', 'column' => array('id')))
    );

    $this->widgetSchema->setNameFormat('hl_muertes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HlMuertes';
  }


}
