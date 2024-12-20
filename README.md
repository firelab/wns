What the Phone Home Does: 


This server displays the stats of WindNinja Gui runs and shows who is using it and when. This server runs on the ninjastorm.firelab.org server. 

### 
It uses curl requests to IPINFO to geolocate users based on IP.

###
PHP scripts query a Sqlite db with user info stored and this info gets displayed in vanilla JS. 



###
How it works (easy code): 


Schemas: 
|||
The schemas defined in the code are a "locations" table which defines a table that contains information for a unique IP. 
Given IP1 - example country, example lat, example long, etc 
IP2 - example country, example lat, example long, etc 

The "totals" table which defines the primary key as a date (12/12/2024) and then the total gui/cli runs + total runs on that given date.
|||


Markers.php
|||
1. In markers.php the code is separated into handling the get request when a user loads the gui/cli and handling the post request when a user tries to search for data within a certain timeframe (using that big search bar at the top of the stats page). 

Functionality of the code:
MakeDisplay() - this displays the rows and columns of data in the table at the bottom of the stats page. 
Line 165 - 306 - This handles the post request for the website, which occurs when a user passes in say a certain date, and queries the "locations" table to get the rows that correspond to what the user searched. At line 301, makedisplay is called with this specific set of data and updates the table at the bottom of the page as such.  
Line 316 - This handles the get request for the website. At Line 406 we detect if there exists a entry in the locations table with the IP given from the user. If there is, we update that entry for that IP. Otherwise we have a unique IP and on line 434, we go through the process of making our request to that IPInfo page to get the information needed to populate the locations table from that IP (so where the country that IP is from, lat, long, etc.). 
At Line 553 - 6111, we update the total amount of requests made at the date we just got this new user request from. 
From 619 - the end, we get the entry data from the "totals" table and send it to the other php file (we send some variables from here to index.php)
|||



index.php: 
|||
- You can match the variables set in markers.php up to variables here, and these variables are used to display on a simple chart.js chart which shows the dates, total CLI/GUI runs for each date, etc. 
|||

###
To edit SSH into /etc/var/www/html/sqlitetest 
/var/log/apache2/error.log.1 or /var/log/apache2/error.log help debug the PHP


Current issues needing fixing - sometimes date time only sets the year, some IPs are unique each time? maybe an issue with the api

 ++++ I THINK the issue is I should change the IP fetching code because it does not seem to be the best way right now

 If there's any issues where there are duplicated run values in the table for one lat long, you can maybe just add them up to see how much that user totaled.



/******************************************************************************
*
* $Id$
*
* Project:  WindNinja
* Purpose:  PhoneH Server
* Author:   Rui Zhang <ruizhangslc2017@gmail.com>
*
******************************************************************************
*
* THIS SOFTWARE WAS DEVELOPED AT THE ROCKY MOUNTAIN RESEARCH STATION (RMRS)
* MISSOULA FIRE SCIENCES LABORATORY BY EMPLOYEES OF THE FEDERAL GOVERNMENT
* IN THE COURSE OF THEIR OFFICIAL DUTIES. PURSUANT TO TITLE 17 SECTION 105
* OF THE UNITED STATES CODE, THIS SOFTWARE IS NOT SUBJECT TO COPYRIGHT
* PROTECTION AND IS IN THE PUBLIC DOMAIN. RMRS MISSOULA FIRE SCIENCES
* LABORATORY ASSUMES NO RESPONSIBILITY WHATSOEVER FOR ITS USE BY OTHER
* PARTIES,  AND MAKES NO GUARANTEES, EXPRESSED OR IMPLIED, ABOUT ITS QUALITY,
* RELIABILITY, OR ANY OTHER CHARACTERISTIC.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
* OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
* THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
* FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
* DEALINGS IN THE SOFTWARE.
*
*****************************************************************************/


