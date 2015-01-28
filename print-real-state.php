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
				add_filter( 'wp', array( &$this, 'printer') );
			}
		}

		public function add_button( $content ){
			$button = '<a href="'. add_query_arg( 'print-format', 'print' ) . '">My PDF</a>';

			global $post;
			if($post->post_type != 'estate_property')
				return $content;

			$content = '<div>' . $button . '</div>' . $content;
			return $content;
		}

		public function printer($query){

			global $pdfprnt_options_array, $posts, $post;
			if ( $print  = ( isset( $_GET['print-format'] ) ? $_GET['print-format'] : null ) ) {
				$html = '<div class="container">
								<div class="title"><h1>' . $post->post_title . '</h1></div><br/>
								<div class="content">' . apply_filters( 'the_content', $post->post_content ) . '</div>
							</div>';
				include __DIR__ . '/printed.php';
				unset( $html );
				die();

			}
		}

		function generate_template( $content, $template = false, $isprint = false ) {
			include __DIR__ . '/printed.php';
		}
	}
	$wpPrintRealState = new WpPrintRealState();
}