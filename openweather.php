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


  function show_weather($area) {
    $w = weather($area);
    
    if (!$w) return false;
    ?>
    <!-- weather -->
  	<div class="weather-container">
      <h4><?php echo $area; ?> 5 day Weather Forecast</h4>
      <ul id="weather">
        <li>
          <span>
            <span class="wearher-icon"><img src="http://openweathermap.org/img/w/<?php echo $w->forecast->time[0]->symbol->attributes()->var; ?>.png" /></span><br />
      	    <strong class="temp"><?php echo ceil($w->forecast->time[0]->temperature->attributes()->day); ?>&deg;C</strong><br />
            <small class="meta">
              <strong>Date</strong> Today<br />
              <strong>Min</strong> <?php echo ceil($w->forecast->time[0]->temperature->attributes()->min); ?>&deg;C
              <strong>Max</strong> <?php echo ceil($w->forecast->time[0]->temperature->attributes()->max); ?>&deg;C
            </small>
          </span>
        </li>
        <li>
          <span>
            <span class="wearher-icon"><img src="http://openweathermap.org/img/w/<?php echo $w->forecast->time[1]->symbol->attributes()->var; ?>.png" /></span><br />
      	    <strong class="temp"><?php echo ceil($w->forecast->time[1]->temperature->attributes()->day); ?>&deg;C</strong><br />
            <small class="meta">
              <strong>Date</strong> <?php echo date('l', strtotime($w->forecast->time[1]->attributes()->day)); ?><br />
              <strong>Min</strong> <?php echo ceil($w->forecast->time[1]->temperature->attributes()->min); ?>&deg;C
              <strong>Max</strong> <?php echo ceil($w->forecast->time[1]->temperature->attributes()->max); ?>&deg;C
            </small>
          </span>
        </li>
        <li>
          <span>
            <span class="wearher-icon"><img src="http://openweathermap.org/img/w/<?php echo $w->forecast->time[2]->symbol->attributes()->var; ?>.png" /></span><br />
      	    <strong class="temp"><?php echo ceil($w->forecast->time[2]->temperature->attributes()->day); ?>&deg;C</strong><br />
            <small class="meta">
              <strong>Date</strong> <?php echo date('l', strtotime($w->forecast->time[2]->attributes()->day)); ?><br />            
              <strong>Min</strong> <?php echo ceil($w->forecast->time[2]->temperature->attributes()->min); ?>&deg;C
              <strong>Max</strong> <?php echo ceil($w->forecast->time[2]->temperature->attributes()->max); ?>&deg;C
            </small>
          </span>
        </li>
        <li>
          <span>
            <span class="wearher-icon"><img src="http://openweathermap.org/img/w/<?php echo $w->forecast->time[3]->symbol->attributes()->var; ?>.png" /></span><br />
      	    <strong class="temp"><?php echo ceil($w->forecast->time[3]->temperature->attributes()->day); ?>&deg;C</strong><br />
            <small class="meta">
              <strong>Date</strong> <?php echo date('l', strtotime($w->forecast->time[3]->attributes()->day)); ?><br />            
              <strong>Min</strong> <?php echo ceil($w->forecast->time[3]->temperature->attributes()->min); ?>&deg;C
              <strong>Max</strong> <?php echo ceil($w->forecast->time[3]->temperature->attributes()->max); ?>&deg;C
            </small>
          </span>
        </li>
        <li>
          <span>
            <span class="wearher-icon"><img src="http://openweathermap.org/img/w/<?php echo $w->forecast->time[4]->symbol->attributes()->var; ?>.png" /></span><br />
      	    <strong class="temp"><?php echo ceil($w->forecast->time[4]->temperature->attributes()->day); ?>&deg;C</strong><br />
            <small class="meta">
              <strong>Date</strong> <?php echo date('l', strtotime($w->forecast->time[3]->attributes()->day)); ?><br />            
              <strong>Min</strong> <?php echo ceil($w->forecast->time[4]->temperature->attributes()->min); ?>&deg;C
              <strong>Max</strong> <?php echo ceil($w->forecast->time[4]->temperature->attributes()->max); ?>&deg;C
            </small>	        
          </span>
        </li>
      </ul>
  	</div>
  <?php
  }
