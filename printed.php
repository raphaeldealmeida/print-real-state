<?php
$gmap_lat =   esc_html( get_post_meta($post->ID, 'property_latitude', true));
$gmap_long =   esc_html( get_post_meta($post->ID, 'property_longitude', true));
$logo_image                     =   esc_html( get_option('wp_estate_logo_image','') );
$telefone                     =   esc_html( get_option('wp_estate_telephone_no','') );
$email                     =   esc_html( get_option('wp_estate_email_adr','') );
$endereco                     =   esc_html( get_option('wp_estate_co_address','') );
$nome                     =   esc_html( get_option('wp_estate_company_name','') );

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title></title>
<style>
		.container .row{
			max-height: 616px;
		}
		div.eight.columns{
			width: 66%;
		}
		.div.info-imovel{
			width: 33%;
		}

		.fotos img{
			margin: 5px;
		}
		.info-imobiliaria img{
			width: 48px;
			height: 48px;
		}
		.info-imovel{
			padding: 10px;

		}
		.info-imovel p{
			font-size: .9em;
			margin-bottom: 3px;
		}
		div {
			border: 1px solid #000000;
		}

		
	</style>
</head>
<body class="container">
	<div class="row">
			<div class="eight columns">
				<div class="row">
					<div class="six columns">
						<div class="planta">
<?php
							$gallery_data = get_post_meta( $post->ID, 'gallery_data', true );

							if ( isset( $gallery_data['image_url'] ) ){
								for( $i = 0; $i < count( $gallery_data['image_url'] ); $i++ ){ ?>
									<img src="<?php esc_html_e( $gallery_data['image_url'][$i] ); ?>" height="150" width="150" />
								<?php
								}
							}
?>
						</div>
						<div class="info-adicionais">
							<h2>Informações Adicionais</h2>

						</div>
					</div>
					<div class="six columns">
						<div class="fotos">
							<?php

							$arguments = array(
								'numberposts' => -1,
								'post_type' => 'attachment',
								'post_parent' => $post->ID,
								'post_status' => null,
								'exclude' => get_post_thumbnail_id(),
								'orderby' => 'menu_order',
								'posts_per_page'   => 1,
								'order' => 'ASC',

							);
							$post_attachments = get_posts($arguments);

							if (has_post_thumbnail()) {
								$thumb_id = get_post_thumbnail_id($post->ID);
								$preview = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_thumb');
								$full_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_full_map');
								$original = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
								print'<img  src="' . $preview[0] . '"  alt="slider-thumb" data-tip="imag" class="current-thumb" data-original="' . $original[0] . '" data-full="' . $full_img[0] . '"/>';
							}

							foreach ($post_attachments as $attachment) {
								$preview = wp_get_attachment_image_src($attachment->ID, 'property_thumb');
								$full_img = wp_get_attachment_image_src($attachment->ID, 'property_full_map');
								$original = wp_get_attachment_image_src($attachment->ID, 'full');
								print '<img  src="' . $preview[0] . '" alt="slider" data-tip="imag" data-original="' . $original[0] . '" data-full="' . $full_img[0] . '"/>';
							}
							?>
						</div>
						<div>
							<img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $gmap_lat?>,<?php echo $gmap_long?>&zoom=14&size=270x200&sensor=false&markers=color:red%7Ccolor:red%7C<?php echo $gmap_lat?>,<?php echo $gmap_long?>">
						</div>
					</div>
					<div class="row">
						<div class ="twelve columns info-imobiliaria">
							<img src="<?php echo $logo_image?>" /> <?php echo $nome?>
							<?php echo $endereco ?>
							<?php echo $telefone ?>
							<?php echo $email ?>
						</div>
					</div>
				</div>
			</div>
			<div class="four columns info-imovel">
				<?php
				$i=0;
				$custom_fields = get_option( 'wp_estate_custom_fields', true);

				if( !empty($custom_fields) ){
					while($i< count($custom_fields) ){
						$name =   $custom_fields[$i][0];
						$label=   $custom_fields[$i][1];
						$type =   $custom_fields[$i][2];
						$slug =   str_replace(' ','_',$name);

						$value=esc_html(get_post_meta($post->ID, $slug, true));
						if (function_exists('icl_translate') ){
							$label     =   icl_translate('wpestate','wp_estate_property_custom_'.$label, $label ) ;
							$value     =   icl_translate('wpestate','wp_estate_property_custom_'.$value, $value ) ;
						}

						if($value!=''){
							print  '<p><span class="title_feature_listing">'.ucwords($label).': </span>'.$value .'</p>';
						}
						$i++;
					}
				}

				?>
			</div>
		</div>

</body>
</html>