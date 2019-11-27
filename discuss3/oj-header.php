<?php 
	require('../include/db_info.inc.php');
   ob_start();
   if ( !isset( $_SESSION[ 'user_id' ] ) ) {
		$view_errors = "<a href=loginpage.php>$MSG_Login</a>";
		require( "template/" . $OJ_TEMPLATE . "/error.php" );
		exit( 0 );
	}
?>
