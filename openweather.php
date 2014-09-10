<?php
  function weather($code) {
    $code = str_replace('-', ' ', $code);
    $code = urlencode($code);
    $cache = new Cache();
    $cache_name = 'weather_'.$code;
    $xml = '';
    
    $use_errors = libxml_use_internal_errors(true);

    if (!$xml = simplexml_load_string($cache->fetch($cache_name))) {
      $result = @file_get_contents('http://api.openweathermap.org/data/2.5/forecast/daily?q='.$code.',uk&mode=xml&units=metric&cnt=7');

      if (!$result) {
        return false;
      }
      
      $cache->store($cache_name, $result, 86000);
      
      $xml = simplexml_load_string($result);
    }
    
    libxml_clear_errors();
    libxml_use_internal_errors($use_errors);
      
    return $xml;
  }
