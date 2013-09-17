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
?>