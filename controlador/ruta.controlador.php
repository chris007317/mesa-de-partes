<?php

class ControladorRuta{

	static public function ctrRuta(){
		//return 'https://www.tupvl.com/';
		return "http://localhost/informatica/";
		//return "http://192.168.0.8/reservas-hotel/";
 
	}

	static public function ctrBdSistema(){
		return $bd =[
	        'bd' => 'bd-pvl',
	        'user' => 'root',
	        'contra' => '',
	    ] ;	
	}
}