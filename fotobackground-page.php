<?php
/*
Template Name: Foto Background
*/

?>

<?php get_header(); ?>
<?php
$BGimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full', false );
?>
<style>
	.page-template-residency-page {
			background: url('<?php echo $BGimage[0] ?>') fixed center center rgba(255,255,255,0.85);
	}
</style>



	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

   		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

       			<div class="pinbin-copy container">
							<span>
                <h1><?php the_title(); ?></h1>
           		   <?php the_content(); ?>

                  <?php wp_link_pages(); ?>

					       <?php //comments_template(); ?>
							</span>
         		</div>

       </div>

		<?php endwhile; endif; ?>
    <div id="footerbutton">
      <!--a class="nextpostlink">Load older entries...</a-->
    </div>
<?php get_footer(); ?>
