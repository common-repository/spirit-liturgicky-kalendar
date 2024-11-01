<?php
/*
 * Everything related to Wordpress administration.
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if (is_admin()) {
    add_action('init', 'tsslk_admin_init');
    add_action( 'admin_init', 'tsslk_register_settings' );
    add_action( 'admin_enqueue_scripts', 'tsslk_admin_enqueue_styles' ); //Register styles for Admin
    add_action( 'admin_enqueue_scripts', 'tsslk_admin_enqueue_scripts' ); //Register scripts for Admin
}

function tsslk_admin_init() {

    add_action( 'admin_menu', 'tsslk_admin_menu' );
}

/*
* Enqueue admin styles
*/
function tsslk_admin_enqueue_styles() {

    wp_enqueue_style('Spirit Liturgický kalendár', plugin_dir_url( __FILE__ ) . '../css/spirit-lit-kalendar-admin.css', array(), SPIRIT_LIT_KAL_VERSION, 'all' );
    wp_enqueue_style( 'wp-color-picker' );
}

/*
* Enqueue admin scripts
*/
function tsslk_admin_enqueue_scripts() {

    wp_enqueue_script('Spirit Liturgický kalendár', plugin_dir_url( __FILE__ ) . '../js/spirit-lit-kalendar-admin.js', array('jquery', 'wp-color-picker'), SPIRIT_LIT_KAL_VERSION, 'all' );
}


/*
* Register settings
*/
function tsslk_register_settings() {
	register_setting( 'tsslk_settings_group','tsslk_options', 'tsslk_sanitize_options');
}

/*
* Sanitize settings before saving
*/
function tsslk_sanitize_options( $options ) {    
    $options['ShowButton'] = ( ! empty( $options['ShowButton'] ) ) ?absint( $options['ShowButton'] ) : '';
    $options['ShowIconInButton'] = ( ! empty( $options['ShowIconInButton'] ) ) ?absint( $options['ShowIconInButton'] ) : '';
    $options['CustomCSS'] = ( ! empty( $options['CustomCSS'] ) ) ?absint( $options['CustomCSS'] ) : '';   
    $options['ButtonColor'] = ( ! empty( $options['ButtonColor'] ) ) ?sanitize_text_field( $options['ButtonColor'] ) : '';
    $options['ButtonHoverColor'] = ( ! empty( $options['ButtonHoverColor'] ) ) ?sanitize_text_field( $options['ButtonHoverColor'] ) : '';
    $options['VerseFontFamily'] = ( ! empty( $options['VerseFontFamily'] ) ) ?sanitize_text_field( $options['VerseFontFamily'] ) : '';
    $options['VerseFontWeight'] = ( ! empty( $options['VerseFontWeight'] ) ) ?sanitize_text_field( $options['VerseFontWeight'] ) : '';
    $options['VerseFontItalic'] = ( ! empty( $options['VerseFontItalic'] ) ) ?sanitize_text_field( $options['VerseFontItalic'] ) : '';
    $options['VerseFontSize'] = ( ! empty( $options['VerseFontSize'] ) ) ?sanitize_text_field( $options['VerseFontSize'] ) : '';

return $options;
}

//Register menu under Settings
function tsslk_admin_menu() { 
    add_options_page( __( 'Spirit Liturgický kalendár',
        'spirit-lit-kalendar' ), __( 'Spirit Liturgický kalendár',
        'spirit-lit-kalendar' ), 'manage_options', 'spirit-lit-kalendar',
        'tsslk_settings_page');
}

