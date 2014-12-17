<?php
	
	require_once ( "inc/messages.php" ); // script that makes debugging look nice!
	
	define ("LIST_URL", "http://vip.aersia.net/roster.xml");
	
	// First Stage, Download the list:
	
	msg("Downloading playlist off of '<b>" . LIST_URL . "</b>'");
	
	try{
	
		$xml = file_get_contents(LIST_URL);
	
		if ( strlen( $xml ) == 0 ) throw new Exception ('Zero byte response');
		
		msg( "We got " . strlen($xml) . " bytes of data!", "success" );
	
	
	} catch (Exception $e){
	
		msg($e->getMessage(), "fail", true);
	
	}
	
	
	
	
	
	
	// Second Stage, parse it:
	try{
	
		msg("Escaping ampersands..."); // Apparently, SimpleXML has a little problem with escaped and some unescaped ampersands. This simple REGEX fixes that problem.
		$xml = preg_replace('/&(?!;{6})/', '&amp;', $xml);
		
		msg("Interpreting XML...");
		$playlist = simplexml_load_string($xml);
		
		if (!$playlist) throw new Exception ("Failed to interpret XML response!");
		
		$tracks = $playlist->trackList->track;
		
		if ( count( $tracks ) === 0 ) throw new Exception ("Something went wrong, for some reason I got 0 tracks!");
		
		msg("Found <b>" . count( $tracks ) . "</b>! Looping through all tracks and downloading them!", "success");
		foreach ($tracks as $track){
		
			var_dump($track);
			die();
		
		}
		
		
	} catch (Exception $e){
		
		msg($e->getMessage(), "fail", true);
		
	
	}