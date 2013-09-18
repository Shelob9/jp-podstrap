<?php
/** single.php
 *
 * The Template for displaying all single posts.
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0 - 05.02.2012
 */
$domain = 'ht';
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
			//$text = $feature->display('short_desc');
			$text = get_the_content();
			//Do the jumbotron
			jp_jumbotron($tag, $text, $domain);
			
			/**SUBFEATURE SECTION**/
			//Put the sub features in an array
			$subFeatures = $feature->field('sub_features');
			//loop through them creating links to their own pages
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
					<div class="span3">
						<?php  echo wp_get_attachment_image( $icon_id, 'thumbnail' ); ?>
					</div>
					<div class="span9">
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
		} //end while have_posts ?>
		
		<?php tha_content_bottom(); ?>
	</div><!-- #content -->
	<?php tha_content_after(); ?>
</section><!-- #primary -->

<?php
get_footer();


/* End of file index.php */
/* Location: ./wp-content/themes/the-bootstrap/single.php */