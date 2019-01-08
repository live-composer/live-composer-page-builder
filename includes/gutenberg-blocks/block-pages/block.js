/** 
 * Live Composer Blocks for Gutenberg
 */

import apiFetch from '@wordpress/api-fetch';
import { Spinner, SelectControl } from '@wordpress/components';
//import { SelectControl } from '@wordpress/components';
//const { SelectControl } = wp.components;
//import { withState } from '@wordpress/compose';

// Required components
const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;
const { withSelect, registerStore } = wp.data;

const actions = {
	setLcPages( lcPages ) {
		return {
			type: 'SET_LC_PAGES',
			lcPages,
		};
	},
	receiveLcPages( path ) {
		return {
			type: 'RECEIVE_LC_PAGES',
			path,
		};
	},
};

const store = registerStore( 'livecomposer-gutenberg-blocks/block-pages', {
	reducer( state = { lcPages: {} }, action ) {

		switch ( action.type ) {
			case 'SET_LC_PAGES':
				return {
					...state,
					lcPages: action.lcPages,
				};
		}

		return state;
	},

	actions,

	selectors: {
		receiveLcPages( state ) {
			const { lcPages } = state;
			return lcPages;
		},
	},

	controls: {
		RECEIVE_LC_PAGES( action ) {
			return apiFetch( { path: action.path } );
		},
	},

	resolvers: {
		* receiveLcPages( state ) {
			const lcPages = yield actions.receiveLcPages( '/wp-json/livecomposer-gutenberg-blocks/block-pages/v1/get-all-lc-pages' );
			return actions.setLcPages( lcPages );
		},
	},
} );

/**
 * Registers and creates block
 * 
 * @param {string} Name Name of the block with a required name space
 * @param {object} ObjectArgs Block configuration {
 *      title - Title, displayed in the editor
 *      icon - Icon, from WP icons
 *      category - Block category, where the block will be added in the editor
 *      attributes - Object with all binding elements between the view HTML and the functions 
 *      edit function - Returns the markup for the editor interface.
 *      save function - Returns the markup that will be rendered on the site page
 * }
 */
registerBlockType(
    'livecomposer-gutenberg-blocks/block-pages', // Name of the block with a required name space
    {
	    title: __('Live Composer Pages'), // Title, displayed in the editor
	    icon: 'admin-page', // Icon, from WP icons
			category: 'common', // Block category, where the block will be added in the editor

			attributes: {
				selectedPage: {
					type: 'int',
					default: 0,
				},
			},

			edit: withSelect( ( select ) => {
				return {
					lcPages: select('livecomposer-gutenberg-blocks/block-pages').receiveLcPages(),
				};
			} )( props => {

				const { lcPages, className, setAttributes } = props;

				const handlePageChange = ( page ) => {
					setAttributes( { selectedPage: page } );
				}

				// convert lc pages object to array
				let pages = Object.keys(lcPages).map(id => ({ label: lcPages[id], value: id }));

				if ( ! pages.length ) {
					return (
						<p className={className} >
							<Spinner />
							{ __( 'Loading...', 'lc-block-pages' ) }
						</p>
					);
				}

				if ( pages && pages.length === 0 ) {
					return "No pages";
				}

				return (
					<SelectControl
							label="LC Page"
							value={ props.attributes.selectedPage }
							options={ pages }
							onChange={ handlePageChange }
					/>
				)
		} ),



			/**
			 * save function
			 * 
			 * Makes the markup that will be rendered on the site page
			 * 
			 * In this case, it does not render, because this block is rendered on server side
			 * 
			 * @param object props Let's you bind markup and attributes as well as other controls
			 * @return JSX ECMAScript Markup for the site
			 */
			save ( props ) {
					return null // See PHP side. This block is rendered on PHP.
			},
        
    } 
);