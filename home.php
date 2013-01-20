<?php
/** index.php
 *
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @author		Konstantin Obenland
 * @package		The Bootstrap
 * @since		1.0.0 - 05.02.2012
 */

get_header(); ?>

<section id="primary" class="span12">
	<div class="row" id="home-top">
		<div class="span4" id="home-about">
		
		</div>

		<div class="span8" id="home-slider">
		</div>
	</div>
	
	<div class="row" id="home-main">
<!--Projects-->
		<div class="row" id="home-projects">
			<div class="row">
				<div class="span4 offset4 htitle">
				
				</div>
			</div>
			<div class="row">
				<div class="span10 offset2 hbox">
			
				</div>
			</div>
		</div>
<!--Word Press Dev-->
		<div class="row" id="home-wp">
			<div class="row">
				<div class="span4 offset4 htitle">
				
				</div>
			</div>
			<div class="row">
				<div class="span10 offset2 hbox">
			
				</div>
			</div>
		</div>

<!--Writing-->
	<div class="row" id="home-main">
		<div class="row" id="home-writing">
			<div class="row">
				<div class="span4 offset4 htitle">
				
				</div>
			</div>
			<div class="row">
				<div class="span10 offset2 hbox">
			
				</div>
			</div>
		</div>
		
		
	</div>
</section><!-- #primary -->

<?php

get_footer();


/* End of file index.php */
/* Location: ./wp-content/themes/the-bootstrap/index.php */