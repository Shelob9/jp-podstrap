<?php
/**
*
* Functions that Josh added to the theme
*
* @package jp-podstrap
* @author Josh Pollock
* @since 0.1
*/

/**
* Create "Jumbotron at top of pages
* 
* @package jp-podstrap
* @author Josh Pollock
* @since 0.1
* @param string $tagline Title for the section.
* @param string $text Text for section.
* @param sting 'jp-podstrap' Translation text domain
* @param boolean $cta Show CTA link on true. Default = false. Optional.
* @link string $link Link for CTA button. Required if $cta = true.
* @param string ctaText Text for CTA button. Optional.
*/
if ( ! function_exists('jp_podstrap_jumbotron') ) :
function jp_podstrap_jumbotron($tagline, $text, $cta = false, $link = '', $ctaText = "Call To Action") { ?>
	<!-- Jumbotron -->
	<div class="jumbotron">
		<div class="container">
			<h2><?php esc_attr_e($tagline, 'jp-podstrap'); ?></h2>
			<p class="lead"><?php _e($text, 'jp-podstrap'); ?></p>
			<?php if ($cta != false) {
				//esc cta link into a var
				$ctaLink = esc_url($link);
				echo '<a class="btn btn-large btn-success" href="'.$ctaLink.'">';
				_e($ctaText, 'jp-podstrap');
				echo '</a>';
			}
			?>
		</div>
    </div>
<?php }
endif; // ! jp_podstrap_jumbotron exists

/**
* Add JS and CSS for this
*
* @package jp-podstrap
* @author Josh Pollock
* @since 0.1
*/
if ( ! function_exists( 'jp_podstrap_scripts_styles') ) :
function jp_podstrap_scripts_styles() {
	wp_enqueue_script( 'backstretch', get_template_directory_uri().'/js/jquery.backstretch.min.js', array( 'jquery'), false, false );
	wp_enqueue_style( 'jp-style', get_template_directory_uri().'/css/jp.css' );
}
add_action('wp_enqueue_scripts', 'jp_podstrap_scripts_styles');
endif; // ! jp_podstrap_scripts_styles exists

/**
* Backstretch on jumbotron
*
* @package jp-podstrap
* @author Josh Pollock
* @since 0.1
*/
if ( ! function_exists( 'jp_podstrap_jumbostretch' ) ) :
function jp_podstrap_jumbostretch() {
	//First test if this is the front page or a feature or sub_feature so we have pods to pick from
	if ( is_front_page() || 'feature' == get_post_type() || 'sub_feature' == get_post_type() ) {
		if ( is_front_page() ) {
			//for front page get theme option pod
			$pod = pods('theme_options');
		}
		else {
			//for other pages get from current pod
			$pod = pods();
		}
		//get the image field and turn it into ID then source URL
		$img = $pod->field( 'top_bg' );
		$img_id = $img['ID'];
		$img_src = wp_get_attachment_url( $img_id );
		//output the script into the footer
		echo '<script>';
		echo 'jQuery(".jumbotron").backstretch("'.$img_src.'");';
		echo '</script>';
	}
}
add_action('wp_footer', 'jp_podstrap_jumbostretch');
endif; // ! jp_podstrap_jumbostretch exists

/**
* Output dynamically generated CSS to header
*
* @package jp-podstrap
* @author Josh Pollock
* @since 0.1
*/
if ( ! function_exists ( 'jp_podstrap_dynamic_styles') ) :
function jp_podstrap_dynamic_styles() {
	//First test if this is the fornt page or a feature or sub_feature so we have pods to pick from
	if ( is_front_page() || 'feature' == get_post_type() || 'sub_feature' == get_post_type() ) {
		$pod = pods();
		$title = $pod->field( 'top_title_color' );
		$text = $pod->field( 'top_text_color' );
	?>
		<style>
			.jumbotron h2{color: <?php echo $title; ?>;}
			.jumbotron p{color: <?php echo $text; ?>;}
		</style>
<?php
	}
}
add_action( 'wp_head', 'jp_podstrap_dynamic_styles' );
endif; // ! jp_podstrap_dynamic_styles exists

