<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('Utilerias');
	}

	public function index()
	{
		$data["titulo"] = "index";
		$this->direcciona_user(3);
		// Utilerias::pagina_basica($this, "index", $data);
	}// index()

	

}// class
