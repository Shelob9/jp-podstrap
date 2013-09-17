<?php

/**
* Create "Jumbotron at top of pages
* 
* @author Josh Pollock
* @param string $tagline Title for the section.
* @param string $text Text for section.
* @param sting $domain Translation text domain
*/
if ( ! function_exists('jp_jumbotron') ) :
function jp_jumbotron($tagline, $text, $domain) { ?>
	<!-- Jumbotron -->
	<div class="jumbotron">
		<h1><?php _e($tagline, $domain); ?></h1>
		<p class="lead"><?php _e($text, $domain); ?></p>
		<!--What to use for this (CTA destination?) ??-->
		<a class="btn btn-large btn-success" href="#">Get started today</a>
    </div>
<?php }
endif; // ! jp_jumbotron exists
?>