<?php



class LoginForm extends sfForm

{



  protected $_object;



  public function getObject()

  {

    return $this->_object;

  }



  public function configure()

  {

    $i18n = sfContext::getInstance()->getI18N();



    $this->widgetSchema['username'] = new sfWidgetFormInputText(array(), array('id' => 'username', 'size' => 25));

    $this->widgetSchema['password'] = new sfWidgetFormInputPassword(array(), array('size' => 25));

    $this->widgetSchema['savepass'] = new sfWidgetFormInputCheckbox(array(), array('id' => 'remember_field'));



    $this->widgetSchema->setLabels(array('username' => $i18n->__('Username').'* :'));

    $this->widgetSchema->setLabels(array('password' => $i18n->__('Password').'* :'));

    $this->widgetSchema->setLabels(array('savepass' => $i18n->__('Remember me').'.'));



    $this->widgetSchema->setHelp('username', $i18n->__('Or email address'));

    $this->widgetSchema->setHelp('password', '<a href="user/forgotPassword">'.$i18n->__('Forget your password?').'</a>');



    $this->validatorSchema['username'] = new sfValidatorString(

            array('required' => true),

            array('required' => $i18n->__('Enter your username')));

    $this->validatorSchema['savepass'] = new sfValidatorPass();



    $this->validatorSchema['password'] = new sfValidatorString(

            array('required' => true),

            array('required' => $i18n->__('Enter your password')));



    $this->widgetSchema->setNameFormat('login[%s]');



    $this->validatorSchema->setPostValidator(

        new sfValidatorCallback(array('callback' => array($this, 'checkPassword')))

    );



    $decorator = new attributeFormDecorator($this->getWidgetSchema());

    $this->widgetSchema->addFormFormatter('custom', $decorator);

    $this->widgetSchema->setFormFormatterName('custom');



    $this->getWidgetSchema()->getFormFormatter()->setHelpFormat('%help%');

  }



  public function checkPassword($validator, $values)

  {

	  $i18n = sfContext::getInstance()->getI18N();

    if ($values['password'] && $values['username'])

    {

      $this->_object = Doctrine::getTable('User')

              ->getUserByNamePassword(

                  $values['username'],

                  $values['password']);



      if (!$this->_object)

      {

        // password is not correct, throw an error

        throw new sfValidatorError($validator, $i18n->__('The username or password you entered is incorrect'));

      }

      // password is correct, return the clean values

    }

    return $values;

  }



}

