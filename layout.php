<?php
$gmap_lat =   esc_html( get_post_meta($post->ID, 'property_latitude', true));
$gmap_long =   esc_html( get_post_meta($post->ID, 'property_longitude', true));
$logo_image                     =   esc_html( get_option('wp_estate_logo_image','') );
$telefone                     =   esc_html( get_option('wp_estate_telephone_no','') );
$email                     =   esc_html( get_option('wp_estate_email_adr','') );
$endereco                     =   esc_html( get_option('wp_estate_co_address','') );
$nome                     =   esc_html( get_option('wp_estate_company_name','') );
$feature_list_array             =   array();
$feature_list                   =   esc_html( get_option('wp_estate_feature_list') );
$feature_list_array             =   explode( ',',$feature_list);
?>
<html>
<head>
	<style>
		td{

			padding: 5px;
			/*border: 0.1mm solid #00cc18;*/

		}
	table{
		/*border: 0.1mm solid red;*/
		border-collapse: collapse;
	}

	table.content{
		border: 0.1mm solid gray;
	}

	table.col1{
		border-right: 0.1mm solid gray;

	}

	table.col3{
		border-left: 0.1mm solid white;
	}

	table.col4{
		margin-top: 10mm;
		border-top: 0.1mm solid gray;
		width: 200mm;
	}


	td#info-imovel{
		vertical-align: top;
		padding: 5mm;

	}
	td#info-adicionais{
		vertical-align: top;
		padding: 5mm;
	}
	td#fotos{
		padding-top: 5mm;
		border-bottom: 0.1mm solid gray;
	}
	td#mapa{
		padding-top: 5mm;
	}
	td.planta{
		/*border-top: 0.1mm solid gray;*/

	}

	td#nome-imovel{
		padding: 10mm auto 10mm auto;
		/*font-family: "comic sans ms", verdana, arial, tahoma, "sans serif";*/
	}
	</style>
</head>
<body>
	<table  width="100%"  class="content">
		<tr>
			<td width="66%" style="vertical-align: top;">
				<table>
					<tr>
						<td>
							<table class="col1">
								<tr>
									<td id="nome-imovel" width="50%" align="center" >
										<h1><?php echo get_the_title($post->ID)?></h1>

									</td>
								</tr>
								<tr>
									<td class="planta" align="center">
										<hr style="border: solid 0.1mm gray">
										<h3 align="center">Planta do Apartamento</h3>
										<br>
										<?php
										$gallery_data = get_post_meta( $post->ID, 'gallery_data', true );

										if ( isset( $gallery_data['image_url'] ) ){
											for( $i = 0; $i < count( $gallery_data['image_url'] ); $i++ ){ ?>
												<img src="<?php esc_html_e( $gallery_data['image_url'][0] ); ?>" height="310" width="310" />
											<?php
											}
										}else{ ?>
											<img src="<?php echo plugins_url('images/planta_indisponivel.gif', __FILE__)?>">
										<?php	}
										?>

									</td>
								</tr>
							</table>
						</td>
						<td style="vertical-align: top;">
							<table>
								<tr>
									<td id="fotos" width="50%" align="center">
										<h3>Fotos</h3><br>
										<?php

										$arguments = array(
											'numberposts' => -1,
											'post_type' => 'attachment',
											'post_parent' => $post->ID,
											'post_status' => null,
											'exclude' => get_post_thumbnail_id(),
											'orderby' => 'menu_order',
											'posts_per_page'   => 4,
											'order' => 'ASC',

										);
										$post_attachments = get_posts($arguments);
										foreach ($post_attachments as $attachment) {
											$preview = wp_get_attachment_image_src($attachment->ID, array(136, 200));
											$full_img = wp_get_attachment_image_src($attachment->ID, 'property_full_map');
											$original = wp_get_attachment_image_src($attachment->ID, 'full');
											print '<img style="margin: 1mm"  src="' . $preview[0] . '" alt="slider" data-tip="imag" data-original="' . $original[0] . '" data-full="' . $full_img[0] . '"/>';
										}
										?>
									</td>
								</tr>
								<tr>
									<td id="mapa" align="center">
										<h3>Mapa</h3><br><br>
										<?php if($gmap_lat == "" || $gmap_long == ""):?>
											<img src="<?php echo plugins_url('images/indisponivel.jpg', __FILE__)?>">
										<?php else: ?>
											<img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $gmap_lat?>,<?php echo $gmap_long?>&zoom=14&size=335x200&sensor=false&markers=color:red%7Ccolor:red%7C<?php echo $gmap_lat?>,<?php echo $gmap_long?>">
										<?php endif;?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2" width="100%" id="info-imobiliaria">
							<table class="col4" >
								<tr>
									<td align="center">
										<img src="<?php echo $logo_image?>" width="90px" height="90px"/>
									</td>
									<td >
										<?php echo $nome?> <br>
										<?php echo $endereco ?> <br>
										Telefone: <?php echo $telefone ?> | E-mai <?php echo $email ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
			<td width="33%" style="vertical-align: top;	border-left: 0.1mm solid gray;">
				<table width="100mm" class="col3">
					<tr>
						<td id="info-imovel">
							<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Informações do Imóvel</h3>
							<br>
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
										print  '<p><strong>'.ucwords($label).': </strong>'.$value .'</p>';
									}
									$i++;
								}
							}

							?>
						</td>
					</tr>
					<tr>
						<td id="info-adicionais" style="vertical-align: top;border-top: 0.1mm solid gray;" >
							<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Informações Adicionais</h3>
							<?php
							$show_no_features= esc_html ( get_option('wp_estate_show_no_features','') );

							foreach($feature_list_array as $checker => $value){
								$post_var_name=  str_replace(' ','_', trim($value) );

								if (esc_html( get_post_meta($post->ID, $post_var_name, true) ) == 1) {
									print '<div class="features_listing_div">' . trim($value) . '</div>';
								}
							}
							?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>