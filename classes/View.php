<?php 

class View
{
	public $data = array();

	public function __construct()
	{

	}

	public function loadPage($entity_name, $partial_name)
	{
		require('./view/includes/header.php');

		require('./view/'.$entity_name.'/'.$partial_name.'.php');

		require('./view/includes/footer.php');
	}

}
