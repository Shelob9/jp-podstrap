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
			//get the short description from sub feature
			$text = get_post_meta( get_the_id(), 'short_desc', true );
			//Do the jumbotron
			jp_jumbotron($tag, $text, $domain);
			?>
				<div class="row-fluid-fluid">
					<div class="span12">
						<?php the_content(); ?>
					</div>
				</div>
			
			<?php } //end while have_posts
			jp_related_features($domain);
			tha_content_bottom(); ?>
		</div><!-- #content -->
	<?php tha_content_after(); ?>
</section><!-- #primary -->

<?php
get_footer();


/* End of file index.php */
/* Location: ./wp-content/themes/the-bootstrap/single.php */