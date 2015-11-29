<?php

/*------------------------------------*\
    Contexts
\*------------------------------------*/

// shortcuts
define('THEMELIB', get_template_directory() . '/parts');
define('BACK', THEMELIB ); //. '/back-end/');

function is_localhost(){
    $whitelist = array('127.0.0.1','::1','localhost:8888','localhost');
    return in_array($_SERVER['REMOTE_ADDR'], $whitelist) || in_array($_SERVER['HTTP_HOST'], $whitelist); 
}

/*------------------------------------*\
    Redirects 
\*------------------------------------*/

if(!is_user_logged_in()){ // redirect all non-logged-in users
	wp_redirect('/', 301);
}

/*------------------------------------*\
    Images
\*------------------------------------*/

// recommended plugins for image management: 
// ewww image optimizer (compression), imagemagick engine (sharpness), force regenerate thumbnails (regenerates and deletes older files)

// theme support
//add_theme_support('post-thumbnails');

// image sizes
//add_image_size('xl', 1800, '', true); // XL Thumbnail
//add_image_size('xxl', 2400, '', true); // XL Thumbnail
// image quality
add_filter( 'jpeg_quality', create_function( '', 'return 100;' ) );


/*------------------------------------*\
    WP Admin Menu
\*------------------------------------*/

// Edit Admin Menu
add_action('admin_menu', 'edit_admin_menu', 999 );
function edit_admin_menu() {

	// homepage shortcut ?
	$homeID = 18;
    add_menu_page('Home','Home','edit_posts', 'post.php?post={$homeID}&action=edit','','dashicons-admin-home',10);

    // options.php shortcut ?
    // add_options_page('All Settings', 'All Settings', 'administrator', 'options.php');
    
    // remove menus
    remove_menu_page( 'edit-comments.php' ); // comments
    remove_menu_page( 'link-manager.php' ); // link manager
    	// Appearance
			// remove_menu_page( 'themes.php' ); // remove entire appearance menu altogether
    		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' ); // post tags
    		remove_submenu_page( 'themes.php', 'widgets.php' ); // widgets
    		remove_submenu_page( 'themes.php', 'nav_menu.php' ); // widgets
    		remove_submenu_page( 'themes.php', 'theme-editor.php' ); // theme editor
    		global $submenu; unset($submenu['themes.php'][6]); // customize
        
    // reposition media tab
    remove_menu_page('upload.php');
    add_menu_page('Media','Media','Contributor','upload.php','','dashicons-admin-media',23);
}


/*------------------------------------*\
    Customize WYSIWYG / Tiny MCE Editor
\*------------------------------------*/

// edit default wordpress tinymce wysiwyg editor
// buttons
//add_filter('mce_buttons','myplugin_tinymce_buttons'); // primary 
//add_filter('mce_buttons_2','myplugin_tinymce_buttons'); // secondary
function myplugin_tinymce_buttons($buttons)
 {
    $remove = array('outdent','indent','forecolor','alignleft','alignjustify','aligncenter','alignright','wp_more','underline');
    return array_diff($buttons,$remove);
 }
// format options
//add_filter('tiny_mce_before_init', 'mce_mod');
function mce_mod( $init ) {
    $init['block_formats'] = 'Paragraph=p;Header=h2;Sub-Header=h3;';
    return $init;
}

/*------------------------------------*\
    ACF - Advanced Custom Fields 
\*------------------------------------*/

// Recommending JSON plugins: 
// "WP REST API" (wp-api.org) with "ACF to WP API" plugin so they show up

// Load ACF fields from php file on remote/production
// 		– prevents end users from adjusting the fields 
// 		– using a php file also allows version control of acf fields :)
// if(!is_localhost()){ require_once(BACK . 'acf-custom-fields.php'); } // advanced custom fields

// WP Admin Menu
//add_action('admin_menu', 'acf_admin_menu', 999 );
function acf_admin_menu(){
	// Options Page
	// add:
    if( function_exists('acf_add_options_page') ) {
        acf_add_options_page('Theme Options');    
    }
    // set as submenu?
    //remove_menu_page('acf-options-theme-options');
	//add_theme_page('Theme Options','Theme Options','edit_theme_options','acf-options-theme-options');
}

// Tiny MCE Toolbars
// add_filter( 'acf/fields/wysiwyg/toolbars' , 'my_toolbars'  );
function my_toolbars( $toolbars )
{
    // Uncomment to view format of $toolbars
    /*
    echo '< pre >';
        print_r($toolbars);
    echo '< /pre >';
    die;
    */

    // Add a new toolbar called "Very Simple"
    // - this toolbar has only 1 row of buttons
    $toolbars['Minimal' ] = array();
    $toolbars['Minimal' ][1] = array('bold' , 'italic' , 'link', 'unlink','fullscreen','wp_adv');
    $toolbars['Minimal' ][2] = array('bullist','numlist','pastetext','removeformat','charmap','undo','redo','wp_more');

    // Edit the "Full" toolbar and remove 'code'
    // - delet from array code from http://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key
    if( ($key = array_search('code' , $toolbars['Full' ][2])) !== false )
    {
        unset( $toolbars['Full' ][2][$key] );
    }

    // remove the 'Basic' toolbar completely
    //unset( $toolbars['Basic' ] );

    // return $toolbars - IMPORTANT!
    return $toolbars;
}

/*------------------------------------*\
    Misc
\*------------------------------------*/

// Custom Admin Favicon
//add_action('admin_head', 'admin_favicon' );
function admin_favicon() {
	echo '<link rel="shortcut icon" type="image/x-icon" href="' . site_url() . '/path/to/favicon.png">';
}

//add_theme_support('title-tag');


?>