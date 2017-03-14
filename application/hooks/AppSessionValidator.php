<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AppSessionValidator
{

    private $ci;
    private $strRedirectUrl = "auth/login/";
    private $currentController;
    private $arrExludedControllers = array("auth");


    public function __construct()
    {
        $this->ci = &get_instance();
        $this->currentController = $this->ci->router->class;
    }

    public function check_login()
    {
        if (!$this->ci->ion_auth->logged_in() && !in_array($this->currentController, $this->arrExludedControllers))
        {
            redirect($this->strRedirectUrl);
        }
    }
}
