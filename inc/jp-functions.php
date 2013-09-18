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
		<h1><?php _e($tagline, $domain); ?></h1>
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
?>