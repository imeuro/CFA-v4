<?php
/**
 * Single post template
 */

?>
<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

   		<article id="post-<?php the_ID(); ?>" <?php post_class('scroller'); ?>>

        <?php if (!get_field('author_name')) :  // old format ?>
          <small class="date"><?php the_time('F j, Y'); ?></small><br />
          <h1><?php the_title(); ?></h1>
        <?php else :  // new format ?>
          <br /><h1><?php the_title(); ?></h1><br />
          <div class="post-data">
            <small class="author">
            <?php if (get_field('author_link_int')) {
              $authPostID = get_field('author_link_int');
              ?>
              <a href="<?php echo get_permalink($authPostID[0]); ?>" title="View <?php echo get_field('author_name'); ?>'s bio"><?php the_field('author_name'); ?></a>
            <?php } elseif (get_field('author_link_ext')) { ?>
              <a href="http://<?php the_field('author_link_ext'); ?>" title="View <?php echo get_field('author_name'); ?>'s bio"><?php the_field('author_name'); ?></a>
            <?php } else { ?>
              <?php the_field('author_name'); ?>
            <?php } ?>
            </small>
            &nbsp;-&nbsp;
            <small class="time"><?php the_time('F j, Y'); ?></small>
          </div>
        <?php endif; ?>

        <div class="clear"></div>

        <div class="pinbin-copy">
					<?php if (has_excerpt()): ?>
						<div class="container excerpt-container">
							<?php the_excerpt(); ?>
						</div>
					<?php endif; ?>

          <?php the_content('Read more'); ?>

        	<div class="pagelink"><?php wp_link_pages(); ?></div>

        </div>
        	<div class="posttags container"><?php the_tags('<h3>Tags</h3> #', ', #', '<br />'); ?></div>
          <div class="clear"></div>
        	<?php //comments_template(); ?>

       </article>

		<?php endwhile; endif; ?>

<?php get_footer(); ?>
