<?php
/*
Plugin Name: Minimal Analytics
Plugin URL:  https://www.javiercasares.com/minimal-analytics/
Description: A simple Google Analytics snippet (based on David Kuennen minimal-analytics-snippet.js version 2018-12-16 16:49).
Tags: google analytics, gtagjs, minimal analytics, wpo
Version: 1.0.2
Requires at least: 4.0
Tested up to: 5.0.2
Stable tag: trunk
Author: Javier Casares
Author URI: https://www.javiercasares.com/
License: EUPL 1.2
License URI: https://eupl.eu/1.2/en/
Text Domain: minimal-analytics
*/
defined('ABSPATH') or die('Bye bye!');
if ( !class_exists('minimal_analytics_snippet') )
{
  class minimal_analytics_snippet
  {
    function minimal_analytics_snippet()
    {
      // nothing to do here!
    }
    function minimal_analytics_snippet_code_show()
    {
      global $post;
      if( !is_404() )
      {
				$ok = false;
				$masjs_ua = null;
				$masjs_ua = get_option( 'masjs_ua' );
				$masjs_anonymizeIp = 'true';
				switch(get_option( 'masjs_anonymizeIp' )) {
					case 0:
						$masjs_anonymizeIp = 'false';
						break;
					case 1:
					default: 
						$masjs_anonymizeIp = 'true';
						break;
				}
				$masjs_colorDepth = 'true';
				switch(get_option( 'masjs_colorDepth' )) {
					case 0:
						$masjs_colorDepth = 'false';
						break;
					case 1:
					default: 
						$masjs_colorDepth = 'true';
						break;
				}
				$masjs_characterSet = 'true';
				switch(get_option( 'masjs_characterSet' )) {
					case 0:
						$masjs_characterSet = 'false';
						break;
					case 1:
					default: 
						$masjs_characterSet = 'true';
						break;
				}
				$masjs_screenSize = 'true';
				switch(get_option( 'masjs_screenSize' )) {
					case 0:
						$masjs_screenSize = 'false';
						break;
					case 1:
					default: 
						$masjs_screenSize = 'true';
						break;
				}
				$masjs_language = 'true';
				switch(get_option( 'masjs_language' )) {
					case 0:
						$masjs_language = 'false';
						break;
					case 1:
					default: 
						$masjs_language = 'true';
						break;
				}
				if($masjs_ua)
				{
					$ok = true;
				}
        if ( $ok )
        {
?>
<script>
(function (context, trackingId, options) {
	const history = context.history;
	const doc = document;
	const nav = navigator || {};
	const storage = localStorage;
	const encode = encodeURIComponent;
	const pushState = history.pushState;
	const typeException = 'exception';
	const generateId = () => Math.random().toString(36);
	const getId = () => {
		if (!storage.cid) {
			storage.cid = generateId()
		}
		return storage.cid;
	};
	const serialize = (obj) => {
		var str = [];
		for (var p in obj) {
			if (obj.hasOwnProperty(p)) {
				if(obj[p] !== undefined) {
					str.push(encode(p) + "=" + encode(obj[p]));
				}
			}
		}
		return str.join("&");
	};
	const track = (
		type, 
		eventCategory, 
		eventAction, 
		eventLabel, 
		eventValue, 
		exceptionDescription, 
		exceptionFatal
	) => {
		const url = 'https://www.google-analytics.com/collect';
		const data = serialize({
			v: '1',
			ds: 'web',
			aip: options.anonymizeIp ? 1 : undefined,
			tid: trackingId,
			cid: getId(),
			t: type || 'pageview',
			sd: options.colorDepth && screen.colorDepth ? `${screen.colorDepth}-bits` : undefined,
			dr: doc.referrer || undefined,
			dt: doc.title,
			dl: doc.location.origin + doc.location.pathname + doc.location.search,
			ul: options.language ? (nav.language || "").toLowerCase() : undefined,
			de: options.characterSet ? doc.characterSet : undefined,
			sr: options.screenSize ? `${(context.screen || {}).width}x${(context.screen || {}).height}` : undefined,
			vp: options.screenSize && context.visualViewport ? `${(context.visualViewport || {}).width}x${(context.visualViewport || {}).height}` : undefined,
			ec: eventCategory || undefined,
			ea: eventAction || undefined,
			el: eventLabel || undefined,
			ev: eventValue || undefined,
			exd: exceptionDescription || undefined,
			exf: typeof exceptionFatal !== 'undefined' && !!exceptionFatal === false ? 0 : undefined,
		});
		if(nav.sendBeacon) {
			nav.sendBeacon(url, data)
		} else {
			var xhr = new XMLHttpRequest();
			xhr.open("POST", url, true);
			xhr.send(data);
		}
	};
	const trackEvent = (category, action, label, value) => track('event', category, action, label, value);
	const trackException = (description, fatal) => track(typeException, null, null, null, null, description, fatal);
	history.pushState = function (state) {
		if (typeof history.onpushstate == 'function') {
			history.onpushstate({ state: state });
		}
		setTimeout(track, options.delay || 10);
		return pushState.apply(history, arguments);
	}
	track();
	context.ma = {
		trackEvent,
		trackException
	}
})(window, '<?php echo wp_kses($masjs_ua, array(), array()); ?>', {
	anonymizeIp: <?php echo $masjs_anonymizeIp; ?>,
	colorDepth: <?php echo $masjs_colorDepth; ?>,
	characterSet: <?php echo $masjs_characterSet; ?>,
	screenSize: <?php echo $masjs_screenSize; ?>,
	language: <?php echo $masjs_language; ?>
});
</script>
<?php
					unset($ok, $masjs_ua, $masjs_anonymizeIp, $masjs_colorDepth, $masjs_characterSet, $masjs_screenSize, $masjs_language);
				}
			}
		}
	}
	$minimal_analytics_snippet_meta = new minimal_analytics_snippet();
	if (isset($minimal_analytics_snippet_meta))
  {
		add_action( 'wp_head', array(&$minimal_analytics_snippet_meta, 'minimal_analytics_snippet_code_show' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'minimal_analytics_snippet_settings_link' );
		add_action( 'admin_init', 'minimal_analytics_snippet_register_meta' );
		add_action( 'admin_menu', 'minimal_analytics_snippet_register_menu');
		function minimal_analytics_snippet_register_menu()
    {
      add_options_page(__('Google Analytics', 'minimal-analytics'), __('Minimal Analytics', 'minimal-analytics'), 'manage_options', 'minimal_analytics_snippet', 'minimal_analytics_snippet_admin');	
		}
	}
	function minimal_analytics_snippet_settings_link( $links )
	{
		$links[] = '<a href="' . get_admin_url( null, 'options-general.php?page=minimal_analytics_snippet' ) . '">' . _('Settings') . '</a>';
		return $links;
	}
	function minimal_analytics_snippet_register_meta()
	{
    register_setting( 'masjs', 'masjs_ua', array('type' => 'string', 'default' => null) );
    register_setting( 'masjs', 'masjs_anonymizeIp', array('type' => 'integer', 'default' => 1) );
    register_setting( 'masjs', 'masjs_colorDepth', array('type' => 'integer', 'default' => 1) );
    register_setting( 'masjs', 'masjs_characterSet', array('type' => 'integer', 'default' => 1) );
    register_setting( 'masjs', 'masjs_screenSize', array('type' => 'integer', 'default' => 1) );
    register_setting( 'masjs', 'masjs_language', array('type' => 'integer', 'default' => 1) );
	}
	function minimal_analytics_snippet_admin()
	{
?>
		<div class="wrap">
      <h2><?php _e('Minimal Analytics Snippet', 'minimal-analytics'); ?></h2>
      <p><?php _e('Insert your UA-XXXXXX-NN code here and set the Google Analytics options.', 'minimal-analytics'); ?></p>
      <form method="post" action="options.php">
<?php
  settings_fields( 'masjs' );
	$masjs_ua = null;
	$masjs_ua = wp_kses( get_option( 'masjs_ua' ), array(), array() );
	$masjs_anonymizeIp = 1;
	switch(get_option( 'masjs_anonymizeIp' )) {
		case 0:
			$masjs_anonymizeIp = 0;
			break;
		case 1:
		default: 
			$masjs_anonymizeIp = 1;
			break;
	}
	$masjs_colorDepth = 1;
	switch(get_option( 'masjs_colorDepth' )) {
		case 0:
			$masjs_colorDepth = 0;
			break;
		case 1:
		default: 
			$masjs_colorDepth = 1;
			break;
	}
	$masjs_characterSet = 1;
	switch(get_option( 'masjs_characterSet' )) {
		case 0:
			$masjs_characterSet = 0;
			break;
		case 1:
		default: 
			$masjs_characterSet = 1;
			break;
	}
	$masjs_screenSize = 1;
	switch(get_option( 'masjs_screenSize' )) {
		case 0:
			$masjs_screenSize = 0;
			break;
		case 1:
		default: 
			$masjs_screenSize = 1;
			break;
	}
	$masjs_language = 1;
	switch(get_option( 'masjs_language' )) {
		case 0:
			$masjs_language = 0;
			break;
		case 1:
		default: 
			$masjs_language = 1;
			break;
	}
?>
        <table class="form-table">
          <tr valign="top">
            <th scope="row"><?php _e('Google Analytics UA', 'minimal-analytics'); ?></th>
            <td scope="row"><input type="text" name="masjs_ua" placeholder="UA-XXXXXX-NN" value="<?php echo $masjs_ua; ?>"></td>
          </tr>
          <tr valign="top">
            <th scope="row"><?php _e('Send: Anonymized IP', 'minimal-analytics'); ?></th>
            <td scope="row"><input type="radio" name="masjs_anonymizeIp" value="1" <?php if($masjs_anonymizeIp) echo 'checked'; ?>> <?php _e('Yes'); ?> <input type="radio" name="masjs_anonymizeIp" value="0" <?php if(!$masjs_anonymizeIp) echo 'checked'; ?>> <?php _e('No'); ?></td>
          </tr>
          <tr valign="top">
            <th scope="row"><?php _e('Send: Color Depth', 'minimal-analytics'); ?></th>
            <td scope="row"><input type="radio" name="masjs_colorDepth" value="1" <?php if($masjs_colorDepth) echo 'checked'; ?>> <?php _e('Yes'); ?> <input type="radio" name="masjs_colorDepth" value="0" <?php if(!$masjs_colorDepth) echo 'checked'; ?>> <?php _e('No'); ?></td>
          </tr>
          <tr valign="top">
            <th scope="row"><?php _e('Send: Character Set', 'minimal-analytics'); ?></th>
            <td scope="row"><input type="radio" name="masjs_characterSet" value="1" <?php if($masjs_characterSet) echo 'checked'; ?>> <?php _e('Yes'); ?> <input type="radio" name="masjs_characterSet" value="0" <?php if(!$masjs_characterSet) echo 'checked'; ?>> <?php _e('No'); ?></td>
          </tr>
          <tr valign="top">
            <th scope="row"><?php _e('Send: Screen Size', 'minimal-analytics'); ?></th>
            <td scope="row"><input type="radio" name="masjs_screenSize" value="1" <?php if($masjs_screenSize) echo 'checked'; ?>> <?php _e('Yes'); ?> <input type="radio" name="masjs_screenSize" value="0" <?php if(!$masjs_screenSize) echo 'checked'; ?>> <?php _e('No'); ?></td>
          </tr>
          <tr valign="top">
            <th scope="row"><?php _e('Send: Language', 'minimal-analytics'); ?></th>
            <td scope="row"><input type="radio" name="masjs_language" value="1" <?php if($masjs_language) echo 'checked'; ?>> <?php _e('Yes'); ?> <input type="radio" name="masjs_language" value="0" <?php if(!$masjs_language) echo 'checked'; ?>> <?php _e('No'); ?></td>
          </tr>
        </table>
        <p class="submit">
          <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
      </form>
		</div>
<?php
		unset($masjs_ua, $masjs_anonymizeIp, $masjs_colorDepth, $masjs_characterSet, $masjs_screenSize, $masjs_language);
  }
}
