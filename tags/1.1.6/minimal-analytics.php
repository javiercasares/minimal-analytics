<?php
/*
Plugin Name: Minimal Analytics
Plugin URI:  https://www.javiercasares.com/minimal-analytics/
Description: A simple Google Analytics snippet, based on David Kuennen Minimal Analytics (version 2018-12-16 16:49).
Version: 1.1.6
Requires at least: 4.9
Tested: 5.8
Requires PHP: 7.0
Tested PHP: 8.0
Author: Javier Casares
Author URI: https://www.javiercasares.com/
License: EUPL 1.2
License URI: https://eupl.eu/1.2/en/
Text Domain: minimal-analytics
*/
defined('ABSPATH') or die('Bye bye!');
function minimal_analytics_snippet_code_show()
{
	global $post;
	if( !is_404() )
	{
		$ok = false;
		$masjs_ua = null;
		$masjs_ua = get_option( 'masjs_ua' );
		$masjs_anonymizeIp = 'true';
		switch((int)get_option( 'masjs_anonymizeIp' )) {
			case 0:
				$masjs_anonymizeIp = 'false';
				break;
			case 1:
			default: 
				$masjs_anonymizeIp = 'true';
				break;
		}
		$masjs_colorDepth = 'true';
		switch((int)get_option( 'masjs_colorDepth' )) {
			case 0:
				$masjs_colorDepth = 'false';
				break;
			case 1:
			default: 
				$masjs_colorDepth = 'true';
				break;
		}
		$masjs_characterSet = 'true';
		switch((int)get_option( 'masjs_characterSet' )) {
			case 0:
				$masjs_characterSet = 'false';
				break;
			case 1:
			default: 
				$masjs_characterSet = 'true';
				break;
		}
		$masjs_screenSize = 'true';
		switch((int)get_option( 'masjs_screenSize' )) {
			case 0:
				$masjs_screenSize = 'false';
				break;
			case 1:
			default: 
				$masjs_screenSize = 'true';
				break;
		}
		$masjs_language = 'true';
		switch((int)get_option( 'masjs_language' )) {
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
<script>(function(a,b,c){var d=a.history,e=document,f=navigator||{},g=localStorage,h=encodeURIComponent,i=d.pushState,k=function(){return Math.random().toString(36)},l=function(){return g.cid||(g.cid=k()),g.cid},m=function(r){var s=[];for(var t in r)r.hasOwnProperty(t)&&void 0!==r[t]&&s.push(h(t)+"="+h(r[t]));return s.join("&")},n=function(r,s,t,u,v,w,x){var z="https://www.google-analytics.com/collect",A=m({v:"1",ds:"web",aip:c.anonymizeIp?1:void 0,tid:b,cid:l(),t:r||"pageview",sd:c.colorDepth&&screen.colorDepth?screen.colorDepth+"-bits":void 0,dr:e.referrer||void 0,dt:e.title,dl:e.location.origin+e.location.pathname+e.location.search,ul:c.language?(f.language||"").toLowerCase():void 0,de:c.characterSet?e.characterSet:void 0,sr:c.screenSize?(a.screen||{}).width+"x"+(a.screen||{}).height:void 0,vp:c.screenSize&&a.visualViewport?(a.visualViewport||{}).width+"x"+(a.visualViewport||{}).height:void 0,ec:s||void 0,ea:t||void 0,el:u||void 0,ev:v||void 0,exd:w||void 0,exf:"undefined"!=typeof x&&!1==!!x?0:void 0});if(f.sendBeacon)f.sendBeacon(z,A);else{var y=new XMLHttpRequest;y.open("POST",z,!0),y.send(A)}};d.pushState=function(r){return"function"==typeof d.onpushstate&&d.onpushstate({state:r}),setTimeout(n,c.delay||10),i.apply(d,arguments)},n(),a.ma={trackEvent:function o(r,s,t,u){return n("event",r,s,t,u)},trackException:function q(r,s){return n("exception",null,null,null,null,r,s)}}})(window,"<?php echo wp_kses($masjs_ua, array(), array()); ?>",{anonymizeIp:<?php echo $masjs_anonymizeIp; ?>,colorDepth:<?php echo $masjs_colorDepth; ?>,characterSet:<?php echo $masjs_characterSet; ?>,screenSize:<?php echo $masjs_screenSize; ?>,language:<?php echo $masjs_language; ?>});</script>
<?php
			unset($ok, $masjs_ua, $masjs_anonymizeIp, $masjs_colorDepth, $masjs_characterSet, $masjs_screenSize, $masjs_language);
		}
	}
}
add_action( 'wp_head', 'minimal_analytics_snippet_code_show' );
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'minimal_analytics_snippet_settings_link' );
add_action( 'admin_init', 'minimal_analytics_snippet_register_meta' );
add_action( 'admin_menu', 'minimal_analytics_snippet_register_menu');
function minimal_analytics_snippet_register_menu()
{
	add_options_page(__('Google Analytics', 'minimal-analytics'), __('Minimal Analytics', 'minimal-analytics'), 'manage_options', 'minimal_analytics_snippet', 'minimal_analytics_snippet_admin');	
}
add_action( 'plugins_loaded', 'minimal_analytics_snippet_textdomain' );	
function minimal_analytics_snippet_textdomain() {
	load_plugin_textdomain( 'minimal-analytics', false, basename( dirname( __FILE__ ) ) . '/languages' );
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
	switch((int)get_option( 'masjs_anonymizeIp' )) {
		case 0:
			$masjs_anonymizeIp = 0;
			break;
		case 1:
		default: 
			$masjs_anonymizeIp = 1;
			break;
	}
	$masjs_colorDepth = 1;
	switch((int)get_option( 'masjs_colorDepth' )) {
		case 0:
			$masjs_colorDepth = 0;
			break;
		case 1:
		default: 
			$masjs_colorDepth = 1;
			break;
	}
	$masjs_characterSet = 1;
	switch((int)get_option( 'masjs_characterSet' )) {
		case 0:
			$masjs_characterSet = 0;
			break;
		case 1:
		default: 
			$masjs_characterSet = 1;
			break;
	}
	$masjs_screenSize = 1;
	switch((int)get_option( 'masjs_screenSize' )) {
		case 0:
			$masjs_screenSize = 0;
			break;
		case 1:
		default: 
			$masjs_screenSize = 1;
			break;
	}
	$masjs_language = 1;
	switch((int)get_option( 'masjs_language' )) {
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
          <tbody>
          <tr>
            <th scope="row"><label for="masjs_ua"><?php _e('Google Analytics UA', 'minimal-analytics'); ?></label></th>
            <td><input type="text" class="regular-text" id="masjs_ua" name="masjs_ua" placeholder="UA-XXXXXX-NN" value="<?php echo $masjs_ua; ?>"></td>
          </tr>
          <tr>
            <th scope="row"><label for="masjs_anonymizeIp"><?php _e('Send: Anonymized IP', 'minimal-analytics'); ?></label></th>
            <td><fieldset><input type="checkbox" id="masjs_anonymizeIp" name="masjs_anonymizeIp" value="1"<?php if($masjs_anonymizeIp) echo 'checked'; ?>></fieldset></td>
          </tr>
          <tr>
            <th scope="row"><label for="masjs_colorDepth"><?php _e('Send: Color Depth', 'minimal-analytics'); ?></label></th>
            <td><fieldset><input type="checkbox" id="masjs_colorDepth" name="masjs_colorDepth" value="1"<?php if($masjs_colorDepth) echo ' checked'; ?>></fieldset></td>
          </tr>
          <tr>
            <th scope="row"><label for="masjs_characterSet"><?php _e('Send: Character Set', 'minimal-analytics'); ?></label></th>
            <td><fieldset><input type="checkbox" id="masjs_characterSet" name="masjs_characterSet" value="1"<?php if($masjs_characterSet) echo ' checked'; ?>></fieldset></td>
          </tr>
          <tr>
            <th scope="row"><label for="masjs_screenSize"><?php _e('Send: Screen Size', 'minimal-analytics'); ?></label></th>
            <td><fieldset><input type="checkbox" id="masjs_screenSize" name="masjs_screenSize" value="1"<?php if($masjs_screenSize) echo ' checked'; ?>></fieldset></td>
          </tr>
          <tr>
            <th scope="row"><label for="masjs_language"><?php _e('Send: Language', 'minimal-analytics'); ?></label></th>
            <td><fieldset><input type="checkbox" id="masjs_language" name="masjs_language" value="1"<?php if($masjs_language) echo ' checked'; ?>></fieldset></td>
          </tr>
        </table>
        <p class="submit">
          <input type="submit" class="button button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
      </form>
		</div>
<?php
	unset($masjs_ua, $masjs_anonymizeIp, $masjs_colorDepth, $masjs_characterSet, $masjs_screenSize, $masjs_language);
}
