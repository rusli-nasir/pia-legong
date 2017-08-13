<?php

/**
 * Class Welcome
 */
class Welcome extends Controller {

	/**
	 * Welcome constructor.
	 */
	function Welcome()
	{
		parent::Controller();	
	}

	/**
	 *
	 */
	function index()
	{
		$this->load->view('welcome_message');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */