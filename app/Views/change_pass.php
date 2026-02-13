<!DOCTYPE html>
<html lang="en-US" class="ut-no-js">

<!-- begin head -->
<?php echo view("head"); ?>
<!-- end head -->

<body id="ut-sitebody" class="post-template-default single single-post postid-300 single-format-audio ut-hover-cursor-parent ut-vc-disabled ut-spacing-160 ut-hero-height-100 ut-has-top-header ut-has-page-title has-hero ut-bklyn-multisite ut-header-display-on-hero wpb-js-composer js-comp-ver-5.8 vc_responsive" data-scrolleffect="easeInOutExpo" data-scrollspeed="1300">
	<div id="ut-floating-toTop"></div>
	<a class="ut-offset-anchor" id="top" style="top:0px !important;"></a>
	<!-- begin header -->
	<?php echo view("header2"); ?>
	<!-- end header -->
	<div class="clear"></div>
	<!-- hero section -->
	<!-- end hero section -->
	<div class="clear"></div>
	<div id="main-content" class="wrap ha-waypoint" data-animate-up="ha-header-hide" data-animate-down="ha-header-small">
		<a class="ut-offset-anchor" id="to-main-content"></a>
		<div class="main-content-background clearfix">
			<div class="grid-container">
				<div id="primary" class="grid-parent grid-100 tablet-grid-100 mobile-grid-100" style="margin-top:100px;">
					<div class="prefix-20 grid-60 prefix-20 tablet-grid-60 tablet-prefix-20 mobile-grid-100">
						<div class="comments-area clearfix">
							<div id="respond" class="comment-respond" style="text-align: center;">
								<form name="form-login" action="javascript:void(0);" onsubmit="validate_captcha(1);" method="post" enctype="multipart/form-data" class="account-form">
									<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $obj_customer->id; ?>" />
									<p class="comment-form-author">
									<h2 data-title="<?php echo lang('Global.actualizar_contraseña'); ?>" class="section-title   ut-flowtyped ut-title-loaded" style="font-size: 45px; line-height: 88px !important;">
										<span><?php echo lang('Global.actualizar_contraseña'); ?></span>
									</h2>
									</p>
									<p class="comment-form-author">
										<input type="password" name="password" id="password" required='required' placeholder="<?php echo lang('Global.nueva_contrasena'); ?>" autofocus autocomplete="off" />
									</p>
									<p class="comment-form-author">
										<input type="password" name="new_password" id="new_password" required='required' placeholder="<?php echo lang('Global.confirmar_nueva_contrasena'); ?>" autofocus autocomplete="off" />
									</p>
									<p class="form-submit">
										<button type="submit" id="submit" class="btn btn-block" style="width: 100%;border-radius: 5px;font-size: 16px;"><b><?php echo lang('Global.actualizar_contrasena'); ?></b></button>
									</p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="ut-scroll-up-waypoint" data-section="section-i-want-music"></div>
		</div>

		<footer class="footer ut-footer-custom ut-footer-fullwidth-off"></footer>
		<link href="https://fonts.googleapis.com/css?family=Montserrat:800%2C400%2C500%7CRoboto:500%2C400" rel="stylesheet" property="stylesheet" media="all" type="text/css">
		<link rel='stylesheet' id='vc_google_fonts_montserrat100100italic200200italic300300italicregularitalic500500italic600600italic700700italic800800italic900900italic-css' href='//fonts.googleapis.com/css?family=Montserrat%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2Cregular%2Citalic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&#038;display=swap&#038;ver=5.3.6' type='text/css' media='all' />
		<link rel='stylesheet' id='vc_google_fonts_poppins100100italic200200italic300300italicregularitalic500500italic600600italic700700italic800800italic900900italic-css' href='//fonts.googleapis.com/css?family=Poppins%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2Cregular%2Citalic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&#038;display=swap&#038;ver=5.3.6' type='text/css' media='all' />

		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="https://www.google.com/recaptcha/api.js?render=6LequQIqAAAAAMB6PlUNXRmRAh-TP-uY89l02_4G"></script>
		<script src='<?php echo site_url() . 'assets/front/js/app/recuperar.js'; ?>'></script>

		<script type='text/javascript' src='<?php echo site_url() . "assets/front/js/ut.scplugin.min.js?ver=4.9.2"; ?>'></script>
		<script type='text/javascript' src='<?php echo site_url() . "assets/front/js/anime.min.js?ver=4.9.5"; ?>'></script>
		<script type='text/javascript' src='<?php echo site_url() . "assets/front/js/digital.min.js?ver=4.9.5"; ?>'></script>
		<script type='text/javascript' src='<?php echo site_url() . "assets/front/js/ut-init.min.js?ver=4.9.5"; ?>'></script>
		<script type='text/javascript' src='<?php echo site_url() . "assets/front/js/wp-embed.min.js?ver=5.3.6"; ?>'></script>
		<script type='text/javascript' src='<?php echo site_url() . "assets/front/js/js_composer_front.min.js?ver=5.8"; ?>'></script>
		<script type='text/javascript' src='<?php echo site_url() . "assets/front/js/jquery.utmasonry.min.js?ver=4.8.2"; ?>'></script>
		<script type='text/javascript' src='<?php echo site_url() . "assets/front/js/ut.effects.min.js?ver=4.8.2"; ?>'></script>
</body>

</html>