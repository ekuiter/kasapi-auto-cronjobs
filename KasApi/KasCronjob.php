<?php

namespace KasApi;

class KasCronjob {
  private static $autoIndicator = '[auto] ';
  private $_cronjob, $_kasApi;

  function __construct($cronjob, $kasApi) {
    $this->_cronjob = $cronjob;
    $this->_kasApi = $kasApi;
  }

  public function setActive($isActive) {
    $comment = $this->_cronjob['cronjob_comment'];
    if (!strstr($comment, self::$autoIndicator))
      $comment = self::$autoIndicator . $comment;
    return $this->_kasApi->update_cronjob(array(
      'cronjob_id' => $this->_cronjob['cronjob_id'],
      'is_active' => $isActive ? 'Y' : 'N',
      'cronjob_comment' => $comment
    ));
  }

  public function isSearchResult($cronjob) {
    foreach ($cronjob as $key => $value)
      if ($key === 'cronjob_comment') {
        if (str_replace(self::$autoIndicator, '', $this->_cronjob[$key]) !== $value)
          return false;
      } else if ($this->_cronjob[$key] !== $value)
        return false;
    return true;
  }

  public static function search($kasCronjobs, $cronjob) {
    $searchResults = array();
    foreach ($kasCronjobs as $kasCronjob)
      if ($kasCronjob->isSearchResult($cronjob))
        $searchResults[] = $kasCronjob;
    return $searchResults;
  }

  public static function getKasCronjobs($kasApi) {
    $kasCronjobs = array();
    foreach ($kasApi->get_cronjobs() as $cronjob)
      $kasCronjobs[] = new KasCronjob($cronjob, $kasApi);
    return $kasCronjobs;
  }
}