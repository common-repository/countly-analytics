<?php
defined('ABSPATH') or die('No script kiddies please!');
if (!function_exists('countlytracker_options_list')):
  function countlytracker_options_list() {
    $updated = 0;
    if (isset($_POST['countlytrackerSavechanges']) && current_user_can('manage_options') && check_admin_referer('countlytracker_addsetting', 'countlytracker_nonce')) {
      $customArr = array(
          'countlytracker_init' =>
          array(
              'fail_timeout' => ((isset($_POST['countlytracker_init']['fail_timeout']) && !empty($_POST['countlytracker_init']['fail_timeout'])) ? intval($_POST['countlytracker_init']['fail_timeout']) : ''),
              'interval' => ((isset($_POST['countlytracker_init']['interval']) && !empty($_POST['countlytracker_init']['interval'])) ? intval($_POST['countlytracker_init']['interval']) : ''),
              'ignore_bots' => ((isset($_POST['countlytracker_init']['ignore_bots'])) ? intval(1) : intval(0)),
              'debug' => ((isset($_POST['countlytracker_init']['debug'])) ? intval(1) : intval(0)),
              'app_key' => (((isset($_POST['countlytracker_init']['app_key'])) && !empty($_POST['countlytracker_init']['app_key'])) ? sanitize_text_field($_POST['countlytracker_init']['app_key']) : ''),
              'app_version' => (((isset($_POST['countlytracker_init']['app_version'])) && !empty($_POST['countlytracker_init']['app_version'])) ? filter_var($_POST['countlytracker_init']['app_version'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : ''),
              'url' => (((isset($_POST['countlytracker_init']['url'])) && !empty($_POST['countlytracker_init']['url'])) ? esc_url($_POST['countlytracker_init']['url']) : '')
          ),
          'countlytracker_field' =>
          array(
              'countlytracker_sessions' => ((isset($_POST['countlytracker_field']['countlytracker_sessions'])) ? intval(1) : intval(0)),
              'countlytracker_pageviews' => ((isset($_POST['countlytracker_field']['countlytracker_pageviews'])) ? intval(1) : intval(0)),
              'countlytracker_clicks' => ((isset($_POST['countlytracker_field']['countlytracker_clicks'])) ? intval(1) : intval(0)),
              'countlytracker_links' => ((isset($_POST['countlytracker_field']['countlytracker_links'])) ? intval(1) : intval(0)),
              'countlytracker_form_data' => ((isset($_POST['countlytracker_field']['countlytracker_form_data'])) ? intval(1) : intval(0)),
              'countlytracker_conversions' => ((isset($_POST['countlytracker_field']['countlytracker_conversions'])) ? intval(1) : intval(0)),
              'countlytracker_errors' => ((isset($_POST['countlytracker_field']['countlytracker_errors'])) ? intval(1) : intval(0))
          ),
          'countlytracker_switch' => intval($_POST['countlytracker_switch']),
          'countlytracker_isadminlogged' => intval($_POST['countlytracker_isadminlogged'])
      );
      //save options
      foreach ($customArr as $key => $value) {
        if (get_option($key) !== false) {
          update_option($key, $value);
        } else {
          add_option($key, $value);
        }
      }
      $updated = 1;
    }
    $tooltipImage = plugins_url('countly-analytics/images/question-mark.png');
    $ct_init = get_option('countlytracker_init');
    $options = get_option('countlytracker_field');
    $switch = get_option('countlytracker_switch');
    $isadminlogged = get_option('countlytracker_isadminlogged');
    ?>
    <div class="wrap">
      <h2><?php echo __('Countly Analytics Settings'); ?></h2>
    <?php if ($updated == 1) { ?>
        <div class="updated notice notice-success is-dismissible below-h2" id="message">
          <p><?php echo __('Settings saved successfully.'); ?></p>
          <button class="notice-dismiss" type="button">
            <span class="screen-reader-text"><?php echo __('Dismiss this notice.'); ?></span>
          </button>
        </div>
    <?php } ?>
      <div id="general" class="wpseotab gatab active">
        <div class="yoast-graphs ct-desc">
          <p><?php
            echo __('This plugin helps you integrate Countly SDK easily in your Wordpress installation so you don' . 't'
                . 'have to add the Countly Javascript snippet in your theme files. It also helps enable different <a target="_blank" href="http://count.ly/web-analytics">Countly web analytics</a> features. ');
            ?>
          </p>
        </div>
      </div>
      <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <div class="ct-group">
          <h2  class="sub-title"><?php echo __('Enable plugin'); ?></h2>
          <div class="ga-form countlytracker-form-input">
            <label for="enable" class="countly-label"><?php echo __('Enable'); ?>               
              <input name="countlytracker_switch" id="enable" type="radio" value="1" <?php checked('1', $switch); ?> />
            </label>
          </div>
          <div class="ga-form countlytracker-form-input">
            <label for="disable" class="countly-label"><?php echo __('Disable'); ?>
              <input name="countlytracker_switch" id="disable" type="radio" value="0" <?php checked('0', $switch); ?> />
            </label>
          </div>
        </div>
        <div class="ct-group">
          <h2  class="sub-title"><?php echo __('Disable Logging'); ?> <img class="tooltip" title="If yes, Countly Do not send analytics data for logged in Wordpress admin." src="<?php echo $tooltipImage; ?>" /></h2>
          <div class="ga-form countlytracker-form-input">
            <label for="enableadmin" class="countly-label"><?php echo __('Yes'); ?>         
              <input name="countlytracker_isadminlogged" id="enableadmin" type="radio" value="1" <?php checked('1', $isadminlogged); ?> />
            </label>
          </div>
          <div class="ga-form countlytracker-form-input">
            <label for="disableadmin" class="countly-label"><?php echo __('No'); ?> 
              <input name="countlytracker_isadminlogged" id="disableadmin" type="radio" value="0" <?php checked('0', $isadminlogged); ?> />
            </label>
          </div>
        </div>
        <div class="ct-group">
          <h2  class="sub-title"><?php echo __('Mandatory parameters'); ?></h2>
          <div class="ga-form countlytracker-form-input">
            <label class="countly-label"><?php echo __('Your app key'); ?>
              <img class="tooltip" title="This is the app key specific to your web application.You can retrieve it from your Countly dashboard by clicking on Management > Applications and corresponding web app." src="<?php echo $tooltipImage; ?>" />
            </label>
            <input type="text" class="countlytracker-text" name="countlytracker_init[app_key]"
                   value="<?php echo sanitize_title(isset($ct_init) && isset($ct_init['app_key']) ? $ct_init['app_key'] : ''); ?>"/>
          </div>
          <div class="ga-form countlytracker-form-input">
            <label class="countly-label"><?php echo __('Server URL'); ?>
              <img class="tooltip" src="<?php echo $tooltipImage ?>" title="This is the server URL. It should start with http:// or https://" /></label>
            <input type="url" name="countlytracker_init[url]" 
                   value="<?php echo esc_url(isset($ct_init) && isset($ct_init['url']) ? $ct_init['url'] : ''); ?>"/>
          </div>
        </div>
        <div class="ct-group">
          <h2  class="sub-title"><?php echo __('Optional parameters'); ?></h2>
          <div class="ga-form countlytracker-form-input">
            <label class="countly-label"><?php echo __('Application version'); ?>
              <img class="tooltip" title="Version of the application tracked with Countly. Ex: 1.0, 1.1" src="<?php echo $tooltipImage; ?>" /></label>
            <input type="text" class="countlytracker-text" name="countlytracker_init[app_version]" 
                   value="<?php echo filter_var(isset($ct_init) && isset($ct_init['app_version']) ? $ct_init['app_version'] : '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?>"/>
          </div>
          <div class="ga-form countlytracker-form-input">
            <label class="countly-label"><?php echo __('Fail timeout'); ?>
              <img class="tooltip" title="Time in seconds to wait after failed connection to server (default: 60 seconds)" src="<?php echo $tooltipImage; ?>" />
            </label>
            <input type="text" class="countlytracker-text" name="countlytracker_init[fail_timeout]" 
                   value="<?php echo (isset($ct_init['fail_timeout']) && !empty($ct_init['fail_timeout']) ? intval($ct_init['fail_timeout']) : ''); ?>"/>
          </div>
          <div class="ga-form countlytracker-form-input">
            <label class="countly-label"><?php echo __('Interval'); ?>
              <img class="tooltip" title="Duration in milliseconds how often to check if there is any data to report and report it (default: 500 ms)" src="<?php echo $tooltipImage; ?>" />
            </label>
            <input type="text" class="countlytracker-text" name="countlytracker_init[interval]" 
                   value="<?php echo (isset($ct_init['interval']) && !empty($ct_init['interval']) ? intval($ct_init['interval']) : ''); ?>"/>
          </div>
          <div class="ga-form countlytracker-form-input">
            <label for="ct_bots" class="countly-label"><?php echo __('Ignore bots'); ?>
              <img class="tooltip" title="Option to ignore traffic from bots (default: true)" src="<?php echo $tooltipImage; ?>" /></label>
            <input name="countlytracker_init[ignore_bots]" type="checkbox" id="ct_bots" class="countlytracker-checkbox" <?php checked(isset($ct_init['ignore_bots']) && $ct_init['ignore_bots'] == intval(1)); ?> value="1" />
          </div>
          <div class="ga-form countlytracker-form-input">
            <label for="ct_debug" class="countly-label"><?php echo __('Debug'); ?>
              <img class="tooltip" title="Output debug info into console (default: false)" src="<?php echo $tooltipImage; ?>" />
            </label>
            <input name="countlytracker_init[debug]" type="checkbox" id="ct_debug" class="countlytracker-checkbox" <?php checked(isset($ct_init['debug']) && $ct_init['debug'] == intval(1)); ?> value="1" />
          </div>
        </div>
        <div class="ct-group">
          <h2 class="sub-title"><?php echo __('Trackers'); ?></h2>
          <div class="ga-form countlytracker-form-input">
            <label for="ct_session" class="countly-label"><?php echo __('Track sessions'); ?>
              <img class="tooltip" title="This option will automatically track user sessions, by calling begin, extend and end session method." src="<?php echo $tooltipImage; ?>" />
            </label>
            <input name="countlytracker_field[countlytracker_sessions]" type="checkbox" id="ct_session" class="countlytracker-checkbox" value="1"<?php checked(isset($options['countlytracker_sessions']) && $options['countlytracker_sessions'] == intval(1)); ?>>                                                      
          </div>    
          <div class="ga-form countlytracker-form-input">
            <label for="ct_pageview" class="countly-label"><?php echo __('Track pageviews'); ?>
              <img class="tooltip" title="This option will track current pageview, by using location.path as page name and report it to server" src="<?php echo $tooltipImage; ?>" />
            </label>
            <input name="countlytracker_field[countlytracker_pageviews]" type="checkbox" id="ct_pageview" class="countlytracker-checkbox" value="1" <?php checked(isset($options['countlytracker_pageviews']) && $options['countlytracker_pageviews'] == intval(1)); ?>>
          </div>
          <div class="ga-form countlytracker-form-input">
            <label for="ct_click" class="countly-label"><?php echo __('Track clicks for heatmaps'); ?>
              <img class="tooltip" title="When enabled, will automatically track clicks on last reported view and display them on a heat map (only available for Enterprise Edition)" src="<?php echo $tooltipImage; ?>" />
            </label>
            <input name="countlytracker_field[countlytracker_clicks]" type="checkbox" id="ct_click" class="countlytracker-checkbox" value="1"<?php checked(isset($options['countlytracker_clicks']) && $options['countlytracker_clicks'] == intval(1)); ?>>
          </div>
          <div class="ga-form countlytracker-form-input">
            <label for="ct_link" class="countly-label"><?php echo __('Track link clicks'); ?>
              <img class="tooltip" title="This option will track click to specific links and will report with custom events with key linkClick and link's text, id and url as segments." src="<?php echo $tooltipImage; ?>" />
            </label>
            <input name="countlytracker_field[countlytracker_links]" type="checkbox" id="ct_link" class="countlytracker-checkbox" value="1"<?php checked(isset($options['countlytracker_links']) && $options['countlytracker_links'] == intval(1)); ?>>
          </div>
          <div class="ga-form countlytracker-form-input">
            <label for="ct_form" class="countly-label"><?php echo __('Track form submissions'); ?>
              <img class="tooltip" title="This method will automatically track form submissions and collect form data and input values in the form and report as Custom Event with formSubmit key." src="<?php echo $tooltipImage; ?>" />
            </label>
            <input name="countlytracker_field[countlytracker_form_data]" type="checkbox" id="ct_form" class="countlytracker-checkbox" value="1"<?php checked(isset($options['countlytracker_form_data']) && $options['countlytracker_form_data'] == intval(1)); ?>>
          </div>
          <div class="ga-form countlytracker-form-input">
            <label for="ct_conversion" class="countly-label"><?php echo __('Report conversions'); ?>
              <img class="tooltip" title="When using Countly attribution analytics, you can also report conversion to Countly server, like for example when visitor purchased something or registered." src="<?php echo $tooltipImage; ?>" />
            </label>
            <input name="countlytracker_field[countlytracker_conversions]" type="checkbox" id="ct_conversion" class="countlytracker-checkbox" value="1"<?php checked(isset($options['countlytracker_conversions']) && $options['countlytracker_conversions'] == intval(1)); ?>>
          </div>
          <div class="ga-form countlytracker-form-input">
            <label for="ct_error" class="countly-label"><?php echo __('Report JS errors'); ?>
              <img class="tooltip" title="Countly also provides a way to track Javascript errors in your websites. To automatically capture and report Javascript errors on your website, enable this function." src="<?php echo $tooltipImage; ?>" />
            </label>
            <input name="countlytracker_field[countlytracker_errors]" type="checkbox" id="ct_error" class="countlytracker-checkbox" value="1"<?php checked(isset($options['countlytracker_errors']) && $options['countlytracker_errors'] == intval(1)); ?>>
          </div>
        </div>
        <p class="submit">
    <?php wp_nonce_field('countlytracker_addsetting', 'countlytracker_nonce'); ?>
          <input type="submit" name="countlytrackerSavechanges" class="button-primary" value="<?php echo __('Save Changes') ?>" />  
        </p>
      </form>
    </div>
    <?php
  }
endif;
?>