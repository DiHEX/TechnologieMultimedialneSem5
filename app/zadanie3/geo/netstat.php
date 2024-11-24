<?php
    session_start();
    if (!isset($_SESSION["loggedin"])) {
        header('Location: ../zadanie.php');
        exit();
    }
?>

<?php

/**
 * netstat.php - Show online status of hosts and services
 *
 * This script is intended to provide a simplified, easily comprehensible
 * and aesthetically pleasing overview of the online status of hosts and
 * services. Checks are done in real-time but they only check whether
 * a port is open (which might be sufficient if your hosts are monitored
 * by full-blown monitoring tools anyway and all you want is a simple
 * interface for e.g. users or clients).
 *
 * This netstat.php has been rewritten and extended by Todd E. Johnson.
 * It is based on the original netstat 0.x by Andreas Schamanek, still
 * available at http://www.fam.tuwien.ac.at/~schamane/sysadmin/netstat/
 *
 * Requirements: fsockopen(), for ICMP pings also exec()
 *
 * (License + History: see also end of file)
 *
 * @author     Todd E. Johnson <http://www.toddejohnson.net>
 * @author     Andreas Schamanek <http://andreas.schamanek.net>
 * @license    GPL <http://www.gnu.org/licenses/gpl.html>
 * @copyright  (c) 2012 Todd E. Johnson, Andreas Schamanek
 *
 */



// Use php netstat.php genconfig to create netstat.conf.php then
// edit netstat.conf.php with your configuration.  


// ------------------------------------------------- functions part of script
/**
 * Catch Exceptions
 * @param Exception $err
 */
function catchExceptions($err){
	global $config;
	echo "Error with your request!  Please try again later.  " .
		"If the problem persists contact <a href=\"".$config['contact']."\">".$config['contact']."</a>.";
	error_log($err->__toString(),0);
	exit(1);
}

// Report no PHP errors (to be safe we include this very early)
error_reporting(0);
set_exception_handler('catchExceptions');

/**
 * Defaults for generic config
 * @return Default configuration
 */
