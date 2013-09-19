<?php
/** single.php
 *
 * The Template for displaying all single posts.
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0 - 05.02.2012
 */
global $domain;
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
			$text = get_the_content();
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
				jp_jumbotron($tag, $text, $domain, $cta= true, $link, $ctaText );
			}
			else {
				//Do the jumbotron without button.
				jp_jumbotron($tag, $text, $cta = false );
			}
			//display submenu
			jp_feature_submenu( $feature->pod_id, $domain );
			
			
			/**SUBFEATURE SECTION**/
			//Put the sub features in an array
			$subFeatures = $feature->field('sub_features');
			//loop through them creating links to their own pages if there is anything to loop through
			if ( ! empty( $subFeatures ) ) {
					foreach ($subFeatures as $subFeature) { 
						//get id for sub features page and put in $id
						$id = $subFeature['ID'];
						//get the short description from sub feature
						$short_desc = get_post_meta( $id, 'short_desc', true );
						//get the icon field meta
						$icon = get_post_meta( $id, 'icon', true );
						//get the ID for the icon
						$icon_id = $icon['ID'];
			?>
				<div class="row-fluid well well-small">
					<div class="span2">
						<?php  echo wp_get_attachment_image( $icon_id, 'thumbnail' ); ?>
					</div>
					<div class="span10">
						<a href="<?php echo esc_url( get_permalink($id) ); ?>">
							<h4><?php _e( get_the_title($id), $domain ); ?></h4>
						</a>
   						<P><?php _e( $short_desc, $domain ); ?></p>
						<div class="btn pull-right">
							<a href="<?php echo esc_url( get_permalink($id) ); ?>">
								<?php _e( 'Learn More', $domain ); ?>
							</a>
						</div>
					</div>
				</div>
			<?php   } //end of foreach
				} //endif
			
		} //end while have_posts 
		jp_related_features($domain);
		tha_content_bottom(); ?>
	</div><!-- #content -->
	<?php tha_content_after(); ?>
</section><!-- #primary -->

<?php
get_footer();


/* End of file index.php */
/* Location: ./wp-content/themes/the-bootstrap/single.php */