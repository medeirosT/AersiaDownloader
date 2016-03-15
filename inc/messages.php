<link rel="stylesheet" type="text/css" href="inc/data/messages.css">
<?php
	
	// This is over the top for a single downloading script
	// You are right.
	
	// I do, however, love these messages for debugging / informative status on progress / etc..
	// So this is basically me doing something fancy for my own sake. Feel free to use this on your code as well.
	
	define ( "DEBUG", isset( $_GET['debug'] ) );
	
	if (DEBUG) echo "<pre>";		// makes my life easier
	
	// !!!!!!!!!!!!!
	// Function
	// !!!!!!!!!!!!!
	//
	// Name 		: msg
	// Description 	: Shows message with proper formatting on-screen
	// Params 		:
	//
	//	$message 		- Message to show user
	//  $message_type	- Type of message (if its a warning/error/etc..)
	//					  Possible values are : default, success, warning, error, fail
	//	$stop			- whether or not to die afterwards
	
	function msg ( $message, $message_type = 'message', $stop = false ){
	
		$html = '<b class="' . $message_type . '">';						// Create first B tag with appropriate class 
		$html .= ucfirst($message_type) . ' </b>: ' . $message . '<br>';	// Add content, finish B tag, add BR
		
		echo $html . "\n";												// Output our message
		
		flush();															// Make sure to flush it, so it shows ASAP.
		//ob_flush();
		
		if ($stop) die();													// Die if we have to.		
	
	}
