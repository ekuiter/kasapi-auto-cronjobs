<?php

defined('INCLUDED') or die;

$GLOBALS['debug_mode'] = false; // true enables error reporting
// time to wait for each API request to avoid flood protection exception
// The higher this value, the slower (but more reliable) this script.
// If you use this script as a cronjob itself, reliability usually surpasses performance.
$GLOBALS['flood_protection'] = 1000; // wait 1 second (value chosen by experience)
$GLOBALS['password'] = 'abcdefghijklmnopqrstuvwxyz123456'; // has to be passed as 'pass' URL parameter

$GLOBALS['accounts'] = array(

  // first account
  array(
    // account configuration
    'configuration' => new KasApi\KasConfiguration('username1', sha1('password1'), 'sha1'),
    // array of cronjobs that should be (de)activated
    'cronjobs' => array(

      array(
        // filters a cronjob e.g. by its comment or http_url, other filtering criteria is possible
        // (cronjob_id, protocol, http_url, cronjob_comment, ..., see more in KasApi documentation)
        'cronjob' => array('cronjob_comment' => 'my comment', 'http_url' => 'some.domain.com'),
        'isActive' => hourIsInRange(7, 20) // only activate the cronjob if it is between 7 and 20 o'clock
      )

      // more cronjobs
      // array(...)
    )
  ),

  // second account
  array(
    'configuration' => new KasApi\KasConfiguration('username2', sha1('password2'), 'sha1'),
    'cronjobs' => array(

      array(
        'cronjob' => array('cronjob_comment' => 'some other comment', 'http_url' => 'another.domain.com'),
        'isActive' => hourIsInRange(7, 20)
      )

      // more cronjobs
      // array(...)
    )
  )

  // more accounts
  // array(...)
);

// You could add more cronjobs to the first account like this to save some keystrokes:
// $additionalCronjobs = array(
//   // array(min hour, max hour, cronjob filter)
//   array(7, 20, array('cronjob_comment' => '...', 'http_url' => '...')),
//   array(9, 22, array('cronjob_comment' => '...', 'http_url' => '...')),
//   // more cronjobs
//   // array(...)
// );
//
// foreach ($additionalCronjobs as $cronjob)
//   $GLOBALS['accounts'][0]['cronjobs'][] = array('cronjob' => $cronjob[2], 'isActive' => hourIsInRange($cronjob[0], $cronjob[1]));