<?php



class myUser extends sfBasicSecurityUser

{



  public function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array())

  {

    // disable timeout

    $options['timeout'] = false;

    parent::initialize($dispatcher, $storage, $options);

  }



  /**

   * @return User instance

   */

  public function getInstance()

  {

    if (!$this->isAuthenticated() || !$this->hasCredential('bizuser'))

    {

      return null;

    }

    if (!isset($this->_instance))

    {

      $this->_instance = Doctrine::getTable('User')->find($this->getId());

    }



    return $this->_instance;

  }



  /**

   * return User id

   * @return integer

   */

  public function getId()

  {

    if ($this->isAuthenticated())

    {

      return $this->getAttribute('user_id', 0, "bizUser");

    }

    return null;

  }



  /**

   * User sign in

   * @param User $user

   */

  public function signIn($user)

  {

    $this->setAuthenticated(true);



    $this->addCredential('bizuser');



    $this->setAttribute('user_id', $user->getId(), "bizUser");

    $this->setAttribute('username', $user->getUsername());

    $this->setAttribute('name', ucfirst($user->getFirstname()));

    $this->setAttribute('firstname', $user->getFirstname());

    $this->setAttribute('lastname', $user->getLastname());

    $this->setAttribute('fullname', $user->getUsername());

    $this->setAttribute('address', $user->getAddress());

    $this->setAttribute('image', $user->getImage());

    $this->setAttribute('email', $user->getEmail());

    $this->setAttribute('culture', $user->getCulture());

    $this->setAttribute('xarea', $user->getXAreaId());

  }



  /**

   * Checking user is logged

   * @return <type>

   */

  public function isLogged()

  {

    /*

      if ($this->getAttribute('user_id', 0, "bizUser"))

      {

      $this->signOut();

      }

     * */

    return ($this->isAuthenticated() && $this->hasCredential('bizuser'));

  }



  /**

   * Sign out user

   */

  public function signOut()

  {

    $this->clearCredentials();

    $this->setAuthenticated(false);

    $this->getAttributeHolder()->clear();



    // for safest way

    //session_destroy();

    //session_write_close();

    //session_regenerate_id();

  }



  public function getUsername()

  {

    return $this->getAttribute('username', '');

  }



  public function getLastname()

  {

    return $this->getAttribute('lastname', '');

  }



  public function getFirstname()

  {

    return $this->getAttribute('firstname', '');

  }



  public function getName()

  {

    return $this->getAttribute('name', '');

  }



  public function getImage()

  {

    return $this->getAttribute('image', '');

  }



  public function getEmail()

  {

    return $this->getAttribute('email', '');

  }



  public function getAddress()

  {

    return $this->getAttribute('address', '');

  }



  public function getPreffXArea()

  {

    return $this->getAttribute('xarea', '');

  }



  public function isFirstRequest($boolean = null)

  {

    if (is_null($boolean))

    {

      return $this->getAttribute('first_request', true);

    }

    $this->setAttribute('first_request', $boolean);

  }



  public function getPreffCurrency()

  {

    return LanguageTable::getPreffCurrency($this->getAttribute('culture', ''));

  }

  public function getCurrSymbol()

  {

    return CurrencyTable::getInstance()->getSymbol($this->getPreffCurrency());

  }
  public function sayHello()

  {
	
    //return CurrencyTable::getInstance()->getSymbol($this->getPreffCurrency());

  }
  
  function setLangAndCurrInCookie($currency, $culture, $action)
  {
	if($action == 'set'){
		sfContext::getInstance()->getResponse()->setCookie('setCurr',$currency,time()+ 60*60*24*30,'/');  // expire after 30 Days.
		sfContext::getInstance()->getResponse()->setCookie('setLang',$culture,time()+ 60*60*24*30,'/');   // expire after 30 Days.
	} else if($action == 'reset'){
		sfContext::getInstance()->getResponse()->setCookie('setCurr',"",time()-60*60*24*30,'/');
		sfContext::getInstance()->getResponse()->setCookie('setLang',"",time()-60*60*24*30,'/');
		
		sfContext::getInstance()->getResponse()->setCookie('setCurr',$currency,time()+ 60*60*24*30,'/');	// expire after 30 Days.
		sfContext::getInstance()->getResponse()->setCookie('setLang',$culture,time()+ 60*60*24*30,'/');	// expire after 30 Days.
	}
  }

}