/**
* Related Features Box
*
* @package jp-podstrap
* @author Josh Pollock
* @since 0.1
*/
if ( ! function_exists ( 'jp_podstrap_related_features' ) ) :
function jp_podstrap_related_features() {
	//first test if this a feature or sub_feature so we have our taxonomy to work with
	if ( 'benefit' == get_post_type() || 'sub_feature' == get_post_type() ) {
		//get the feature/ sub_feature's feature categories
		$terms = get_the_terms( get_the_id(), 'feature_cat' );
		//test if there are any terms if so continue, if not then skip this
		if ( ! empty( $terms ) ) {
			//get the slug foreach and put in $cats array to be fed to WP_Query
			$cats = array();
			foreach ( $terms as $term ) {
				$cats = $term->slug;
			}
			//query for posts in the same feature category(s)
			$args = array(
				'tax_query' => array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'feature_cat',
						'field' => 'slug',
						'terms' => array( $cats ),
					)
				)
			);
			$query = new WP_Query( $args );
		
			//wrap output in a well
			echo '<div class="well well-small">';
				echo '<div class="pull-left">';
					esc_attr_e( 'Related Features:&nbsp;', 'jp-podstrap' );
				echo '</div>';
				//Show the titles of queried posts as links
				while ( $query->have_posts() ) : $query->the_post();
					the_title( '<p class="feature-group pull-left"><a href="' . get_permalink() .'" title="' . sprintf( esc_attr__( 'Permalink to %s', 'jp-podstrap' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark">', '</a>&nbsp;&nbsp;</p>');
				endwhile; //have posts
				wp_reset_postdata();
			echo "</div>";
		} //emdif we have terms
	} //endif is feature/Sub_feature
}
endif; // ! jp_podstrap_related_features exists

/**
* Test if there is any content to return and if nto use Lorem Ipsums
*
* @package jp-podstrap
* @author Josh Pollock
* @since 0.1
* @param string $want Text you want to return.
* @param bool $short Get short or long place holder text as fallback. Default = true which gives short.
*/
if ( ! function_exists( 'jp_podstrap_or_ipsums' ) ) :
function jp_podstrap_or_ipsums($want, $short = true) {
	//put some genuine Lorem Ispums into some vars
	$loremLong =  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean venenatis tempor nisl, et condimentum sem adipiscing ac. Suspendisse ut eros neque. Sed fermentum erat neque, at sagittis nibh pulvinar blandit. Nulla luctus eleifend venenatis. Nulla facilisi. Fusce tristique, sapien varius pulvinar sagittis, dui elit pharetra ante, a fringilla elit felis eu massa. Duis eget imperdiet arcu. Curabitur ac posuere mauris, eu tempus nisl. Suspendisse potenti. In elit augue, tristique sit amet lorem ut, ultrices auctor dui. Quisque sit amet quam lorem. Maecenas rhoncus congue placerat. Morbi molestie leo nibh, venenatis adipiscing enim dignissim ac. Donec a pulvinar lectus, id tincidunt massa. Phasellus at dui eget nisl posuere scelerisque.';
	$loremShort =  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean venenatis tempor nisl, et condimentum sem adipiscing ac. Suspendisse ut eros neque. Sed fermentum erat neque.';
	//prepare to return long or short lorem ipsum
	if ( $short != true ) {
		$get = $loremLong;
	}
	else {
		$get = $loremShort;
	}
	//Decide what to return based on if $want is empty or  equals ''
	if ( ! empty($want) || $want != '' ) {
		//you get what you wanted
		return $want;
	}
	else {
		//you get Lorem Ipsum!
		return $get;
	}
}
endif; // ! jp_podstrap_or_ipsums exists

/**
* Loop for feature and sub_feature archive pages
*
* @package jp-podstrap
* @author Josh Pollock
* @since 0.1
*/
if ( ! function_exists( 'jp_podstrap_feature_archive_loop' ) ) :
function jp_podstrap_feature_archive_loop() {
	//query for both features and sub_features toghether
	$args = array(
				'post_type' => array( 'benefit', 'sub_feature' ),
				'posts_per_page' => 3
		);
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			get_template_part( '/partials/content', get_post_format() );
		} //endwhile
		jp_podstrap_content_nav();
		wp_reset_postdata();
	} //endif
}
endif; // ! jp_podstrap_feature_archive_loop exists

/**
* Don't return the title in loop on front-page, since it would look very bad
*
* @package jp-podstrap
* @author Josh Pollock
* @since 0.1
*/
if ( ! function_exists( 'jp_podstrap_no_title_front_loop' ) && ! is_admin() ) :
function jp_podstrap_no_title_front_loop($title, $id) {
    if ( is_front_page() ) {
        return '';
    }
    return $title;
}
add_filter('the_title', 'jp_podstrap_no_title_front_loop', 10, 2);
endif; // ! jp_podstrap_no_title_front_loop exists

/**
* Return admin notice if Pods isn't activate imploring user to install it.
*
* @package jp-podstrap
* @author Josh Pollock
* @since 0.1
*/
if ( ! function_exists( 'jp_podstrap_pods_nag' ) ) :
function jp_podstrap_pods_nag() {
	//url for plugins page
	$plugins = admin_url( 'plugins.php' );
	//Warning text content
	$text = 'You do not have <a href="http://pods.io" title="Pods: WordPress Evolved">Pods</a> installed and activated, which is required for this theme to function properly. You can install it through the <a href="'.$plugins.'">plugins installer</a> or download it from <a href="http://WordPress.org/plugins/pods" title="Pods download page on WordPress.org">WordPress.org/plugins/pods</a> and install it manually.';
    ?>
    <div class="updated">
        <p><?php _e( $text, 'jp-podstrap' ); ?></p>
    </div>
    <?php
}
//check if pods is active by testing for the existence of pods()
// if not throw the warning
if ( ! function_exists ( 'pods' ) ) {
	add_action( 'admin_notices', 'jp_podstrap_pods_nag' );
}
endif; // ! jp_podstrap_pods_nag exixts
?>