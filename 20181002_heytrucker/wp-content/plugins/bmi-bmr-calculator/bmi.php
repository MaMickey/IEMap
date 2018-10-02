<?php
/**
 * Plugin Name: BMI BMR calculator
 * Plugin URI: http://wordpress.org/plugins/bmi-bmr-calculator/
 * Description: Body Mass Index and Basal Metabolic Rate calculator that saves calculation data for logged in users.
 * Version: 1.3
 * Author: Robert Paleka
 * License: GPL2
 */
//The css and the js will be loaded only on the page where shortcode is used - start
add_action('init', 'bmibmr_register');
add_action('wp_footer', 'bmibmr_append_scripts');

function bmibmr_register() {
    wp_register_script('bmibmr_script', plugins_url() . '/bmi-bmr-calculator/fitness_body_calculator.js');
    wp_register_script('modernizr', plugins_url() . '/bmi-bmr-calculator/includes/js/modernizr.js');
    wp_register_script('bootstrapjs', plugins_url() . '/bmi-bmr-calculator/assets/bootstrap/js/bootstrap.js');

    wp_register_style('bmibmr_style', plugins_url('style_bmi.css', __FILE__));
    wp_register_style('typicons', plugins_url('assets/icons/typicons.min.css', __FILE__));
    wp_register_style('bootstrapcss', plugins_url('assets/bootstrap/css/bootstrap.css', __FILE__));
}

function bmibmr_append_scripts() {
    global $add_my_script;

    if (!$add_my_script)
        return;

    wp_print_scripts('modernizr');
    wp_print_scripts('bootstrapjs');
    wp_enqueue_style('bmibmr_style');
    wp_enqueue_style('typicons');
    wp_enqueue_style('bootstrapcss');
    wp_print_scripts('bmibmr_script');
}

add_shortcode('bmibmr', 'bmibmr_init');

function bmibmr_init($atts) {
    global $add_my_script;
    $add_my_script = true;
    include('bmi_calc.php');
}

//The css and the js will be loaded only on the page where shortcode is used - end
//Admin settings
function bmibmr_register_settings() {
    add_option('bmibmr_use_api', '1');
    add_option('bmibmr_api_callback', 'alpha');
    register_setting('default', 'bmibmr_use_api');
    register_setting('default', 'bmibmr_api_callback');
}

add_action('admin_init', 'bmibmr_register_settings');

function bmibmr_register_options_page() {
    add_options_page('Bmi Bmr Calculator', 'Bmi Bmr Calculator', 'manage_options', 'wphub-options', 'bmibmr_options_page');
}

add_action('admin_menu', 'bmibmr_register_options_page');

function bmibmr_options_page() {
    ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2>Bmi Bmr Calculator</h2>
        <h3>Details and information</h3>
        <p>The <i>css</i> and the <i>js</i> will be loaded only on the page/post where shortcode is used.</p>
        <p>Use <code>[bmibmr]</code> shortcode on post or page to display BMI and BMR forms.</p>
        <p>After registration users can save their calculations for later review!</p>
        <br>
        <small>*All the results calculated with this plugin are approximate based on user entered data. If you want real and accurate data that will help you get the results you want, contact Maria on <a href="mailto:mariatresoglavic@gmail.com">mariatresoglavic@gmail.com</a>.</small><hr>
        <footer>
            For technical questions about plugin contact  <a href="mailto:paleka@gmail.com">paleka@gmail.com</a>
        </footer>
    </div>
<?php
}

//Admin settings
?><?php

//db table installation ** start
function bmibmr_create_db_table() {

    global $wpdb;
    $bmibmr_tablename = $wpdb->prefix . "bmibmr";

    $bmibmr_sql = "CREATE TABLE IF NOT EXISTS $bmibmr_tablename (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `userid` int(11) NOT NULL,
				  `formdata` text NOT NULL,
				  `timeof` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				  PRIMARY KEY (`id`)
				)";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($bmibmr_sql);
}

/* run the table creation function only on plugin activation */
register_activation_hook(__FILE__, 'bmibmr_create_db_table');
//db table installation ** end
//@todo Delete table on deactivation of plugin
//db
register_activation_hook(__FILE__, 'get_saved_bmibmr');

function get_saved_bmibmr($iduser = null) {
    global $wpdb;

    if ( isset($iduser))  {
        $userid = $iduser;
    }
    else {
        $userid = get_current_user_id();
    }

    $table_name = $wpdb->prefix . 'bmibmr';


    $savedRows = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE userid = %d order by id desc', $userid));

    return $savedRows;
    //print_r($savedRows);
}

function bmibmr_front_calc() {
    if (isset($_REQUEST)) {

        //$calcFront = $_REQUEST['calcFrontData'];

        print_r($_POST);
        // $dbCalc = json_encode($holdData);
        //print_r($dbCalc);
        //echo $dbCalc;
    }
    die();
}

add_action('wp_ajax_bmibmr_front_calc', 'bmibmr_front_calc');

function bmibmr_save() {
    if (isset($_REQUEST)) {

        $holdData = $_REQUEST['holdData'];

        //print_r ($holdData);
        $dbCalc = json_encode($holdData);
        // print_r($_REQUEST);
        //echo $dbCalc;

        global $wpdb;
        $userid = get_current_user_id();

        $wpdb->insert($wpdb->prefix . 'bmibmr', array(
                'userid' => $userid,
                'formdata' => $dbCalc,
            ), array(
                '%d',
                '%s'
            )
        );
    }
    die();
}

add_action('wp_ajax_bmibmr_save', 'bmibmr_save');

add_action('wp_head', 'bmibmr_custom_head');

function bmibmr_custom_head() {
    echo '<script type="text/javascript">var ajaxurl = \'' . admin_url('admin-ajax.php') . '\';</script>';
}

//todo
//create join with custom table for users data from wp_bmibmr_users
function get_bmibmr_users( $id = '' ) {

    global $wpdb, $blog_id;
    $userid = get_current_user_id();//get all the users except the current one logged in
    if ( empty($id) )
        $id = (int) $blog_id;
    $blog_prefix = $wpdb->get_blog_prefix($id);
    $users = $wpdb->get_results( "SELECT user_id, user_id AS ID, user_login, display_name, user_email, meta_value FROM $wpdb->users, $wpdb->usermeta WHERE {$wpdb->users}.ID = {$wpdb->usermeta}.user_id AND {$wpdb->usermeta}.user_id != ".$userid." AND meta_key = '{$blog_prefix}capabilities' ORDER BY {$wpdb->usermeta}.user_id" );
    return $users;
}
?>