<?php /*
Template Name: hashcloud
*/ ?>
<?php get_header(); ?>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
       
      <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <?php if ( has_post_thumbnail() ) { ?>      
        <div class="pinbin-image"><?php the_post_thumbnail( 'detail-image' );  ?></div>
        <?php } ?>    
             
            <div class="pinbin-copy hashcloud">
              <div class="container">
                <h1><?php the_title(); ?></h1>
                <?php the_content('Read the rest of this entry »'); ?>
<?php $args = array(
    'smallest'                  => 1.4, 
    'largest'                   => 7,
    'unit'                      => 'rem', 
    'number'                    => 45,  
    'format'                    => 'flat',
    'separator'                 => " ",
    'orderby'                   => 'name', 
    'order'                     => 'RAND',
    'exclude'                   => null, 
    'include'                   => null, 
    'link'                      => 'view', 
    'taxonomy'                  => 'post_tag', 
    'echo'                      => true
); ?>

                <?php wp_tag_cloud($args); ?>
              </div>          
            </div>          
                
       </div>
       
    <?php endwhile; endif; ?>      

<?php get_footer(); ?>
