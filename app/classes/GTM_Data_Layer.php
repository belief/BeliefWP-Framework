<?php

class GTM_Data_Layer {
	private $dataLayer = [];
	private $entry;

	public function __construct($entry = null) {
		$this->entry = $entry;
	}

	public function getJSON() {
		$obj = [];
		if ($this->entry === null) {
			$obj = $this->getGTMBasic();
		} else {
			$obj = $this->getGTMData();
		} 		
		return json_encode($obj);
	}

	public function getGTMBasic() {
		$useragent = $_SERVER['HTTP_USER_AGENT'];

		if ( '127.0.0.1' !== $_SERVER['REMOTE_ADDR'] ) {
		  $ip = $this->getUserIP();
		} else {
		  $ip = null;
		}

		$dataLayer = array(
		  "pageLocation" => $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ,
		  "visitorIPAddress" => $ip,
		  "visitorLocation" => $this->visitorInformation("location", $ip),
		  "visitorCountry" => $this->visitorInformation("country", $ip),
		  "VisitorBrowser" => $this->userAgentBrowser($useragent),
		  "VisitorPlatform" => $this->userAgentPlatform($useragent),
		  "VisitorIsOnMobileDevice" =>  $this->isMobile($useragent)
		);
		return $dataLayer;
	}

	public function getGTMData() {
		$entry = $this->entry;
		$dataLayer = $this->getGTMBasic();

		//for reference
		// var_dump($entry); 
		$cat = '';
		$counter = 0;
		foreach ( wp_get_post_categories( $entry->ID ) as $category ) {
			if ($counter > 0) {
				$cat .= ', ';
			}
		    $cat .= get_category($category)->name;
		    $counter++;
		}

		$author = get_the_author_meta('display_name',$entry->post_author);

		$dataLayer2 = array(
		  "EntryTitle" => trim($entry->post_title),
		  "EntryType" => $entry->post_type,
		  "EntryID" => $entry->ID,
		  "EntryAuthor" => trim($author), //add functionality
		  "DisplayDate" => trim($entry->display_date),
		  "EntryGUID" => trim($entry->guid),
		  "EntryCategory" => $cat
		);

		return array_merge($dataLayer, $dataLayer2);
	}

	/**
	 * returns whether current user agent is mobile
	 * @param  string  $useragent user agent php description
	 * @return boolean            whether device is mobile.
	 */
	public function isMobile($useragent) {
    	return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $useragent);
	}

	/**
	 * get the user agent's browser
	 * @param  array $useragent Default useragent from $_SERVER['user_agent']
	 * @return string            user agent information
	 */
	public function userAgentBrowser($useragent) {
	  $data = array();
	  $browser = (isset($_SERVER['HTTP_USER_AGENT'])) ? strtolower($_SERVER['HTTP_USER_AGENT']) : 'unknown';

	  if($browser != 'unknown')
	    {
	    if(strpos($browser, 'lynx') !== false) {
	      $data[] = 'lynx';
	    }
	        elseif(strpos($browser, 'chrome') !== false)
	        {
	          $data[] = 'chrome';
	        }
	        elseif(strpos($browser, 'safari') !== false)
	        {
	          $data[] = 'safari';

	          if(strpos($browser, 'ipod') !== false)
	          {
	            $data[] = 'ipod';
	          }
	          elseif(strpos($browser, 'iphone') !== false)
	          {
	            $data[] = 'iphone';
	          }
	          elseif(strpos($browser, 'ipad') !== false)
	          {
	            $data[] = 'ipad';
	          }
	        }
	        elseif(strpos($browser, 'firefox') !== false)
	        {
	          $data[] = 'firefox';
	        }
	        elseif(strpos($browser, 'gecko') !== false)
	        {
	          $data[] = 'gecko';
	        }
	        elseif(strpos($browser, 'msie') !== false)
	        {
	          if(strpos($browser, 'msie 10') !== false)
	          {
	            $data[] = 'ie10';
	          }
	          elseif(strpos($browser, 'msie 9') !== false)
	          {
	            $data[] = 'ie9';
	          }
	          elseif(strpos($browser, 'msie 8') !== false)
	          {
	            $data[] = 'ie8';
	          }
	          elseif(strpos($browser, 'msie 7') !== false)
	          {
	            $data[] = 'ie7';
	          }
	          elseif(strpos($browser, 'msie 6') !== false)
	          {
	            $data[] = 'ie6';
	          }
	          elseif(strpos($browser, 'msie 5') !== false)
	          {
	            $data[] = 'ie5';
	          }
	          else
	          {
	            $data[] = 'ie';
	          }
	        }
	        elseif(strpos($browser, 'opera') !== false)
	        {
	          $data[] = 'opera';
	        }
	        elseif(strpos($browser, 'nav') !== false && strpos($browser, 'mozilla/4.') !== false)
	        {
	          $data[] = 'navigator';
	        }
	      }

	  return implode(' ', $data);
	}


	/**
	 * Returns the platform from user agent
	 *
	 * @param array $useragent      Default useragent from $_SERVER['user_agent']
	 * @return string               Platform name
	 */
	public function userAgentPlatform($useragent) {
	  $data = array();
	  $platform = (isset($_SERVER['HTTP_USER_AGENT'])) ? strtolower($_SERVER['HTTP_USER_AGENT']) : 'unknown';

	  // Some platform detection
	  if($platform != 'unknown')
	  {
	    if (strpos($platform, 'win') !== false)
	    {
	      $data[] = 'win';
	    }
	    elseif(strpos($platform, 'mac') !== false)
	    {
	      $data[] = 'mac';
	    }
	  } else {
	    $data = 'unknown';
	  }

	  return implode(' ', $data);
	}

	/**
	 * User visitor information based on GeoIP
	 *
	 * @param string $type          Type of information wanted back
	 * @param string $ip            Visitor IP Address
	 * @return string               Visitor Information
	 */
	public function visitorInformation($type ,$ip) {
	  if ( $ip == null ) {
	    return null;
	  }

	  $data = '';
	  if ( function_exists('geoip_record_by_name') ) {

	    switch($type) {
	      case 'location':
	        $loc = geoip_record_by_name($ip);
	        $data = $loc['city'];
	        break;
	      case 'country':
	        $loc = geoip_record_by_name($ip);
	        $data = $loc['country_name'];
	        break;
	      default:
	        $data = 'no type given';
	        break;
	    }
	  } else {
	    $data = 'server not configured';
	  }
	  return $data;
	}

	// Get Visitors IP (still not 100%)
	public function getUserIP() {
	    $client  = @$_SERVER['HTTP_CLIENT_IP'];
	    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	    $remote  = $_SERVER['REMOTE_ADDR'];

	    if(filter_var($client, FILTER_VALIDATE_IP))
	    {
	        $ip = $client;
	    }
	    elseif(filter_var($forward, FILTER_VALIDATE_IP))
	    {
	        $ip = $forward;
	    }
	    else
	    {
	        $ip = $remote;
	    }

	    return $ip;
	}

}

function GTMBasic($obj = null) {
	$GTM = new GTM_Data_Layer($obj);
	return $GTM->getJSON();
}