function defaultConfig(){
	$config=array();
	$config['version'] = '~ git master ~ ';
	$config['description'] = "Online status of hosts and services provided by netstat.php";
	
	
	// below we set up some silly defaults; it is recommended to save your
	// own settings in $configfile; if readable it will override our defaults;
	// for a list of all configuration variables see http://wox.at/as/_/netstat_php
	$config['configfile'] = 'netstat.conf.php';
	
	// my network, title and headline of the page
	$config['title'] = "Our Network Status";
	$config['headline'] = $config['title'];
	
	// if $alertfile exists the contents will be included()/shown (use HTML!)
	$config['alertfile'] = 'netstat.txt';
	
	// checks (use pipes (|) with care ;)
	//   syntax: host or IP to check | port | description
	//     host/IP
	// 	     IPv6 addresses must be wrapped in brackets eg [2001:db8::1].  If you
	//       need to check a ssl service like HTTPS, SMTPS, or IMAPS you can use ssl://[2001:db8::1]
	//     port
	//       if $port = 'ping' an ICMP ping will be executed
	//       if $port = 'ping6' an ICMPv6 ping will be executed
	//       if $port = 'headline' $host is printed as a headline
	
	$config['checks'] = array(
	
	     'Examples testing localhost |headline',
	 'localhost | ping| ICMP ping (ping)',
	 'localhost |  80 | WWW server (port 80)',
	 '127.0.0.2 | 443 | WWW server (SSL, port 443)',
	 '127.0.0.1 |  22 | SSH server (port 22)',
	 '127.0.0.3 |  21 | FTP server (port 21)',
	 '-------------------------------------------------',
	    'Some more examples with errors or not :)|headline',
	 'www.hostveryunknown.com| 21|www.hostveryunknown.com',
	 'example.com| 23|example.com:23 (<a href="http://en.wikipedia.org/wiki/Telnet">telnet</a> is dead)',
	 'Empty and negative ports are ignored||',
	 'So are lines without pipe delimiter',
	 'www.google.com  |  80 | WWW server @ google.com',
	 'localhost       |-ping| Disabled ping',
	 'www.example.com | -80 | WWW server @ www.example.com'  // no colon here!
	
	);
	
	// exec command for ping: -l3 (preload) is recommended but
	//defaults($ping_command, 'ping -l3 -c3 -w1 -q'); // might not work everywhere
	$config['ping_command'] = 'ping -c3 -w1 -q';
	$config['ping6_command'] = 'ping6 -c3 -w1 -q';
	
	// fsockopen timeout; might need adjustment depending on network
	$config['timeout'] = 4;
	
	// show a very simple progress indicator (requires Javascript)
	// may be disabled also by adding '?noprogress' to the script's URL
	$config['progressindicator'] = TRUE;
	
	// strings for online and offline (by default these are used for CSS, too)
	$config['online'] = 'Online';
	$config['offline'] = 'Offline';
	
	// print date and/or time (leave empty to show no timestamp)
	$config['datetime'] = 'l, F j, Y, H:i:s T';
	
	// RSS alert feed
	$config['rssfeed'] = TRUE; // use to enable or disable RSS feeds
	// URL of RSS feed
	$config['rssfeedurl'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?rss';
	// RSS feed title
	$config['rsstitle'] = "RSS alert feed of {$config['title']}";
	// RSS header e.g. to include in $htmlheader; set to '' to offer no RSS 
	$config['rssheader'] = '<link rel="alternate" type="application/rss+xml" '."title=\"{$config['rsstitle']}\" href=\"{$config['rssfeedurl']}\" />";
	// RSS alert link (might point e.g. to your network status homepage)
	$config['rsslink'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?noprogress';
	// RSS date and/or time format (here we use a ISO 8601 format)
	$config['rssdatetime'] = 'o-m-d H:i:s T';
	
	// HTML Header
	$config['htmlheader'] = <<<EOH
<!doctype html><html>
<head>
<title>{$config['title']}</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
<meta name="description" content="{$config['description']}" />
{$config['rssheader']}
<style type="text/css">
<!--
body { font-family: Verdana, "Lucida Sans", Arial, Helvetica, sans-serif; font-size: 87%; }
html>body { font-size: 14px; /* for FF */ }
div#container { width: 37em; margin: 0 auto; position: relative; }
.datetime { font-size: 87%; font-weight: bolder; text-align: center; margin-bottom: 2em; }
.version { font-size: 73%; text-align: center; color: black; background: white; }
.version a { font-weight: bolder; color: black; text-decoration: none; }
h1 { color: #500000; border-bottom: 1px solid #999999; text-align: center; margin-bottom: 1em; margin-top: 2em; }
div#alert { border: 1px solid red; padding: 0.2em 1.5em; margin: 1em 0; }
div#progress { position: fixed; top: 0; left: 0; background: orange; color: black; padding: 0.2em 1em 0.2em 1em; }
.status_table { border: 1px solid #333333; border-collapse: collapse; width: 100%; }
.status_table td { color: #333333; border: 1px solid #444444; padding: 0.4em; }
.status_table td.headline { font-weight: bolder; background-color: #CFCCCC; padding: 0.4em 0.4em 0.3em 1.5em; }
.hidden { display: none !important; }
.{$config['online']} { background-color: #D9FFB3; padding-left: 0.8em !important; }
.{$config['offline']} { background-color: #FFB6B6; padding-left: 0.8em !important; }
-->
</style>
</head>

<body>
<div id="container">
EOH;
	
	// HTML/page footer
	$config['htmlfooter'] = "</div>\n</body>\n</html>";
	
	// Amount of time to cache the script.  0 to disable.
	$config['cachetime'] = 5*60;
	// path to writable directory we can cache in.  Null or false will disable caching.
	$config['cachepath'] = getcwd() .'/files';
	
	// Your support/admin contact address
	$config['contact'] = 'N/A';
	return $config;
}

/**
 * Parse user supplied config
 * @param string Configuration file
 * @param array Configuration defaults
 * @return array Configuration array
 */
function parseConfig($file, $config){
	// including $configfile if available
	if (file_exists($file) && is_readable($file)){
		@include($file);
		foreach($config as $key=>$var){
			if(isset($$key)){
				$config[$key]=$$key;
			}
		}
	}
	
	return $config;
}

/**
 * Generate the default config to simplify instalation.
 * @param string Filename for config
 */
function genConfig(){
	global $config;
	if(file_exists($config['configfile'])){
			die("Config file alread exists!\n");
	}
	$fi=fopen($_SERVER['PHP_SELF'],'r');
	if($fi===false) die("Error opening ".$_SERVER['PHP_SELF']);
	
	$fo=fopen($config['configfile'],'w');
		if($fo===false) die("Error opening config file for writing");
		while(!feof($fi)){
			$line=fgets($fi);
			if($line===false) break;
			fwrite($fo,$line);
		}
		fclose($fi);
		fclose($fo);
		echo "Config file created successfully!\n";
	}