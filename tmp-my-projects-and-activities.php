<?php
/**
 * The template for displaying all pages
 * Template Name: My Projects and Activities
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
global $wpdb;
get_header(); 
$current_user = wp_get_current_user();
$str_date = [];
$index = 1;
$index_s = 1;
?>
	<div id="primary" class="site-content">
		<div id="content" role="main">

			<div class="container">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="entry-content my_proact_section">

							<!-- MY TRIBUTES PANEL START -->
							<div class="my_proact_panel my_tributes_item">
								<div class="my_proact_head">
									<h3>My Tributes</h3>
								</div>
							<div class="my_proact_listing">
							<?php
							if(!empty($current_user)) {

								$args = array(
									'author'         =>  $current_user->ID,
									'orderby'        =>  'post_date',
									'order'          =>  'ASC',
									'post_type' 	 =>  'tributes',
									'post_status' => array('publish', 'draft'),
									'posts_per_page' => -1
									);
								query_posts($args);
								if ( have_posts() ) : 
									while ( have_posts() ) : the_post(); ?>
							<!-- tribute item #1 -->
							<div class="myproact_item">
							<div class="myproact_col proact_pic">
							<figure>
								<?php
								$get_author_id = get_the_author_meta('ID');
								$get_author_gravatar = get_avatar_url($get_author_id);
								if(has_post_thumbnail()){
								    the_post_thumbnail();
								} else {
								    echo '<img src="'.$get_author_gravatar.'" alt="'.get_the_title().'" />';
								}
								?>
							</figure>
							</div>
							 <div class="myproact_col proact_title">
								<h4><?php echo get_the_title()?></h4>
							<?php    
								$year_of_birth = '';
							    $dob = get_field('dob');
							    if (!empty($dob)) {
							    $str_date = explode('/', $dob);	
							    $year_of_birth = $str_date[2];
							    }

							    $year_of_death = '';
								$dod = get_field('dod');
								if (!empty($dod)) {
								$str_date = explode('/', $dod);
								$year_of_death = $str_date[2]; 
								}

							  	?>

							<span class="clearfix passedDAD">
						        <?php echo $year_of_birth; ?> - <?php echo $year_of_death; ?>
						    </span>
							</div>
							<div class="myproact_col posteddate"><span><?php the_date('F j, Y'); ?></span></div>
							<?php $status = get_post_status(); ?>
							<div class="myproact_col proact_status"><span><?php echo $status ?></span></div>
							</div>
							<?php endwhile; ?>

							<?php endif; 

						}
						?>
								</div>
							</div>

							<!-- MY WORKBOOKS PANEL START -->
							<div class="my_proact_panel my_workbooks_item">
								<div class="my_proact_head">
									<h3>My Workbooks</h3>
								</div>
								<div class="my_proact_listing">
								<?php 
								if(!empty($current_user)) {

								$args = array(
									'author'         =>  $current_user->ID,
									'orderby'        =>  'post_date',
									'order'          =>  'ASC',
									'post_type' 	 =>  'workbooks',
									'post_status' => array('publish', 'draft'),
									'posts_per_page' => -1
									);
								query_posts($args); 
								if ( have_posts() ) : 
									while ( have_posts() ) : the_post(); ?>
								
									<!-- tribute item #1 -->
									<div class="myproact_item">
										<div class="myproact_col proact_number">
											<span><?php echo $index; $index++; ?></span>
										</div>
										<div class="myproact_col proact_sumary">
											<h4><?php echo get_the_title()?></h4>
											<div class="clearfix"></div>
											<div class="workbooks_excerpt">
											<?php echo the_excerpt()?>
											</div>
										</div>
									</div>

								<?php endwhile; ?>
							<?php endif; 
						}
						?>							
								
						</div>
					</div>


			<!-- MY DONATION PANEL START -->
		<div class="my_proact_panel my_donations_item">
				<div class="my_proact_head">
				<h3>My Donations</h3>
				</div>
			<div class="my_proact_listing">
				<!-- Donation item #1 -->
				<div class="myproact_item">
				
				
				<?php
					if (is_user_logged_in()) {
					$tbl_donor = "wp_give_donors";
					$id = $current_user->ID;
					$retrieve_value = $wpdb->get_results("SELECT * FROM $tbl_donor WHERE user_id = '$id'");
					//echo '<pre/>'; print_r($retrieve_value); die('###');
					$donoId = '';
					$purchaseValue = '';
					if(!empty($retrieve_value)) {
						foreach ($retrieve_value as $data) {
							$donoId = $data->id;
							$purchaseValue = $data->purchase_value;
						
					
					$tbl_donor_meta = "wp_give_donormeta";
					$meta_key ="_give_stripe_customer_id";
					$retrieve_mode = $wpdb->get_var("SELECT meta_id FROM $tbl_donor_meta WHERE meta_key = '$meta_key'");
					//	echo $retrieve_mode; die('###');
					?>
					<div class="myproact_col proact_number">
					<span><?php echo $index_s; $index_s++; ?></span>
					</div>

					<div class="myproact_col proact_donatetype">
					<?php
						if (!empty($retrieve_mode)) {
								echo "<h4>Credit Card</h4>";
							}
							else{
								echo "<h4>Paypal</h4>"; 
							} ?> 
						</div>
					<?php
					$tbl_donation_meta = "wp_give_donationmeta";
					$meta_key = "_give_payment_donor_id";
					$donation_id = $wpdb->get_var("SELECT donation_id FROM $tbl_donation_meta WHERE meta_key = '$meta_key' AND meta_value = $donoId");
					//echo '<pre/>'; print_r($retrieve_data); die('###');
					

					if (!empty($donation_id)) {
						$donation_date = $wpdb->get_var("SELECT meta_value FROM $tbl_donation_meta WHERE meta_key = '_give_completed_date' AND donation_id = $donation_id");
					//echo $donation_date; die('###');
					}
					
					}
					}
											
				} // is user logged in	?>
							
				<div class="myproact_col proact_donate_amount">
				<span><?php echo round($purchaseValue); ?></span>
				</div>
				
				<?php
				$date=date_create($donation_date);
				?>
				<div class="myproact_col proact_donate_date">
				<span><?php echo date_format($date,'F j, Y'); ?></span>
				</div>
				</div>

			</div>
			</div>


					</div><!-- .entry-content -->
					</article><!-- #post -->
			</div>

		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>