<?php

/**
* Create "Jumbotron at top of pages
* 
* @author Josh Pollock
* @param string $tagline Title for the section.
* @param string $text Text for section.
* @param sting $domain Translation text domain
* @param boolean $cta Show CTA link on true. Default = false. Optional.
* @link string $link Link for CTA button. Required if $cta = true.
* @param string ctaText Text for CTA button. Optional.
*/
if ( ! function_exists('jp_jumbotron') ) :
function jp_jumbotron($tagline, $text, $domain, $cta = false, $link = '', $ctaText = "Call To Action") { ?>
	<!-- Jumbotron -->
	<div class="jumbotron">
		<h1><?php esc_attr_e($tagline, $domain); ?></h1>
		<p class="lead"><?php _e($text, $domain); ?></p>
		<?php if ($cta != false) {
			//esc cta link into a var
			$ctaLink = esc_url($link);
			echo '<a class="btn btn-large btn-success" href="'.$ctaLink.'">';
			_e($ctaText, $domain);
			echo '</a>';
		}
		?>
    </div>
<?php }
endif; // ! jp_jumbotron exists


/**
* Create feature specific submenu
*
* @author Josh Pollock
* @param int $fPodId ID of Pod for feature who's subnav this is
* @param string $domain text translation domain
* $todo Get rid of totally redundant use of pods()
*/
if ( ! function_exists( 'jp_feature_submenu' ) ) :
function jp_feature_submenu( $fPodId, $domain ) {
	//get Pod object for feature
	$feature = pods();
	?>
	<subnav class="navbar">
  		<div class="navbar-inner pull-right">
   			<a class="brand" href="#"><?php _e( $feature->field('short_title'), $domain) ; ?></a>
			<ul class="nav">
		<?php 
			//Put the sub features in an array
			$subFeatures = $feature->field('sub_features');
			foreach ($subFeatures as $subFeature) {
				//get id for sub features page and put in $id
				$id = $subFeature['ID'];
				//get the short title from sub feature
				$short_title = get_post_meta( $id, 'short_title', true );
				echo '<li ><a href="';
				esc_url( get_permalink( $id ) );
				echo '">';
				_e( $short_title, $domain );
				echo '</a></li>';
			}
		?>
			</ul>
		</div>
	</subnav>
<?php
}
endif; // ! jp_feature_submenu exists


/**
* Add JS and CSS for this
*
* @author Josh pollock
*/
if ( ! function_exists( 'jp_scripts_styles') ) :
function jp_scripts_styles() {
	wp_enqueue_script( 'backstretch', get_template_directory_uri().'/js/jquery.backstretch.min.js', array( 'jquery'), false, false );
	wp_enqueue_style( 'jp-style', get_template_directory_uri().'/css/jp.css' );
}
add_action('wp_enqueue_scripts', 'jp_scripts_styles');
endif; // ! jp_scripts_styles exists

/**
* Backstretch on jumbotron
*
* @author Josh Pollock
*/
if ( ! function_exists( 'jp_jumbostretch' ) ) :
function jp_jumbostretch() {
	//first test this is the fornt page or a feature or sub_feature so we have pods to pick from
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
add_action('wp_footer', 'jp_jumbostretch');
endif; // ! jp_jumbostretch exists

/**
* Output dynamically generated CSS to header
*
* @author Josh Pollock
*/
if ( ! function_exists ( 'jp_dynamic_styles') ) :
function jp_dynamic_styles() {
	//first test this is the fornt page or a feature or sub_feature so we have pods to pick from
	if ( is_front_page() || 'feature' == get_post_type() || 'sub_feature' == get_post_type() ) {
		$pod = pods();
		$title = $pod->field( 'top_title_color' );
		$text = $pod->field( 'top_text_color' );
	?>
		<style>
			.jumbotron h1{color: <?php echo $title; ?>;}
			.jumbotron p{color: <?php echo $text; ?>;}
		</style>
<?php
	}
}
add_action( 'wp_head', 'jp_dynamic_styles' );
endif; // ! jp_dynamic_styles exists

/**
* Related Features Box
*
* @author Josh Pollock
* @param string $domain text translation domain
*
*/
if ( ! function_exists ( 'jp_related_features' ) ) :
function jp_related_features($domain) {
	//first test if this a feature or sub_feature so we have our taxonomy to work with
	if ( 'feature' == get_post_type() || 'sub_feature' == get_post_type() ) {
		//get the feature/ sub_feature's feature categories
		$terms = get_the_terms( get_the_id(), 'feature_cat' );
		//get the slug foreach
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
		esc_attr_e( 'Related Features:&nbsp;', $domain );
		//Show the titles of queried posts as links
		while ( $query->have_posts() ) : $query->the_post();
			the_title( '<p class="feature-group pull-left"><a href="' . get_permalink() .'" title="' . sprintf( esc_attr__( 'Permalink to %s', 'the-bootstrap' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark">', '</a>&nbsp;&nbsp;</p>');
		endwhile; //have posts
		wp_reset_postdata();
		echo "</div>";
	} //if is feature/Sub_feature
}
endif; // ! jp_related_features exists
?>