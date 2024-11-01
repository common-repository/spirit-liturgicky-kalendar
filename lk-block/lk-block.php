<?php
/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function spirit_lit_kalendar_lk_block_block_init() {
	$dir = dirname( __FILE__ );

	// Skip block registration if Gutenberg is not enabled.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	

	$script_asset_path = "$dir/build/index.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "spirit-lit-kalendar/lk-block" block first.'
		);
	}
	$index_js     = 'build/index.js';
	$script_asset = require( $script_asset_path );
	wp_register_script(
		'spirit-lit-kalendar-lk-block-block-editor',
		plugins_url( $index_js, __FILE__ ),
		$script_asset['dependencies'],
		$script_asset['version']
	);


	register_block_type( 'spirit-lit-kalendar/lk-block', array(
		'editor_script' => 'spirit-lit-kalendar-lk-block-block-editor',
		'render_callback'	=> 'tsslk_get_block_code_wrap'
		) 
	);
}

add_action( 'init', 'spirit_lit_kalendar_lk_block_block_init' );

function tsslk_get_block_code_wrap($attributes, $content) {
	ob_start();

	tsslk_get_block_code();

	return ob_get_clean();
}
