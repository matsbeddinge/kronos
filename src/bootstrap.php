<?php
// 	BOOTSTRAP, SET UP AND LOAD CORE	
//	@PACKAGE KRONOS CORE
//


//	ENABLE AUTOLOAD OF CLASSES
function autoload($aClassName) {
	$classFile = "/src/{$aClassName}/{$aClassName}.php";
	$file1 = KRONOS_APPLICATION_PATH . $classFile;
	$file2 = KRONOS_INSTALL_PATH . $classFile;
	if(is_file($file1)) {
		require_once($file1);
	} elseif(is_file($file2)) {
		require_once($file2);
	}
}
spl_autoload_register('autoload');


//	HELPER WRAP HTML_ENTITIES WITH CORRECT CHARACTER ENCODING
/*function htmlent($str, $flags = ENT_COMPAT) {
	return htmlentities($str, $flags, CKronos::Instance()->config['character_encoding']);
}*/

function htmlent($str, $flags = ENT_QUOTES) {
	return str_replace("/", "&#x2F;", htmlentities($str, $flags, CKronos::Instance()->config['character_encoding']));
}

/**
* Helper, make clickable links from URLs in text.
*/
function makeClickable($text) {
  return preg_replace_callback(
    '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
    create_function(
      '$matches',
      'return "<a href=\'{$matches[0]}\'>{$matches[0]}</a>";'
    ),
    $text
  );
}



//	EXCEPTION HANDLER, ENABLE LOGGING
function exception_handler($e) {
	echo "Kronos: Uncaught exception: <p>" . $e->getMessage() . "</p><pre>" . $e->getTraceAsString(), "</pre>";
}
set_exception_handler('exception_handler');



/**
* Helper, interval formatting of times. Needs PHP5.3.
*
* All times in database is UTC so this function assumes the starttime to be in UTC, if not otherwise
* stated.
*
* Copied from http://php.net/manual/en/dateinterval.format.php#96768
* Modified (mos) to use timezones.
* A sweet interval formatting, will use the two biggest interval parts.
* On small intervals, you get minutes and seconds.
* On big intervals, you get months and days.
* Only the two biggest parts are used.
*
* @param DateTime|string $start
* @param DateTimeZone|string|null $startTimeZone
* @param DateTime|string|null $end
* @param DateTimeZone|string|null $endTimeZone
* @return string
*/
/*
function formatDateTimeDiff($start, $startTimeZone=null, $end=null, $endTimeZone=null) {
  if(!($start instanceof DateTime)) {
    if($startTimeZone instanceof DateTimeZone) {
      $start = new DateTime($start, $startTimeZone);
    } else if(is_null($startTimeZone)) {
      $start = new DateTime($start);
    } else {
      $start = new DateTime($start, new DateTimeZone($startTimeZone));
    }
  }
  
  if($end === null) {
    $end = new DateTime();
  }
  
  if(!($end instanceof DateTime)) {
    if($endTimeZone instanceof DateTimeZone) {
      $end = new DateTime($end, $endTimeZone);
    } else if(is_null($endTimeZone)) {
      $end = new DateTime($end);
    } else {
      $end = new DateTime($end, new DateTimeZone($endTimeZone));
    }
  }
  
  $interval = $end->diff($start);
  $doPlural = function($nb,$str){return $nb>1?$str.'s':$str;}; // adds plurals
  //$doPlural = create_function('$nb,$str', 'return $nb>1?$str."s":$str;'); // adds plurals
  
  $format = array();
  if($interval->y !== 0) {
    $format[] = "%y ".$doPlural($interval->y, "year");
  }
  if($interval->m !== 0) {
    $format[] = "%m ".$doPlural($interval->m, "month");
  }
  if($interval->d !== 0) {
    $format[] = "%d ".$doPlural($interval->d, "day");
  }
  if($interval->h !== 0) {
    $format[] = "%h ".$doPlural($interval->h, "hour");
  }
  if($interval->i !== 0) {
    $format[] = "%i ".$doPlural($interval->i, "minute");
  }
  if(!count($format)) {
      return "less than a minute";
  }
  if($interval->s !== 0) {
    $format[] = "%s ".$doPlural($interval->s, "second");
  }
  
  if($interval->s !== 0) {
      if(!count($format)) {
          return "less than a minute";
      } else {
          $format[] = "%s ".$doPlural($interval->s, "second");
      }
  }
  
  // We use the two biggest parts
  if(count($format) > 1) {
      $format = array_shift($format)." and ".array_shift($format);
  } else {
      $format = array_pop($format);
  }
  
  // Prepend 'since ' or whatever you like
  return $interval->format($format);
}*/


/**
* Helper, BBCode formatting converting to HTML.
*
* @param string text The text to be converted.
* @returns string the formatted text.
*/
function bbcode2html($text) {
  $search = array(
    '/\[b\](.*?)\[\&\#x2F\;b\]/is',
    '/\[i\](.*?)\[\&\#x2F\;i\]/is',
    '/\[u\](.*?)\[\&\#x2F\;u\]/is',
    '/\[img\](https?.*?)\[\&\#x2F\;img\]/is',
    '/\[url\](https?.*?)\[\&\#x2F\;url\]/is',
    '/\[url=(https?.*?)\](.*?)\[\&\#x2F\;url\]/is'
    );
  $replace = array(
    '<strong>$1</strong>',
    '<em>$1</em>',
    '<u>$1</u>',
    '<img src="$1" />',
    '<a href="$1">$1</a>',
    '<a href="$1">$2</a>'
    );
  return preg_replace($search, $replace, $text);
}