/**
 * WordPress dependencies
 */

import {
	pressKeyTimes,
	activatePlugin,
	visitAdminPage,
	setBrowserViewport,
	deactivatePlugin,
} from '@wordpress/e2e-test-utils';

// eslint-disable-next-line no-unused-vars
async function setupBrowser() {
	// await setBrowserViewport( 'large' );
}

describe( 'Checking basic plugin actions', () => {
	beforeAll( async() => {
		await deactivatePlugin( 'live-composer-page-builder' );
		await setBrowserViewport( 'large' );
	} );

	it( 'Plugin is listed among other plugins (not active)', async() => {
		await visitAdminPage( 'plugins.php' );
		await page.waitForSelector( '[data-plugin="live-composer-page-builder/ds-live-composer.php"]' );
		expect( await page.$( '[data-plugin="live-composer-page-builder/ds-live-composer.php"] .activate' ) ).not.toBeNull();
	} );

	it( 'Plugin activates via WP admin panel', async() => {
		activatePlugin( 'live-composer-page-builder' ); // Don't use await here!
		// Plugin on-activation redirect breaks activatePlugin command.
		await page.waitForSelector( '#dslc-main-title', { timeout: 8000 } );
	} );

	it( '"WooCommerce" Tab Working', async() => {
		// Check WooCommerce tab.
		await page.click('[data-nav-to="tab-woo"]' );
		expect( await page.evaluate(() => window.find("WooCommerce Integration")) ).not.toBeNull();
	} );

	it( '"Docs & Support" Tab Working', async() => {
		// Check Docs & Support tab.
		await page.click('[data-nav-to="tab-docs"]' );
		expect( await page.evaluate(() => window.find("Documentation & Support")) ).not.toBeNull();
	} );

	it( '"Settings" Tab Working', async() => {
		// Check Settings tab.
		await page.click('[data-nav-to="tab-settings"]' );
		expect( await page.evaluate(() => window.find("General Options")) ).not.toBeNull();
	} );
} );
