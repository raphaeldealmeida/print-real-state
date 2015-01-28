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
				<div class="planta"></div>
				<div class="info-adicionais"></div>
			</div>
			<div class="columns-2">
				<div class="fotos"></div>
				<div class="gmap_wrapper" id="gmap_wrapper" data-post_id="<?php echo $post->ID;?>" data-cur_lat="<?php echo $gmap_lat;?>" data-cur_long="<?php echo $gmap_long;?>">
					<div id="googleMap">
					</div>

				</div>
			</div>
			<div class ="info-imobiliaria"></div>
		</div>
		<div class="coluns-2"></div>
	</div>
</body>
</html>