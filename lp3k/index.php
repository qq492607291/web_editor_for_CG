<?php

if(!isset($_GET['c']) || !isset($_GET['a']) ){
    die('Access Denied/Forbidden');
}


/* lp app root */
// ↑____ for aoi . Do Not Delete it.
/****  load lp framework  ***/
define( 'DS' , DIRECTORY_SEPARATOR );
define( 'AROOT' , dirname( __FILE__ ) . DS  );

//ini_set('include_path', dirname( __FILE__ ) . DS .'_lp' ); 
include_once( '_lp'.DS .'lp.init.php' );
/**** lp framework init finished ***/
