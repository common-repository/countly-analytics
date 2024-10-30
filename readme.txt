=== Analytics for Wordpress - by Countly ===
Tags: analytics, mobile analytics, web analytics, mobile marketing
Requires at least: 4.0
Tested up to: 4.6
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Countly is a mobile and web analytics platform. This plugin adds Countly code to your Wordpress server.

== Description ==
This plugin helps you integrate *Countly web SDK* easily in your Wordpress installation so you don't have to add the Countly Javascript snippet in your theme files. It also helps enable different Countly web analytics features. 

In order to use this plugin, you need at least: 

1. Wordpress 4.0 or higher
2. PHP 5.4 or higher
3. Countly Community or Enterprise Edition 16.06 or higher [download Community Edition here](http://github.com/countly/countly-server)

For more information about Countly's features and comparison between Countly editions, see [Countly comparison](http://count.ly/compare) and [Countly Enterprise Edition features](http://count.ly/enterprise-edition-features).

== Installation ==

First of all, you need a working Countly instance (e.g Community Edition), or use a [30-day free Countly trial server here](https://count.ly/try-countly-enterprise/).

1. Go to plugins > Add New in your Wordpress admin page.
2. Search for Countly and install "Analytics for Wordpress - by Countly"
3. Activate plugin
4. Go to Settings > Analytics and configure plugin. Here, select any number of features you want to track and then enable Countly tracking. 

You need to define the web app already on Countly dashboard since Countly plugin installation requires API key to work. 

That is it! You can now get stats of your Wordpress page from Countly dashboard easily.

== Frequently Asked Questions ==

= Which data does this plugin collect? =

Countly web analytics plugin Wordpress can collect the following data and it's configurable: 

* Session tracking
* Pageview tracking
* Clicks for heatmaps (Enterprise Edition)
* Track link clicks
* Track form submisisons
* Report conversions
* Report Javascript errors

It can also help you define application version or whether plugin should work in debug mode.

= Where can I find app key? =

Login to your Countly dashboard and go to `Dashboard > Management > Applications` - and select app. There you'll see App key.

= How do I download Countly? =

You can [download Countly Community Edition here](http://github.com/countly/countly-server) and check installation instructions on [how to install](http://resources.count.ly/docs/installing-countly-server). For Enterprise Edition, please [contact us](https://count.ly/enterprise-contact-us/).

== Changelog ==

= 1.0 =
* Initial release
