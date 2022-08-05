<?php
/* This file is part of the wp-forecast plugin for wordpress */

/*  Copyright 2021  Hans Matzen  (email : webmaster at tuxlog dot de)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
if (!function_exists('openweathermap_get_weather')) {
	
	function openweathermap_get_weather($baseuri, $apikey, $lat, $lon, $metric) {
		
		if ($metric=="1") 
			$metric="metric";
		else 
			$metric="imperial";
		
		// check parms
		if ( trim($apikey) == "" or trim($lat) == "" or trim($lon)=="" ) return array();
		$url1 = $baseuri . 'lat=' . $lat . '&lon=' . $lon . '&appid=' . $apikey . '&exclude=minutely,hourly&units=' . $metric . '&lang=en';
		// Open the file and decode it 
		$file1 = file_get_contents($url1, false);
		$data  = json_decode($file1, true);

		return $data;
	}
}


if (!function_exists('openweathermap_get_data')) {
	
	function openweathermap_get_data($weather_array, $wpf_vars) {
		$w = array();
		
		if ($wpf_vars['metric'] == "1") {
			$w['un_temp']  = 'C';
			$w['un_dist']  = 'km';
			$w['un_speed'] = 'm/s';
			$w['un_pres']  = 'mb';
			$w['un_prec']  = 'mm';
		} else {
			$w['un_temp']  = 'F';
			$w['un_dist']  = 'mi';
			$w['un_speed'] = 'mph';
			$w['un_pres']  = 'mb';
			$w['un_prec']  = 'in';
		}
		
		if ( !isset($weather_array['current']) or !isset($weather_array['daily']) ) {
			$w['failure'] = "No OpenWeathermap data available";
			return $w;
		}
		
		$w['lat'] = $weather_array['lat'];
		$w['lon'] = $weather_array['lon'];
		$w['time'] = $weather_array['current']['dt'];
		$w['timezone'] = $weather_array['timezone'];
		$mtz = new DateTimeZone($w['timezone']);
				
		// current conditions
		$w['pressure']      = $weather_array['current']['pressure'];
		$w['temperature']   = round( $weather_array['current']['temp'], 0);
		$w['realfeel']      = round($weather_array['current']['feels_like'], 0);
		$w['humidity']      = $weather_array['current']['humidity'];
		$w['weathertext']   = $weather_array['current']['weather'][0]['description'];
		$w['weathericon']   = $weather_array['current']['weather'][0]['icon'];
		$w['weatherid']     = $weather_array['current']['weather'][0]['id'];
		$w['wgusts']        = $weather_array['daily'][0]['wind_gust'];
		$w['windspeed']     = $weather_array['current']['wind_speed'];
		$w['winddirection'] = $weather_array['current']['wind_deg'];
		$w['uvindex']       = $weather_array['current']['uvi'];

		// map precipitation values
		// init vars
		$w['precipProbability'] = 0;
		$w['precipIntensity'] = 0;
		$w['precipType'] = "";
		// if it rains add rain volume and set precipitation type to rain
		if ( isset( $weather_array['current']['rain'] ) ) {
			$w['precipIntensity'] += $weather_array['current']['rain']['1h'];
			$w['precipType'] = 'Rain';
		}
		// if it snows add snow volume and set precipitation type to snow
		if ( isset( $weather_array['current']['snow'] ) ) {
			$w['precipIntensity'] += $weather_array['current']['snow']['1h'];
			$w['precipType'] = 'Snow';
		}
		// convert mm to inches for compatibility reasons with darksky and accuweather
		$w['precipIntensity'] = $w['precipIntensity'] / 2.54 / 10;
			
		if  ($w['precipIntensity'] > 0) 
			$w['precipProbability'] = 100;
		
		// sunset sunrise
		$sr = new DateTime();
		$sr->setTimezone($mtz);
		$sr->setTimestamp($weather_array['daily']['0']['sunrise']);
		$w['sunrise'] = $sr->format("H:i");
		
		$ss = new DateTime();
		$ss->setTimezone($mtz);
		$ss->setTimestamp($weather_array['daily']['0']['sunset']);
		$w['sunset'] = $ss->format("H:i");
		
		// forecast
		for($i=0;$i<=7;$i++) {
					
			$j = $i + 1;
			$odt = new DateTime();
			$odt->setTimezone($mtz);
						
			$w['fc_obsdate_'.$j]      = $weather_array['daily'][$i]['dt'] + $odt->getOffset();
			$w['fc_dt_short_'.$j]     = $weather_array['daily'][$i]['weather'][0]['description'];
			$w['fc_dt_icon_'.$j]      = $weather_array['daily'][$i]['weather'][0]['icon'];
			$w['fc_dt_id_'.$j]        = $weather_array['daily'][$i]['weather'][0]['id'];
			$w['fc_dt_htemp_'.$j]     = round( $weather_array['daily'][$i]['temp']['day'], 0);
			$w['fc_dt_ltemp_'.$j]     = round( $weather_array['daily'][$i]['temp']['day'], 0);
			$w['fc_dt_windspeed_'.$j] = $weather_array['daily'][$i]['wind_speed'];
			$w['fc_dt_winddir_'.$j]   = $weather_array['daily'][$i]['wind_deg'];
			$w['fc_dt_wgusts_'.$j]    = $weather_array['daily'][$i]['wind_gust'];
			$w['fc_dt_maxuv_'.$j]     = $weather_array['daily'][$i]['uvi'];
			$w['fc_nt_icon_'.$j]      = $weather_array['daily'][$i]['weather'][0]['icon'];
			$w['fc_nt_id_'.$j]        = $weather_array['daily'][$i]['weather'][0]['id'];
			$w['fc_nt_htemp_'.$j]     = round( $weather_array['daily'][$i]['temp']['night'], 0);
			$w['fc_nt_ltemp_'.$j]     = round( $weather_array['daily'][$i]['temp']['night'], 0);
			$w['fc_nt_windspeed_'.$j] = $weather_array['daily'][$i]['wind_speed'];
			$w['fc_nt_winddir_'.$j]   = $weather_array['daily'][$i]['wind_deg'];
			$w['fc_nt_wgusts_'.$j]    = $weather_array['daily'][$i]['wind_gust'];
			$w['fc_nt_maxuv_'.$j]     = $weather_array['daily'][$i]['uvi'];
			
			// map precipitation values
			// init vars
			$w['fc_dt_precipProbability' . $j] = $weather_array['daily'][$i]['pop'] * 100;
			$w['fc_dt_precipIntensity' . $j] = 0;
			$w['fc_dt_precipType' . $j] = "";
			// if it rains add rain volume and set precipitation type to rain
			if ( isset( $weather_array['daily'][$i]['rain'] ) ) {
				$w['fc_dt_precipIntensity' . $j] += $weather_array['daily'][$i]['rain'];
				$w['fc_dt_precipType' . $j] = 'Rain';
			}
			// if it snows add snow volume and set precipitation type to snow
			if ( isset( $weather_array['daily'][$i]['snow'] ) ) {
				$w['fc_dt_precipIntensity' . $j] += $weather_array['daily'][$i]['snow'];
				$w['fc_dt_precipType' . $j] = 'Snow';
			}
			
			// convert mm to inches for compatibility reasons with darksky and accuweather
			$w['fc_dt_precipIntensity' . $j] = $w['fc_dt_precipIntensity' . $j] / 2.54 / 10;
			//error_log($i ." " . $w['fc_obsdate_'.$j]. " " .date_i18n("j. F Y G:i", $w['fc_obsdate_'.$j] ));
		}
		
		// fill failure anyway
		$w['failure']=( isset($w['failure']) ? $w['failure'] : '');
		
		return $w;
	}
}

if (!function_exists('openweathermap_map_icon')) {
	function openweathermap_map_icon($weatherid, $night=false) {
		/* icon mapping from darksky */
		/* $ico_arr = array(
				'clear-day' 			=> '01', 
				'clear-night' 			=> '33', 
				'rain' 					=> '12',
				'snow' 					=> '22', 
				'sleet' 				=> '29', 
				'wind' 					=> '32', 
				'fog' 					=> '11', 
				'cloudy' 				=> '06',
				'partly-cloudy-day' 	=> '04', 
				'partly-cloudy-night' 	=> '38',
				'hail'					=> '25', 
				'thunderstorm'			=> '15', 
				'tornado'				=> '32',
		); */
		
		$icon ='01';
		
		/* thunderstorm */
		if ( $weatherid >= 200 && $weatherid <= 232 ) $icon = '15';
		/* rain */
		if ( $weatherid >= 500 && $weatherid <= 531 ) $icon = '12';
		if ( $weatherid >= 300 && $weatherid <= 321 ) $icon = '12';
		/* snow , sleet*/
		if ( $weatherid >= 600 && $weatherid <= 622 ) $icon = '22';
		if ( $weatherid == 611 ) $icon = '29';
		/* tornado */
		if ( $weatherid == 781 ) $icon = '32';
		/* fog */
		if ( $weatherid == 741 ) $icon = '11';
		/* clear sky */
		if ( $weatherid == 800 && $night === false ) $icon = '01';
		if ( $weatherid == 800 && $night === true )  $icon = '33';

		/* partl cloudy */
		if ( $weatherid >= 801 && $weatherid <= 803 && $night === false ) $icon = '04';
		if ( $weatherid >= 801 && $weatherid <= 803 && $night === true )  $icon = '38';
		if ( $weatherid == 804 ) $icon = '06';

		return $icon;
	}
}
if (!function_exists('openweathermap_forecast_data')) {
	function openweathermap_forecast_data($wpfcid="A", $language_override=null) {
	
		$wpf_vars=get_wpf_opts($wpfcid);
		if (!empty($language_override)) {
			$wpf_vars['wpf_language']=$language_override;
		} 

		extract($wpf_vars);
		$w=maybe_unserialize(wpf_get_option("wp-forecast-cache".$wpfcid));

		// get translations
		if (function_exists('load_plugin_textdomain')) {
			add_filter("plugin_locale","wpf_lplug",10,2);
			load_plugin_textdomain("wp-forecast_".$wpf_language, false, dirname( plugin_basename( __FILE__ ) ) . "/lang/");
			remove_filter("plugin_locale","wpf_lplug",10,2);
		}
    
		// --------------------------------------------------------------
		// calc values for current conditions
		if ( isset($w['failure']) && $w['failure'] != '') return array('failure' => $w['failure']);
	
		$w['servicelink']= 'https://openweathermap.org/weathermap?basemap=map&cities=true&layer=temperature&lat=' . $w['lat'] . "&lon=" . $w['lon'] . '&zoom=5';
		$w['copyright']='<a href="https://openweathermap.org">&copy; '.date("Y").' Powered by OpenWeather</a>';
	
		// next line is for compatibility
		$w['acculink']=$w['servicelink'];
		$w['location'] = $wpf_vars['locname'];
		$w['locname']= $w["location"];
    
    	$tz = new DateTimeZone($w['timezone']);
		$w['gmtdiff'] = $tz->getOffset( new DateTime() );
	
		$ct = current_time("U");
		$ct = $ct + $wpf_vars['timeoffset'] * 60; // add or subtract time offset
    		
		$w['blogdate']=date_i18n($fc_date_format, $ct);
		$w['blogtime']=date_i18n($fc_time_format, $ct);
    
		// get date/time from openweathermap
		$ct = $w['time'] + $w['gmtdiff'];
		$w['accudate']=date_i18n($fc_date_format, $ct);
		$w['accutime']=date_i18n($fc_time_format, $ct);
         
        
        $ico = openweathermap_map_icon( $w["weatherid"], false);
		$iconfile=find_icon($ico);
		$w['icon']="icons/".$iconfile;
		$w['iconcode']=$ico;
		$w['shorttext'] = __($ico, "wp-forecast_".$wpf_language);

		$w['temperature'] = $w["temperature"]. "&deg;".$w['un_temp'];
		$w['realfeel'] = $w["realfeel"]."&deg;".$w['un_temp'];
		$w['humidity'] = round($w['humidity'], 0);

		// workaround different pressure values returned by accuweather
		$press = round($w["pressure"],0);
		if (strlen($press)==3 and substr($press,0,1)=="1")
			$press = $press * 10;
		$w['pressure'] = $press . " " . $w["un_pres"];
		$w['humidity']=round($w["humidity"],0);
		$w['windspeed']=windstr($metric,$w["windspeed"],$windunit);
		$w['winddir']=translate_winddir_degree($w["winddirection"],"wp-forecast_".$wpf_language);
		$w['winddir_orig']=str_replace('O','E',$w["winddir"]);
		$w['windgusts']=windstr($metric,$w["wgusts"],$windunit);
	
    
    
		// calc values for forecast
		for ($i = 1; $i < 8; $i++) {
			// daytime forecast
			$w['fc_obsdate_'.$i]= date_i18n($fc_date_format, $w['fc_obsdate_'.$i]);
			
			$ico = openweathermap_map_icon( $w["fc_dt_id_".$i], false);
			$iconfile=find_icon($ico);
			$w["fc_dt_icon_".$i]="icons/".$iconfile;
			$w["fc_dt_iconcode_".$i]=$ico;
			$w["fc_dt_desc_".$i]= __($ico,"wp-forecast_".$wpf_language);
			$w["fc_dt_htemp_".$i]= $w["fc_dt_htemp_".$i]."&deg;".$w['un_temp'];
			$wstr=windstr($metric,$w["fc_dt_windspeed_".$i],$windunit);
			$w["fc_dt_windspeed_".$i]= $wstr;
			$w["fc_dt_winddir_".$i]=translate_winddir_degree($w["fc_dt_winddir_".$i],"wp-forecast_".$wpf_language);
			$w["fc_dt_winddir_orig_".$i]=str_replace('O','E',$w["fc_dt_winddir_".$i]);
			$w["fc_dt_wgusts_".$i] = windstr($metric,$w["fc_dt_wgusts_".$i],$windunit);
			$w['fc_dt_maxuv_'.$i]=$w['fc_dt_maxuv_'.$i];
     
			// nighttime forecast
			$ico = openweathermap_map_icon( $w["fc_nt_id_".$i], true);
			$iconfile=find_icon($ico);
			$w["fc_nt_icon_".$i]="icons/".$iconfile;
			$w["fc_nt_iconcode_".$i]=$ico;
			$w["fc_nt_desc_".$i]= __($ico,"wp-forecast_".$wpf_language);
			$w["fc_nt_ltemp_".$i]= $w["fc_nt_ltemp_".$i]."&deg;".$w['un_temp'];
			$wstr=windstr($metric,$w["fc_nt_windspeed_".$i],$windunit);
			$w["fc_nt_windspeed_".$i]= $wstr;
			$w["fc_nt_winddir_".$i]=translate_winddir_degree($w["fc_nt_winddir_".$i],"wp-forecast_".$wpf_language);
			$w["fc_nt_winddir_orig_".$i]=str_replace('O','E',$w["fc_nt_winddir_".$i]);
			$w["fc_nt_wgusts_".$i] = windstr($metric,$w["fc_nt_wgusts_".$i],$windunit);
			$w['fc_nt_maxuv_'.$i]=$w['fc_nt_maxuv_'.$i];      
		}
		
		return $w;	
	}
}
