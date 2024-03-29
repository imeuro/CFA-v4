<!DOCTYPE html>
<html <?php language_attributes();?>>

  <head>
      <!-- Google Tag Manager -->
      <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-5MLKFBX');</script>
      <!-- End Google Tag Manager -->
    	<meta charset="<?php bloginfo('charset'); ?>" />
      <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
      <!--meta name="keywords" content="a list, of keywords, separated, by commas"-->
      <meta name="description" content="<?php
        if ( is_home() ) : bloginfo('description');
        else :
          global $post;
          setup_postdata( $post );
          $post_desc = get_the_excerpt();
          //$post_desc = substr($post_desc, 7);  // toglie "&nbsp; " all'inizio
          $post_desc = str_replace('&nbsp; ','',$post_desc);
          echo $post_desc;
        endif;
      ?>">
      <meta name="language" content="EN">
      <title><?php wp_title('&#124;', true, 'right'); ?></title>
      <link href="http://www.conceptualfinearts.com/cfa/favicon.ico" rel="shortcut icon" type="image/x-icon" />
      <link rel="profile" href="http://gmpg.org/xfn/11" />
      <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
      <?php wp_head(); ?>
      <?php if ($_GET["print"]=="enabled") : ?>
        <script>window.self.print();</script>
      <?php endif; ?>
  </head>

  <body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5MLKFBX"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="whitecurtain"></div>

<div id="blackcurtain">

  <div id="menu-coldx" class="hidden">
    <div class="fullcol">
      <span>
        <?php
        $menu = get_post( 8058 );
        $title = $menu->post_title;
        $content =  apply_filters('the_content',$menu->post_content);
        $Menu_BGimage = wp_get_attachment_image_src( get_post_thumbnail_id( $menu->ID ), 'large', false );
        ?>
        <?php echo $content; ?>
      </span>
    </div>
    <div class="fullcol">
      <span class="text-center">

        <h3><a href="<?php echo get_permalink( get_page_by_path( 'newsletter' ) ).'#menu'; ?>" title="NEWSLETTER">NEWSLETTER</a></h3>

        <h3 class="clickable"><a class="search_menu GTMtrack">SEARCH</a></h3>
        <div class="search_submenu submenu hidden"><?php get_search_form(); ?></div>

        <h3><a href="<?php echo get_permalink( get_page_by_path( 'hashcloud' ) ).'#menu'; ?>" title="A-Z index">A-Z INDEX</a></h3>

        <h3><a href="<?php echo get_permalink( get_page_by_path( 'archive' ) ).'#menu'; ?>" title="Timetable">TIMETABLE</a></h3>
      </span>
    </div>

  </div>
  <div id="about-coldx" class="hidden">
    <div class="fullcol">
      <span>
        <?php
        $about_us = get_post( 1 );
				//print_r($about_us);
        $title = $about_us->post_title;
        $content =  apply_filters('the_content',$about_us->post_content);
        $About_BGimage = wp_get_attachment_image_src( get_post_thumbnail_id( $about_us->ID ), 'large', false );
        ?>
        <?php echo $content; ?>
      </span>
    </div>
  </div>

  <div id="patrons-coldx" class="hidden">
    <div class="fullcol">
      <span>
        <?php
        $patrons = get_post( 7701 );
        $title = $patrons->post_title;
        $content = $patrons->post_content;
        $Patrons_BGimage = wp_get_attachment_image_src( get_post_thumbnail_id( $patrons->ID ), 'large', false );
        ?>
        <p><?php echo $content; ?></p>
      </span>
    </div>
  </div>


  <div id="residency-coldx" class="hidden">
    <div class="fullcol">
			<span>
	    <?php
	    $residency = get_post( 12830 );
	    $title = $residency->post_title;
	    $content =  apply_filters('the_content',$residency->post_content);
	    $Residency_BGimage = wp_get_attachment_image_src( get_post_thumbnail_id( $residency->ID ), 'large', false );
	    ?>
      <?php echo $content; ?>
			</span>
    </div>
  </div>

	<style>
    #blackcurtain.menu.show {
        background: url('<?php echo $Menu_BGimage[0] ?>') no-repeat center center rgba(255,255,255,0.85);
        background-size: cover;
    }
    #blackcurtain.about.show {
        background: url('<?php echo $About_BGimage[0] ?>') no-repeat center center rgba(255,255,255,0.85);
        background-size: cover;
    }
		#blackcurtain.patrons.show {
				background: url('<?php echo $Patrons_BGimage[0] ?>') no-repeat center center rgba(255,255,255,0.85);
				background-size: cover;
		}
		#blackcurtain.residency.show {
				background: url('<?php echo $Residency_BGimage[0] ?>') no-repeat center center rgba(255,255,255,0.85);
				background-size: cover;
		}
	</style>

