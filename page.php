<?php
/**
 * Single page template
 */

?>

<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
       
   		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <?php if ( has_post_thumbnail() ) { ?>			
				<div class="pinbin-image"><?php the_post_thumbnail( 'detail-image' );  ?></div>
        <?php } ?>    
             
       			<div class="pinbin-copy container">
                <h1><?php the_title(); ?></h1>
           		   <?php the_content(); ?> 
                
                  <?php wp_link_pages(); ?>
                
					       <?php //comments_template(); ?>
                
         		</div>          
                
       </div>
       
		<?php endwhile; endif; ?>      
    <div id="footerbutton">
      <!--a class="nextpostlink">Load older entries...</a-->
    </div>
<?php get_footer(); ?>
