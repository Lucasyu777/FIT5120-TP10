<?php

if (!class_exists('wpf_widget')) {
	
	class wpf_widget extends WP_Widget {
		
		function __construct() {
			$widget_ops = array(
				'classname' => 'wp_forecast_widget',
				'description' => 'WP Forecast Widget'
			);
			$control_ops = array(
				'width' => 300,
				'height' => 150
			);
			//$this->WP_Widget('wp-forecast', 'WP Forecast',
			
			//		     $widget_ops, $control_ops);
			parent::__construct('wp-forecast', 'WP Forecast', $widget_ops, $control_ops);
		}
		
		function widget($args, $instance) {
			// get widget params from instance
			$title = $instance['title'];
			$wpfcid = $instance['wpfcid'];
			
			if (trim($wpfcid) == "") $wpfcid = "A";
			// pass title to show function
			$args['title'] = $title;
			
			if ($wpfcid == "?") $wpf_vars = get_wpf_opts("A");
			else $wpf_vars = get_wpf_opts($wpfcid);
			
			if (!empty($language_override)) {
				$wpf_vars['wpf_language'] = $language_override;
			}
			show($wpfcid, $args, $wpf_vars);
		}
		
		function update($new_instance, $old_instance) {
			// update semaphor counter for loading wpf ajax script
			
			if ($old_instance['wpfcid'] != $new_instance['wpfcid']) {
				$semnow = get_option('wpf_sem_ajaxload');
				
				if ($new_instance['wpfcid'] == '?') update_option('wpf_sem_ajaxload', $semnow + 1);
				else update_option('wpf_sem_ajaxload', ($semnow - 1 < 0 ? 0 : $semnow - 1));
			}
			return $new_instance;
		}
		
		function form($instance) {
			$count = wpf_get_option('wp-forecast-count');
			// get translation
			$locale = get_locale();
			
			if (empty($locale)) $locale = 'en_US';
			
			if (function_exists('load_plugin_textdomain')) {
				add_filter("plugin_locale", "wpf_lplug", 10, 2);
				load_plugin_textdomain("wp-forecast_" . $locale, false, dirname(plugin_basename(__FILE__)) . "/lang/");
				remove_filter("plugin_locale", "wpf_lplug", 10, 2);
			}
			$title = (isset($instance['title']) ? esc_attr($instance['title']) : "");
			$wpfcid = (isset($instance['wpfcid']) ? esc_attr($instance['wpfcid']) : "");
			// code for widget title form
			$out = "";
			$out.= '<p><label for="' . $this->get_field_id('title') . '" >';
			$out.= __("Title:", "wp-forecast_" . $locale);
			$out.= '<input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></label></p>';
			// print out widget selector
			$out.= '<p><label for ="' . $this->get_field_id('wpfcid') . '" >';
			$out.= __('Available widgets', "wp-forecast_" . $locale);
			$out.= "<select name='" . $this->get_field_name("wpfcid") . "' id='" . $this->get_field_id('wpfcid') . "' size='1' >";
			// option for choose dialog
			$out.= "<option value='?' ";
			
			if ($wpfcid == "?") $out.= " selected='selected' ";
			$out.= ">?</option>";
			
			for ($i = 0;$i < $count;$i++) {
				$id = get_widget_id($i);
				$out.= "<option value='" . $id . "' ";
				
				if ($wpfcid == $id or ($wpfcid == "" and $id == "A")) $out.= " selected='selected' ";
				$out.= ">" . $id . "</option>";
			}
			$out.= "</select></label></p>";
			echo $out;
		}
	}
}