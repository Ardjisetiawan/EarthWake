# EarthWake
EarthWake is an api that could be used to 'detect' earthquake around the user location in Indonesia. 

How the API works:
It retrieve earthquake data from Badan Meteorologi, Klimatologi, dan Geofisika (BMKG). Most recent earthquake time data is collected and compared to user current time. If both time is close, means that recently there's an earthquake happened, the API will further confirm whether the earthquake might jeopardizing the user (magnitude >= 5.5) or not (magnitude < 5.5). This value is choosen based on http://www.geo.mtu.edu/UPSeis/magnitude.html. 

If the earthquake might jeopardizing the user, API will calculate earthquake radius of impact and the distance of user to earthquake epicentrum. If user distance to epicentrum is less then earthquake radius of impact, means the user might get impacted by the earthquake, the API will send earthquake data.

Disclaimers:
- Earthquake data (time, magnitude, epicentrum) come from data.bmkg.go.id/autogempa.xml.
- User Location:
  1. First Version: Method of obtaining user location currently use ip-api.io. Got some usage limit problem from this method, will be      fixed in the next update.
  2. Second Version: Change method of obtaining user location to ipinfodb.com api. No problem found in using this method.
- Distance from one latitude-longitude point to another point calculator (geodatasource.php) come from geodatasource.com.
- Earhquake radius calculation is based on  http://www.cqsrg.org/tools/perceptionradius/

Installation:
-Please install auth0/auth0-php and vlucas/phpdotenv on composer before using this. 
