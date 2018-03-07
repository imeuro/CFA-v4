<?php
/**
 * Error page displayed when no results are found
 */

?>

<?php get_header(); ?>

   		<div class="post type-post type-404"><h2>
				<div class="pinbin-copy container">

					<h1><?php _e( '404: Not Found', 'pinbin') ?></h1>
					<br><br>
					<p>Apologies, the article at the Url you requested is not available.<br>
						You'll be redirected to the home page in 5 seconds.</p>

					<script>
					setTimeout(function(){
						window.location.href = '<?php echo esc_url( home_url( '/' ) ) ?>';
					},5000);
					</script>

					<p><?php _e( 'You might try the following:', 'pinbin') ?></p>
					<ul>
						<li><?php _e( 'Check spelling', 'pinbin') ?></li>
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>/"><?php _e( 'Return to  home page', 'pinbin') ?></a></li>
						<li><?php _e( 'Click ', 'pinbin') ?> <a href="javascript:history.back()"><?php _e( 'Return button', 'pinbin') ?></a></li>
					</ul>

				</div>
      </div>

</div>

<?php get_footer(); ?>
