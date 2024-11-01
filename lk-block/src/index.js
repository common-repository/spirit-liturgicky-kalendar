import { registerBlockType } from '@wordpress/blocks';
import { Placeholder } from '@wordpress/components';
import { Dashicon } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

registerBlockType( 'spirit-lit-kalendar/lk-block', {
	title: __( 'Liturgický kalendár', 'spirit-lit-kalendar' ),
	description: __( 'Denne aktualizovaný verš z liturgického kalendára podľa lc.kbs.sk.', 'spirit-lit-kalendar' ),
	category: 'widgets',
	icon: 'book',
	supports: {	html: false,},

	/**
	 * @see ./edit.js
	 */
	edit:  function() {
		return (
				<Placeholder
					icon={ <Dashicon icon="book" /> }
					label={ __( 'Liturgický kalendár') }
				>
					{ __(
						'Denne aktualizovaný verš z liturgického kalendára.'
					) }
				</Placeholder>
		);
	},

	/**
	 * @see ./save.js
	 */
	save: function() {
		return null;
	},
} );