</div>

 	<!-- logo and navigation -->
 <nav id="site-navigation">
 <?php
 	function printLangSwitcher($format='normal') {
 		if ( class_exists( 'WPGlobus' ) ) {

			if ($format == 'compact') {
				//print_r(WPGlobus::Config());
				foreach( WPGlobus::Config()->enabled_languages as $lang ) {
					if ( $lang == WPGlobus::Config()->language ) {
						echo  "<span>".$lang."</span>";
						continue;
					}
					echo ' <a href="' . WPGlobus_Utils::localize_current_url( $lang ). '">' . $lang . '</a>';
				}
			} else {
				echo 'switch language:<br>';
				foreach( WPGlobus::Config()->enabled_languages as $lang ) {
					if ( $lang == WPGlobus::Config()->language ) {
						echo  " ".WPGlobus::Config()->language_name[$lang];
						continue;
					}
					echo ' <a href="' . WPGlobus_Utils::localize_current_url( $lang ). '">' . WPGlobus::Config()->language_name[$lang] . '</a>';

				}
			}

		}
	}
?>
    <div id="main-nav-wrapper" class="<?php if (!is_home() || !is_front_page()) : echo 'single '; endif; ?>left on">

        <div id="logo">
					<?php //include(get_stylesheet_directory().'/images/logo-CFA.svg'); ?>
        </div>

    </div>

		<div id="menu_handle" class="mobile">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
					<g fill="#F5A32F" fill-rule="evenodd">
						<path class="x" d="m0 16h32v2h-32v-1"></path>
						<path class="y" d="m0 16h32v2h-32v-1"></path>
						<path class="a" d="m0 26h32v2h-32v-1"></path>
						<path class="b" d="m0 6h32v2h-32v-1"></path>
					</g>
        </svg>
		</div>
		<div id="lang-switcher"><?php printLangSwitcher('compact'); ?></div>
		<div id="menu-pad">
			<ul>
				<li id="menu-btn" class="menurev2 GTMtrack" data-menu="menu" data-url="<?php echo get_permalink($menu->ID); ?>"><?php echo $menu->post_title; ?></li>
				<li id="about-btn" class="menurev2 GTMtrack" data-menu="about" data-url="<?php echo get_permalink($about_us->ID); ?>"><?php echo $about_us->post_title; ?></li>
				<li id="patrons-btn" class="menurev2 GTMtrack" data-menu="patrons" data-url="<?php echo get_permalink($patrons->ID); ?>"><?php echo $patrons->post_title; ?></li>
				<li id="residency-btn" class="menurev2 GTMtrack" data-menu="residency" data-url="<?php echo get_permalink($residency->ID); ?>"><?php echo $residency->post_title; ?></li>
				<li id="lang-switch" class="menurev2"><?php printLangSwitcher(); ?></li>
				<li id="discla">&copy; 2018 Conceptual Fine Arts Ltd. <br/> all rights reserved</li>
			</ul>
		</div>

  </nav>

<div class="clear"></div>
<div id="wrap">
