<?php
	
	require_once ( "inc/messages.php" ); // script that makes debugging look nice!
	
	define ("LIST_URL", "http://vip.aersia.net/roster.xml");
	
	// First Stage, Download the list:
	
	msg("Downloading playlist off of '<b>" . LIST_URL . "</b>'");
	msg('Check changelog <a href="http://vip.aersia.net/changelog.txt">HERE</a>', "warning" );
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
		$total_tracks = count( $tracks );
		if ( $total_tracks === 0 ) throw new Exception ("Something went wrong, for some reason I got 0 tracks!");
		
		msg("Found <b>$total_tracks</b>! Looping through all tracks and downloading them!", "success");
		
		$position = 1;
		foreach ($tracks as $track){
		
			msg("Downloading track #$position/$total_tracks (<b>" . $track->creator . '- ' . $track->title . '</b>)');
			
			// Some playlist entries have invalid characters, this removes all of them, and replaces them with dots:
			$filename = './music/'. preg_replace('/[^a-zA-Z0-9-\s]/u', '', $track->creator);
			$filename .= ' - ' . preg_replace('/[^a-zA-Z0-9-\s]/u', '', $track->title) . '.m4a';	

			if ( !file_exists( $filename ) ){
			
				$track_binary = file_get_contents( $track->location );
				if ( strlen( $track_binary ) == 0 ) throw new Exception ('Zero byte response'); 
				
					
				
				$result = file_put_contents( $filename, $track_binary );
				
				if( $result === false ) throw new Exception("Error writing file, possible permission problem!");
			
			} else {
			
				msg("Already downloaded this track, skipping!");
			
			}
		
			$position++;
		}
		
		
	} catch (Exception $e){
		
		msg($e->getMessage(), "fail", true);
		
	
	}
	
	msg("Done, have a nice day! :)", "success", true);