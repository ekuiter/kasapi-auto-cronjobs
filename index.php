<?php

header('Content-Type: text/plain');

define("INCLUDED", true);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/KasApi/KasCronjob.php';
require_once __DIR__ . '/time.inc.php';
require_once __DIR__ . '/config.inc.php';

if ($GLOBALS['debug_mode']) {
  error_reporting(-1);
  ini_set('display_errors', 1);
} else {
  error_reporting(0);
  ini_set('display_errors', 0);
}

function echoLog($message) {
  echo "$message\n";
}

(isset($_GET['pass']) && $_GET['pass'] === $GLOBALS['password']) or die('Unauthorized access');

try {
  foreach ($GLOBALS['accounts'] as $account) {
    $kasApi = new KasApi\KasApi($account['configuration']);
    $kasCronjobs = KasApi\KasCronjob::getKasCronjobs($kasApi);
    echoLog("Processing " . count($kasCronjobs) . " cronjob(s) for account {$account['configuration']->_username}");

    foreach ($account['cronjobs'] as $cronjob) {
      echoLog('  Searching for cronjob ' . json_encode($cronjob['cronjob']));
      $searchResults = KasApi\KasCronjob::search($kasCronjobs, $cronjob['cronjob']);

      echoLog('    ' . ($cronjob['isActive'] ? 'Activating ' : 'Deactivating ') . count($searchResults) . ' matching cronjob(s)');
      foreach ($searchResults as $kasCronjob)
        try {
          usleep($GLOBALS['flood_protection'] * 1000);
          $kasCronjob->setActive($cronjob['isActive']);
        } catch (KasApi\KasApiException $e) {
          $message = $e->getMessage();
          if (!strstr($message, 'nothing_to_do'))
            echoLog("API Exception: $message");
        }
    }
  }
} catch (KasApi\KasApiException $e) {
  echoLog('API Exception: ' . $e->getMessage());
}