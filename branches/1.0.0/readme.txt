=== Minimal Analytics Snippet ===
Contributors: JavierCasares
Tags: google analytics, gtagjs, minimal analytics, wpo
Requires at least: 4.0
Tested up to: 5.0.2
Stable tag: 1.0.0
License: EUPL 1.2
License URI: https://eupl.eu/1.2/en/
Text Domain: minimal-analytics

== Description ==
A simple Google Analytics snippet (based on David Kuennen minimal-analytics-snippet.js version 2018-12-16 16:49).

This plugins only allows Pageviews, Events and Exceptions.

To track an Event:

ma.trackEvent('Category', 'Action', 'Label', 'Value')

To track an Exception:

ma.trackException('Description', 'Fatal')

== Installation ==
1. Use the Add New Plugin in the WordPress Admin area
2. Activate the plugin through the 'Plugins' menu in WordPress
3. You can find the settings and documentation under Settings -> Minimal Analytics

Then to make plugin work make sure the wp_head() function is used at the theme header.

== Changelog ==

= 1.0.0 =
* First version
