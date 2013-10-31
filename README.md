New Relic Submit Deploy 
==========================

With this simple PHP application you can submit deployments, or other important events, to your new relic monitoring account.

You have to enable curl within PHP.

# Usage

Simple usage 
```````````
http://yourserver.com/newrelicsubmitdeploy.php
```````````
Advanced usage to bookmark your key and prefill your app
```````````
http://yourserver.com/newrelicsubmitdeploy.php?apikey=yourapikey&appid=yourappid
```````````
GET or POST http with all fields, replace # for actual values
```````````
http://yourserver.com/newrelicsubmitdeploy.php?apikey=#&appid=#&user=#&description=#&revision=#&changelog=#
