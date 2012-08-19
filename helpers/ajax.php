<?php

class SatelliteAjaxHelper extends SatellitePlugin {

    function __construct() {

        add_action('wp_head', array( $this,'my_action_javascript'));
        add_action( 'wp_head', array( $this, 'display_ajaxurl'), 9 );
        add_action('wp_ajax_my_action', array( $this, 'my_action_callback'));
        add_action('wp_ajax_nopriv_my_action', array( $this, 'my_action_callback'));        

    }
    
    function display_ajaxurl() {
        ?>
        <script type="text/javascript">
        var ajaxurl = '<?php echo(admin_url( 'admin-ajax.php' ));?>';
        </script>
        <?php
    }
    /**
     * For displaying multiple galleries and handling the AJAX calls from their clicks
     */
    function my_action_javascript() {
        ?>

        <script type="text/javascript">
            function showSatellite(id) {
                var data = {
                        action: 'my_action',
                        slideshow: id
                };
                jQuery.post(ajaxurl, data, function(response) {
                        //alert('Got this from the server: ' + response);
                        jQuery('.galleries-satl-wrap').html(response);
                });        
            }
        </script>
        <?php 
    }    
    
    function my_action_callback() {
    	global $wpdb; // this is how you get access to the database

	$slideshow = intval( $_POST['slideshow'] );

	$Satellite = new Satellite();
        $slides = $Satellite -> Slide -> find_all(array('section'=>(int) stripslashes($slideshow)), null, array('order', "ASC"));
        $displayAjaxSatellite = $Satellite -> render('default', array('slides' => $slides, 'frompost' => false), false, 'orbit');
        echo $displayAjaxSatellite;

	die(); // this is required to return a proper result
    }
    
}
?>
