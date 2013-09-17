<?php
/** front-page.php
 *
 * Front-Page
 *
 * @author 	Konstantin Obenland
 * @package The Bootstrap
 * @since	1.3.0	- 29.04.2012
 */

get_header(); ?>

<section id="primary" class="span12">
	<?php tha_content_before(); ?>
	<div id="content" role="main">
		<?php tha_content_top(); ?>
		
		<?php
			//Get the marketting_settings pod object
			$top = pods('marketing_settings');
		?>
			
		<!-- Jumbotron -->
      <div class="jumbotron">
        <h1><?php echo $top->display('front_page_tagline'); ?></h1>
        <p class="lead"><?php echo $top->display('front_page_text'); ?></p>
        <!--What to use for this (CTA destination?) ??-->
        <a class="btn btn-large btn-success" href="#">Get started today</a>
      </div>

      <hr>
      <?php
      //setup parameters before getting features pod
		$params = array( 
			//limit to three
        	'limit'   => 3
   		 ); 
		//get the main features and put them in $features array
		$features = pods('feature', $params);
		//define text Domain
		$domain = 'ht';
	?>

      <!-- Example row of columns -->
      <div class="row-fluid">
      
      	<?php 
			if ( 0 < $features->total() ) { 
				while ( $features->fetch() ) { 
					//put ID in a var to be used in get_permalink
					$id = $features->field('ID');
					?>
					<div class="span4">
						<h2><?php _e($features->display('short_title'), $domain); ?></h2>
						<p><?php _e($features->display('short_desc'), $domain); ?> </p>
						<p><a class="btn" href="<?php echo esc_url(get_permalink( $id) ); ?>">View details &raquo;</a></p>
					</div>
				<?php 
				}
			}
		?>
        
      </div>
		<?php tha_content_bottom(); ?>
	</div><!-- #content -->
	<?php tha_content_after(); ?>
</section><!-- #primary -->

<?php
get_footer();


/* End of file _full_width.php */
/* Location: ./wp-content/themes/the-bootstrap/_full_width.php */


//MOVE THIS!
function ht_front_style() { ?>
	<style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 60px;
      }

      /* Custom container */
      .container {
        margin: 0 auto;
        max-width: 1000px;
      }
      .container > hr {
        margin: 60px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 80px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 100px;
        line-height: 1;
      }
      .jumbotron .lead {
        font-size: 24px;
        line-height: 1.25;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }


      /* Customize the navbar links to be fill the entire space of the .navbar */
      .navbar .navbar-inner {
        padding: 0;
      }
      .navbar .nav {
        margin: 0;
        display: table;
        width: 100%;
      }
      .navbar .nav li {
        display: table-cell;
        width: 1%;
        float: none;
      }
      .navbar .nav li a {
        font-weight: bold;
        text-align: center;
        border-left: 1px solid rgba(255,255,255,.75);
        border-right: 1px solid rgba(0,0,0,.1);
      }
      .navbar .nav li:first-child a {
        border-left: 0;
        border-radius: 3px 0 0 3px;
      }
      .navbar .nav li:last-child a {
        border-right: 0;
        border-radius: 0 3px 3px 0;
      }
    </style>
<?php }
add_action('wp_head', 'front_style');