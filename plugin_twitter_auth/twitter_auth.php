<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.event.plugin' );

class plgAuthenticationTwitter_auth extends JPlugin
{
	function plgAuthenticationTwitter_auth(& $subject)
	{
		parent::__construct($subject);
	}

	function onAuthenticate( $credentials, $options, &$response )
	{
    $response->status	= JAUTHENTICATE_STATUS_FAILURE;
    $response->error_message = 'Twitter authentication failed';
    
    if ( $credentials['username'] == 'COM_TWITTER' || $credentials['password'] == 'COM_TWITTER_LOGIN' ) {
      if (isset($_SESSION['com_twitter'])) {
        $com_twitter = $_SESSION['com_twitter'];
        unset($_SESSION['com_twitter']);
        
        $user = new JUser();
        $user->load($com_twitter->mapping->userid);
        
        if ($user) {
          $response->status	= JAUTHENTICATE_STATUS_SUCCESS;
          $response->username = $user->username;
          $response->email = $user->email;
          $response->fullname = $user->name;
          $response->error_message = '';
        }
      }
    }
	}
}
