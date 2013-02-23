<?php
defined('_JEXEC') or die('Restricted access');

include_once(JPATH_BASE . "/components/com_twitter/helper.php");

$config = JFactory::getConfig();
$baseurl = $config->getValue('config.live_site');

try {
  $helper = new ComTwitterHelper();
} catch (Exception $e) {
  echo JText::_("Could not retrieve Twitter Consumer info. Have you installed com_twitter and configured it?");
  return;
}
if (!$helper->areCookiesSet()) {
  $authUrl = $helper->getAuthenticateUrl();
  echo '<a href="' . $authUrl . '">';
  echo '<img src="' . $baseurl . "/components/com_twitter/twitter-signin.png" . '"'; 
  echo ' alt="sign in with twitter" title="sign in with twitter">';
  echo '</a>';
} else {
    try {
      $twitterInfo = $helper->getCredentials();
      echo '<img src="' . $twitterInfo->profile_image_url . '"><br />';
      echo $twitterInfo->screen_name;
      echo '<br />';
      echo $twitterInfo->status->text;
    } catch(Exception $e){
      $error = json_decode($e->getMessage());
      echo sprintf("Error occoured. (%s)", $error->error);
    }
  }
?>
