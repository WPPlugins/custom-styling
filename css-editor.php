<?php
/**
* The Code Editor
*/

function wpcs_menu_item() {
	global $wpcs_page_hook;
    $wpcs_page_hook = add_theme_page(
        'Custom Styling',         			   		// The title to be displayed in the browser window for this page.
        'Custom Styling',			            	// The text to be displayed for this menu item
        'administrator',            				// Which type of users can see this menu item  
        'wpcs_custom_styling',    						// The unique ID - that is, the slug - for this menu item
        'wpcs_render_settings_page'     			// The name of the function to call when rendering this menu's page  
    );
}
add_action( 'admin_menu', 'wpcs_menu_item' );

function wpcs_scripts_styles($hook) {
	global $wpcs_page_hook;
	if( $wpcs_page_hook != $hook )
		return;
	wp_enqueue_style("wpcs_code_editor_stylesheet", plugins_url( "static/css/code-editor.css" , __FILE__ ), false, "1.0", "all");
	wp_enqueue_style("wpcs_codemirror_stylesheet", plugins_url( "static/css/codemirror.css" , __FILE__ ), false, "1.0", "all");
	wp_enqueue_script("wpcs_codemirror_script", plugins_url( "static/js/codemirror.min.js" , __FILE__ ), false, "1.0");
	wp_enqueue_script("wpcs_code_editor_script", plugins_url( "static/js/code-editor.js" , __FILE__ ), array('wpcs_codemirror_script', 'jquery'), "1.0");
}
add_action( 'admin_enqueue_scripts', 'wpcs_scripts_styles' );

function wpcs_render_settings_page() {
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"></div>
	<?php if(isset($_GET['settings-updated']) && $_GET['settings-updated'] == true){echo '<div class="updated settings-error">CSS saved.</div>';} ?>
	<h2>Custom Styling</h2>
	<form method="post" action="options.php">
		<?php settings_fields( 'wpcs_custom_styling' ); ?>
		<?php do_settings_fields( 'wpcs_custom_styling', 'wpcs_section' ); ?>
		<?php submit_button('Save'); ?>
	</form>
</div>
<?php }

function wpcs_create_options() {
	add_settings_section( 'wpcs_section', null, null, 'wpcs_custom_styling' );

	add_settings_field(
        'wpcs_styling', '', 'wpcs_render_settings_field', 'wpcs_custom_styling', 'wpcs_section',
		array(
			'title' => 'Custom CSS',
			'desc' => 'Custom CSS',
			'id' => 'wpcs_styling',
			'type' => 'textarea'
		)
    );
    register_setting('wpcs_custom_styling', 'wpcs_styling', 'wpcs_custom_styling_validation');
}
add_action('admin_init', 'wpcs_create_options');

function wpcs_custom_styling_validation($input){
	return $input;
}

function wpcs_render_settings_field($args){
	$option_value = get_option($args['id']);
?>
	<textarea id="<?=$args['id']?>" name="<?=$args['id']?>"><?php echo isset($option_value)?stripslashes(esc_textarea($option_value) ):''; ?></textarea>
<?php
}

?>