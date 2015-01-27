<?php

/*
Plugin Name: Print Real State
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: PDF printer.
Version: 1.0
Author: Raphael de Almeida
Author URI: http://raphaeldealmeida.net
License: A "Slug" license name e.g. GPL2
*/
if ( ! function_exists( 'add_action' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}
global $blog_id;
if ( ! class_exists( 'WpPrintRealState' ) ) {
	class WpPrintRealState{

		public function __construct(){
			if ( is_admin() ) {


			}else{
				add_filter( 'the_content', array( &$this, 'add_button' ) );
			}
		}

		public function add_button( $content ){
			$button = '<a href="#">My PDF</a>';

			global $post;
			if($post->post_type != 'estate_property')
				return $content;

			$content = '<div>' . $button . '</div>' . $content;
			return $content;
		}
	}
	$wpPrintRealState = new WpPrintRealState();
}


