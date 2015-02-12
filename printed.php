<?php
echo $gmap_lat =   esc_html( get_post_meta($post->ID, 'property_latitude', true));
echo $gmap_long =   esc_html( get_post_meta($post->ID, 'property_longitude', true));

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title></title>
</head>
<body>
	<div>
		<div class="coluns-1">
			<div class="columns-1">
				<div class="planta">PLANTA DO APARTAMENTO</div>
				<div class="info-adicionais">INFORMAÇÔES ADICIONAIS</div>
			</div>
			<div class="columns-2">
				<div class="fotos">
					FOTOS

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
				<div class="gmap_wrapper" id="gmap_wrapper" data-post_id="<?php echo $post->ID;?>" data-cur_lat="<?php echo $gmap_lat;?>" data-cur_long="<?php echo $gmap_long;?>">
					MAPA
					<div id="googleMap">
					</div>

				</div>
			</div>
			<div class ="info-imobiliaria">
				INFORMAÇÔES BÁSICAS DA IMOBILIÁRIA
				<img src="<?php echo $logo_image?>" />
			</div>
		</div>
		<div class="coluns-2">
			<h2>Lista de informações sobre o imóvel</h2>
		</div>
	</div>
</body>
</html>