//Settings Page UI
function tsslk_settings_page() { 
    global $tsslk_options;
    
    $tsslk_options= get_option( 'tsslk_options');    
?>

<div class="wrap columns-2 dd-wrap">
	<div style="margin-bottom: 20px;">
		<h1><?php _e('Nastavenia', 'spirit-lit-kalendar'); ?></h1>
	</div>		
    
    <div id="poststuff" class="metabox-holder has-right-sidebar">
        <div id="post-body">
            <div id="post-body-content">
				<form method="post" action="options.php">	
					<?php settings_fields( 'tsslk_settings_group' ); ?>
					<div class="postbox">
						<h3 class="hndle"><?php _e( 'UI Nastavenia', 'spirit-lit-kalendar' ); ?></h3>
						<div class="inside">
                            <table class="form-table" style="max-width:500px;">
                                <tr valign="top">
									<!-- Show button to lc.kbs.sk -->
									<th><label for="tsslk_options[ShowButton]"><?php _e('Zobraziť tlačidlo', 'spirit-lit-kalendar'); ?>:</label></th>
									<td>
                                       <input type="checkbox" id="tsslk_options_ShowButton" name="tsslk_options[ShowButton]" value="1" <?php checked( 1,$tsslk_options['ShowButton']); ?>>
                                    </td>
                                </tr>
                            </table>
                            <div class="tsslk_button_block">
                                <table class="form-table" style="max-width:500px;">
                                    <tr valign="top">
                                        <!-- Show icon button to lc.kbs.sk -->
                                        <th><label for="tsslk_options[ShowIconInButton]"><?php _e('Zobraziť ikonku v tlačidle', 'spirit-lit-kalendar'); ?>:</label></th>
                                        <td>
                                        <input type="checkbox" id="tsslk_options_ShowIconInButton" name="tsslk_options[ShowIconInButton]" value="1" <?php checked( 1,$tsslk_options['ShowIconInButton']); ?>>
                                        </td>
                                    </tr>
                                </table>
                                <table class="form-table" style="max-width:500px;">
                                    <tr valign="top">
                                        <!-- Show apply custom CSS styles -->
                                        <th><label for="tsslk_options[CustomCSS]"><?php _e('Prispôsobiť CSS štýly', 'spirit-lit-kalendar'); ?>:</label></th>
                                        <td>
                                        <input type="checkbox" id="tsslk_options_CustomCSS" name="tsslk_options[CustomCSS]" value="1" <?php checked( 1,$tsslk_options['CustomCSS']); ?>>
                                        </td>
                                    </tr>
                                </table>    
                                <div class="tsslk_CustomCSS_block">                           
                                    <table class="form-table" style="max-width:500px;">                           
                                        <tr valign="top">
                                            <!-- Button -->
                                            <th><label for="tsslk_options[ButtonColor]"><?php _e('Tlačidlo', 'spirit-lit-kalendar'); ?>:</label></th>
                                            <td><input type="text" name="tsslk_options[ButtonColor]" value="<?php echo $tsslk_options['ButtonColor']; ?>" size="64" class="regular-text code tsslk-color-picker"></td>
                                        </tr>
                                        <tr valign="top">	
                                            <!-- Button hover -->
                                            <th><label for="tsslk_options[ButtonHoverColor]"><?php _e('Tlačidlo hover', 'spirit-lit-kalendar'); ?>:</label></th>
                                            <td><input type="text" name="tsslk_options[ButtonHoverColor]" value="<?php echo $tsslk_options['ButtonHoverColor']; ?>" size="64" class="regular-text code tsslk-color-picker"></td>
                                        </tr>                       
                                    </table> 	
                                </div>
                            </div>			
                            <table class="form-table" style="max-width:800px;">                           
                                    <tr valign="top">
                                        <!-- Font settins -->
                                        <th><label for="tsslk_options[VerseFont]"><?php _e('Verš', 'spirit-lit-kalendar'); ?>:</label></th>
                                        <td>
                                            <select name="tsslk_options[VerseFontFamily]">
                                            <?php
                                                foreach( tsslk_get_standard_fonts() as $standard_font ) {
                                                    ?>
                                                        <option value="<?php echo $standard_font;?>" <?php if (isset($tsslk_options['VerseFontFamily'])) { echo ($standard_font == $tsslk_options['VerseFontFamily'] ? 'selected' : ''); } ?> ><?php echo $standard_font;?></option>
                                                    <?php
                                                }
                                            ?>
                                            </select>
                                            
                                            <!-- Font weight -->
                                            <div class="tsslk-font-button-div">
                                                <?php $selected = ($tsslk_options['VerseFontWeight'] == 1 ? 'selected' : ''); ?>

                                                <button type="button" aria-pressed="false" class="tsslk-font-button <?php echo $selected;?>" aria-label="Bold">
                                                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 24 24" role="img" aria-hidden="true" focusable="false">
                                                        <path d="M6 4v13h4.54c1.37 0 2.46-.33 3.26-1 .8-.66 1.2-1.58 1.2-2.77 0-.84-.17-1.51-.51-2.01s-.9-.85-1.67-1.03v-.09c.57-.1 1.02-.4 1.36-.9s.51-1.13.51-1.91c0-1.14-.39-1.98-1.17-2.5C12.75 4.26 11.5 4 9.78 4H6zm2.57 5.15V6.26h1.36c.73 0 1.27.11 1.61.32.34.22.51.58.51 1.07 0 .54-.16.92-.47 1.15s-.82.35-1.51.35h-1.5zm0 2.19h1.6c1.44 0 2.16.53 2.16 1.61 0 .6-.17 1.05-.51 1.34s-.86.43-1.57.43H8.57v-3.38z"></path>
                                                    </svg>
                                                </button>
                                                <input type="hidden" name="tsslk_options[VerseFontWeight]" value="<?php echo $tsslk_options['VerseFontWeight']; ?>">   
                                            </div>

                                            <!-- Font style -->
                                            <div class="tsslk-font-button-div">
                                                <?php $selected = ($tsslk_options['VerseFontItalic'] == 1 ? 'selected' : ''); ?>

                                                <button type="button" aria-pressed="false" class="tsslk-font-button <?php echo $selected;?>" aria-label="Italic">
                                                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 24 24" role="img" aria-hidden="true" focusable="false">
                                                        <path d="M14.78 6h-2.13l-2.8 9h2.12l-.62 2H4.6l.62-2h2.14l2.8-9H8.03l.62-2h6.75z"></path>
                                                    </svg>
                                                </button>
                                                <input type="hidden" name="tsslk_options[VerseFontItalic]" value="<?php echo $tsslk_options['VerseFontItalic']; ?>">   
                                            </div> 
                                            
                                            <!-- Font size -->
                                            <div class="tsslk-font-block">
                                                <input type="text" name="tsslk_options[VerseFontSize]" value="<?php echo $tsslk_options['VerseFontSize']; ?>" size="3" style="text-align: center;"> px
                                            </div>

                                        </td>
                                    </tr>                      
                            </table> 	                           
						</div>
					</div>					
					<p class="submit">
                        <input type="submit" class="button-primary" value="<?php _e( 'Uložiť', 'spirit-lit-kalendar' ); ?>" />
                    </p>
				</form>
			</div>                
        </div>
    </div>
</div>

<?php    
}

