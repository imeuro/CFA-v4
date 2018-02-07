<?php
/**
 * Single post template
 */

?>
<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>     
       
   		<div id="post-<?php the_ID(); ?>" <?php post_class('scroller'); ?>>
          
        <div class="clear"></div>

        <div class="pinbin-copy">

          <?php the_post_thumbnail(array( 180, 120 ),array( 'class' => 'alignleft author-pic' )); ?> 

          <h1 class="text-left"><?php the_title(); ?></h1>

          <?php the_content('Read more'); ?> 

        </div>
        	<div class="posttags container"><?php the_tags('<h3>Tags</h3> #', ', #', '<br />'); ?></div>
          <div class="clear"></div>
        	<?php //comments_template(); ?> 
          
       </div>
       
		<?php endwhile; endif; ?>

<?php get_footer(); ?>


