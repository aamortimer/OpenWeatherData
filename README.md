Open Weather Data
===============

Simple PHP function to load the data from the open weather api.

##Usage
```php
  
  // grab the data and dump out the response
  $data = weather('Crawley, West Sussex');
  print_r($data);
  
  
  // display the data using show_weather function
  echo show_weather('Crawley, West Sussex');
  
```
