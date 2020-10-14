<?php
if ( defined( 'ABSPATH' ) && defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	delete_option( 'masjs_ua' );
	delete_option( 'masjs_anonymizeIp' );
	delete_option( 'masjs_colorDepth' );
	delete_option( 'masjs_characterSet' );
	delete_option( 'masjs_screenSize' );
	delete_option( 'masjs_language' );
}
