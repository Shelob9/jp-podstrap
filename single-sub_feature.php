<?php
/** single-sub_feature.php
 *
 * The Template for displaying all single posts of the "Sub Feature" CPT.
 *
 * Forked from the-bootstrap/single.php
 *
 * @package jp-podstrap
 * @author Josh Pollock
 * @since 0.1
 */
global $domain;;
get_header(); ?>

<section id="primary" class="span12">
	
	<?php tha_content_before(); ?>
	<div id="content" role="main">
		<?php tha_content_top();

		while ( have_posts() ) {
			the_post();
			/**SETUP PODS OBJECT**/
			//Not specifying a specific feature so WP will use current feature.
			$feature = pods();
			/**TOP OF PAGE**/
			//set up vars for jumbotron
			$tag = get_the_title();
			//get the short description from sub feature
			$text = get_post_meta( get_the_id(), 'short_desc', true );
			//Find out if we are showing a CTA button and if so get text and link
			$show = $feature->field( 'show_cta_button' );
			if ( $show != 0 ) {
				//get link and text for the button
				$link = $feature->field( 'cta_link' );
				$ctaText = $feature->field( 'cta_btn_text' );
			}
			else {
				//To avoiud
				$link = false;
			}
			//check if there is a value for link (ie somewhere for button to take us)
			if ( $link != false ) {
				//Do the jumbotron with button
				jp_podstrap_jumbotron($tag, $text, $domain, $cta= true, $link, $ctaText );
			}
			else {
				//Do the jumbotron without button.
				jp_podstrap_jumbotron($tag, $text, $cta = false );
			}
		?>
				<div class="row-fluid">
					<div class="span12">
						<?php the_content(); ?>
					</div>
				</div>
			
			<?php } //end while have_posts
			jp_podstrap_related_features($domain);
			tha_content_bottom(); ?>
		</div><!-- #content -->
	<?php tha_content_after(); ?>
</section><!-- #primary -->

<?php
get_footer();


/* End of file single-sub_feature.php */
/* Location: ./wp-content/themes/the-bootstrap/single-sub_feature.php */