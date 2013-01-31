<?php
/**
 * Helpers for theming, available for all themes in their template files and functions.php.
 * This file is included right before the themes own functions.php
 */

/**
 * Get list of tools.
 */
function get_tools() {
  global $kronos;
  return <<<EOD
<p>Validators: 
<a href="http://validator.w3.org/check/referer">html5</a>
<a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">css3</a>
<a href="http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance">unicorn</a>
<a href="http://validator.w3.org/checklink?uri={$kronos->request->current_url}">links</a>
</p>
EOD;
}


/**
 * Print debuginformation from the framework.
 */
function get_debug() {
	$kronos = CKronos::Instance();
	if(empty($kronos->config['debug'])) {
		return;
	}
	
	$html = null;
	if(isset($kronos->config['debug']['db-num-queries']) && $kronos->config['debug']['db-num-queries'] && isset($kronos->db)) {
		$flash = $kronos->session->GetFlash('database_numQueries');
		$flash = $flash ? "$flash + " : null;
		$html .= "<p>Database made $flash" . $kronos->db->GetNumQueries() . " queries.</p>";
	}
	if(isset($kronos->config['debug']['db-queries']) && $kronos->config['debug']['db-queries'] && isset($kronos->db)) {
		$flash = $kronos->session->GetFlash('database_queries');
		$queries = $kronos->db->GetQueries();
		if($flash) {
			$queries = array_merge($flash, $queries);
		}
		$html .= "<p>Database made the following queries.</p><pre>" . implode('<br/><br/>', $queries) . "</pre>";
	}
	if(isset($kronos->config['debug']['timer']) && $kronos->config['debug']['timer']) {
		$html .= "<p>Page was loaded in " . round(microtime(true) - $kronos->timer['first'], 5)*1000 . " msec.</p>";
	} 
	if(isset($kronos->config['debug']['kronos']) && $kronos->config['debug']['kronos']) {
		$html .= "<hr><h3>Debuginformation</h3><p>The content of CKronos:</p><pre>" . htmlent(print_r($kronos, true)) . "</pre>";
	}
	if(isset($kronos->config['debug']['session']) && $kronos->config['debug']['session']) {
		$html .= "<hr><h3>SESSION</h3><p>The content of CKronos->session:</p><pre>" . htmlent(print_r($kronos->session, true)) . "</pre>";
		$html .= "<p>The content of \$_SESSION:</p><pre>" . htmlent(print_r($_SESSION, true)) . "</pre>";
	} 
	return $html;
}


/**
 * Get messages stored in flash-session.
 */
function get_messages_from_session() {
	$messages = CKronos::Instance()->session->GetMessages();
	$html = null;
	if(!empty($messages)) {
		foreach($messages as $val) {
			$valid = array('info', 'notice', 'success', 'warning', 'error', 'alert');
			$class = (in_array($val['type'], $valid)) ? $val['type'] : 'info';
			$html .= "<div class='$class'>{$val['message']}</div>\n";
		}
	}
	return $html;
}


/**
 * Login menu. Creates a menu which reflects if user is logged in or not.
 */
function login_menu() {
  $kronos = CKronos::Instance();
  if($kronos->user['isAuthenticated']) {
    $items = "<a href='" . create_url('user/profile') . "'><img class='gravatar' src='" . get_gravatar(20) . "' alt=''> " . $kronos->user['acronym'] . "</a> | ";
    if($kronos->user['hasRoleAdmin']) {
      $items .= "<a href='" . create_url('admin') . "'>admin</a> | ";
    }
    $items .= "<a href='" . create_url('user/logout') . "'>logout</a> ";
  } else {
    $items = "<a href='" . create_url('user/login') . "'>login</a> ";
  }
  return "<nav>$items</nav>";
}


/**
 * Get a gravatar based on the logged in user's email.
 */
function get_gravatar($size=null) {
  return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim(CKronos::Instance()->user['email']))) . '.jpg?r=pg&amp;d=wavatar&amp;' . ($size ? "s=$size" : null);
}

/**
 * Get a gravatar based on the user's email from database. To be used together with blog or forum posts by example.
 */
function get_blog_gravatar($email, $size=null) {
  return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '.jpg?r=pg&amp;d=wavatar&amp;' . ($size ? "s=$size" : null);
}


/**
 * Escape data to make it safe to write in the browser.
 *
 * @param $str string to escape.
 * @returns string the escaped string.
 */
function esc($str) {
  return htmlEnt($str);
}


/**
 * Filter data according to a filter. Uses CMContent::Filter()
 *
 * @param $data string the data-string to filter.
 * @param $filter string the filter to use.
 * @returns string the filtered string.
 */
function filter_data($data, $filter) {
  return CMContent::Filter($data, $filter);
}


/**
 * Display diff of time between now and a datetime.
 *
 * @param $start datetime|string
 * @returns string
 */
function time_diff($start) {
  return formatDateTimeDiff($start);
}


/**
 * Prepend the base_url.
 */
function base_url($url=null) {
  return CKronos::Instance()->request->base_url . trim($url, '/');
}


/**
 * Create a url to an internal resource.
 *
 * @param string the whole url or the controller. Leave empty for current controller.
 * @param string the method when specifying controller as first argument, else leave empty.
 * @param string the extra arguments to the method, leave empty if not using method.
 */
function create_url($urlOrController=null, $method=null, $arguments=null) {
  return CKronos::Instance()->CreateUrl($urlOrController, $method, $arguments);
}


/**
 * Prepend the theme_url, which is the url to the current theme directory.
 *
 * @param $url string the url-part to prepend.
 * @returns string the absolute url.
 */
function theme_url($url) {
  return create_url(CKronos::Instance()->themeUrl . "/{$url}");
}


/**
 * Prepend the theme_parent_url, which is the url to the parent theme directory.
 *
 * @param $url string the url-part to prepend.
 * @returns string the absolute url.
 */
function theme_parent_url($url) {
  return create_url(CKronos::Instance()->themeParentUrl . "/{$url}");
}


/**
 * Return the current url.
 */
function current_url() {
	return CKronos::Instance()->request->current_url;
}


/**
 * Render all views.
 *
 * @param $region string the region to draw the content in.
 */
function render_views($region='default') {
  return CKronos::Instance()->views->Render($region);
}


/**
 * Check if region has views. Accepts variable amount of arguments as regions.
 *
 * @param $region string the region to draw the content in.
 */
function region_has_content($region='default' /*...*/) {
  return CKronos::Instance()->views->RegionHasView(func_get_args());
}


/**
 * A menu that shows all available controllers, to use in development phase
 */
  function main_menu() {	
    $kronos = CKronos::Instance();
	$items = null;
    foreach($kronos->config['controllers'] as $key => $val) {
      if($val['enabled']) {
		$selected = ($key == $kronos->request->controller) ? 'class="selected"' : null; 
        $items .= "<a href='" . create_url($key) . "' $selected>" . strtoupper($key) . "</a> ";
      }
    }
    return "<nav id='main-menu'>$items</nav>";
  }

  function logo($logo){
	
	
	if (is_file(KRONOS_APPLICATION_PATH . "/themes/mySimplyBlogg/{$logo}")){
		return theme_url($logo);
	}
  }