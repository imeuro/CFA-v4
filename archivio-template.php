<?php /*
Template Name: archivio
*/ ?>

<?php get_header(); ?>
<?php
// List Pages by Month/Day
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
  'paged' => $paged,
 'post_type' => 'post',
 'posts_per_page' => 75,
             );
query_posts($args);
?>  

<?php if (have_posts()) : ?>
<div id="archivio" class="container">
<h1>Timetable</h1>
<?php if ($paged > 1) : ?>
  <small>page <?php echo $paged ?></small>
<?php endif; ?>
<div class="archive-month-container">
<?php 
$counter = 0;
$cur_date = '';
while (have_posts()) : the_post();   

    $prev_date = $cur_date;
    // echo $prev_date.'lll';
    $cur_date = get_the_time('F Y');
    if($cur_date!=$prev_date): echo '</div><br class="defloater" /><h2 class="archive-date">'.$cur_date.'</h2><br class="defloater" /><div class="archive-month-container">'; endif;
?>

    
     <?php $attachments = get_children(array('post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order'));
        if ($attachments) {
              if ( ! is_array($attachments) ) continue;
              $count = count($attachments);
              $first_attachment = array_shift($attachments);
              ?>
        <article id="archive-<?php the_ID(); ?>" <?php post_class('archivio left'); ?>>
          <div class="thumb-archivio">
            <a href="<?php the_permalink(); ?>" class="left">
              <?php $imgsrc = wp_get_attachment_image_src($first_attachment->ID, 'thumbnail'); 
              //print_r($imgsrc); 
              //160:$imgsrc[1]=x:$imgsrc[2]
              $thumheight = ($imgsrc[2]*160)/$imgsrc[1];
              ?>
              <h3><a href="<?php the_permalink(); ?>" class="left"><?php echo get_the_title(); ?></a></h3>
              <img src="<?php bloginfo('template_directory') ?>/images/blank.png" data-src="<?php echo $imgsrc[0]; ?>" class="unveil" width="160" height="<?php echo $thumheight; ?>" alt="<?php the_title() ?>" />
            </a>
          </div>
        </article>
          <?php } else { /*text post*/ } ?>

<?php  endwhile; ?>

</div>
</div>

<?php endif; ?>
    <nav id="archive-nav-below" class="navigation" role="navigation">
        <div class="view-previous"><?php next_posts_link( __( '&#171; Previous Months', 'pinbin' ) ) ?></div>
        <div class="view-next"><?php previous_posts_link( __( 'Next Months &#187;', 'pinbin' ) ) ?> </div>
    </nav>
<br /><br /><br /><br />
<?php get_footer(); ?>
