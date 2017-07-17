<?php
/*
Plugin Name: Custom Styling
Plugin URI: http://the-hosts.com/
Description: Gives you the ability to add custom CSS rules to your website's header.
Version: 1.0
Author: The Hosts
Author URI: http://the-hosts.com/
License: GPL2
*/

function wpcs_add_styling(){
	$styling = get_option('wpcs_styling');
	if(!empty($styling)):
?>
	<style type="text/css"><?=wpcs_minify_css($styling)?></style>
<?php
	endif;
}
add_action('wp_head', 'wpcs_add_styling', 9999);

function wpcs_minify_css($css){
	$css = preg_replace(array('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '!\s+!'), ' ', $css);
	$css = str_replace(array(': ', ' :'), ':', $css);
	$css = str_replace(array('; ', ' ;'), ';', $css);
	$css = str_replace(array('{ ', ' {'), '{', $css);
	$css = str_replace(array('} ', ' }'), '}', $css);
	return $css;
}

include('css-editor.php');