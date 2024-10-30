var arrayStatus = [false, true];
var fail_timeout =  interval = app_key = app_version = url = "", 
    ignore_bots = debug = arrayStatus[0];

if(data.countlyString && data.countlyString.fail_timeout) {
  fail_timeout = data.countlyString.fail_timeout;
}
if(data.countlyString && data.countlyString.interval) {
  interval = data.countlyString.interval;
}
if(data.countlyString && data.countlyString.ignore_bots) {
  ignore_bots = arrayStatus[data.countlyString.ignore_bots];
}
if(data.countlyString && data.countlyString.debug) {
  debug = arrayStatus[data.countlyString.debug];
}
if(data.countlyString && data.countlyString.app_key) {
  app_key = data.countlyString.app_key;
}
if(data.countlyString && data.countlyString.app_version) {
  app_version = data.countlyString.app_version;
}
if(data.countlyString && data.countlyString.url) {
  url = data.countlyString.url;
}
var Countly, data = data;
//countly initialize
Countly.init({
  fail_timeout: fail_timeout,
  interval: interval,
  ignore_bots: ignore_bots,
  debug: debug,
  app_key: app_key,
  app_version: app_version,
  url: url
});
//track session
if(data.tracker && data.tracker.countlytracker_sessions) {
  Countly.track_sessions();
}
//track page views
if(data.tracker && data.tracker.countlytracker_pageviews) {
  Countly.track_pageview();
}
//track user clicks
if(data.tracker && data.tracker.countlytracker_clicks) {
  Countly.track_clicks();
}
//track links
if(data.tracker && data.tracker.countlytracker_links) {
  Countly.track_links();
}
//track form data
if(data.tracker && data.tracker.countlytracker_form_data) {
  Countly.track_forms();
}
//track conversion
if(data.tracker && data.tracker.countlytracker_conversions) {
  Countly.report_conversion();
}
//track errors
if(data.tracker && data.tracker.countlytracker_errors) {
  Countly.track_errors();
}
//track profile data
var name = userName = email = "";
if(data.countlyProfile && data.countlyProfile.name) {
  name = data.countlyProfile.name;
}
if(data.countlyProfile && data.countlyProfile.username) {
  username = data.countlyProfile.username;
}
if(data.countlyProfile && data.countlyProfile.email) {
  email = data.countlyProfile.email;
}
Countly.user_details({
  name: name,
  username: username,
  email: email
});