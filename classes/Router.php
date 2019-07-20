<?php 

class Router
{
	private $server;
	private $controller_name;
	private $method_name;

	public function __construct()
	{
		$this->server = $_SERVER;
		$this->resolveController();
		$this->instantiateController();
	}

	// spliting the url to the parts, so we can use the first part as controller and the second as method.
	private function resolveController()
	{	
		$path_parts = substr($this->server['REQUEST_URI'], 1);
		$path_parts = explode('/', $path_parts);
		$controller_name = $path_parts[0];
	
		$this->controller_name = ucfirst($controller_name) . 'Controller';

		$method_name = explode('?', $path_parts[1]);

		if(strpos($method_name[0], '-') > 0) {
			$method_name_parts = explode('-', $method_name[0]);
			$method_name = $method_name_parts[0] . ucfirst($method_name_parts[1]);
		} else {
			$method_name = $method_name[0];
		}
		$this->method_name = $method_name;
	}

	// instantiate the controller
	private function instantiateController()
	{
		$controller = new $this->controller_name();
		$method = $this->method_name;
		$controller->$method();
	}
}