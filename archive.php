<?php get_header(); ?>
		<div class="container">
			<div id="portfolio" class="clearfix row">
			
				<div id="main" class="col-sm-12 clearfix" role="main">
				
					<div class="page-header">
					<?php if (is_category()) { ?>
						<h1>
							<?php single_cat_title(); ?>
						</h1>
					<?php } elseif (is_tag()) { ?> 
						<h1>
							<?php single_tag_title(); ?>
						</h1>
					<?php } elseif (is_author()) { ?>
						<h1>
							<?php _e("Posts By:", "wpbootstrap"); ?> <?php get_the_author_meta('display_name'); ?>
						</h1>
					<?php } elseif (is_day()) { ?>
						<h1>
							<?php _e("Daily Archives:", "wpbootstrap"); ?> <?php the_time('l, F j, Y'); ?>
						</h1>
					<?php } elseif (is_month()) { ?>
					    <h1>
					    	<?php _e("Monthly Archives:", "wpbootstrap"); ?>: <?php the_time('F Y'); ?>
					    </h1>
					<?php } elseif (is_year()) { ?>
					    <h1>
					    	<?php _e("Yearly Archives:", "wpbootstrap"); ?>: <?php the_time('Y'); ?>
					    </h1>
					<?php } ?>
					</div>

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
						<section class="portfolio col-sm-6">
							<a class="portfolioitem" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
							<?php the_post_thumbnail( 'portfolio-large' ); ?>
							</a>
							<a id="overlay-<?php the_ID(); ?>" class="portfolio-overlay" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<?php the_title(); ?>
								<span class="view-project">View Project</span>
							</a>
						
							<?php //the_excerpt(); ?>					
						</section> <!-- end article section -->
						
						<footer>
							
						</footer> <!-- end article footer -->
					
					<!-- </article> end article -->
					
					<?php endwhile; ?>	
					
					<?php if (function_exists('page_navi')) { // if expirimental feature is active ?>
						
						<?php page_navi(); // use the page navi function ?>

					<?php } else { // if it is disabled, display regular wp prev & next links ?>
						<nav class="wp-prev-next">
							<ul class="pager">
								<li class="previous"><?php next_posts_link(_e('&laquo; Older Entries', "wpbootstrap")) ?></li>
								<li class="next"><?php previous_posts_link(_e('Newer Entries &raquo;', "wpbootstrap")) ?></li>
							</ul>
						</nav>
					<?php } ?>
								
					
					<?php else : ?>
					
					<article id="post-not-found">
					    <header>
					    	<h1><?php _e("No Posts Yet", "wpbootstrap"); ?></h1>
					    </header>
					    <section class="post_content">
					    	<p><?php _e("Sorry, What you were looking for is not here.", "wpbootstrap"); ?></p>
					    </section>
					    <footer>
					    </footer>
					</article>
					
					<?php endif; ?>
			
				</div> <!-- end #main -->
        
			</div> <!-- end #content -->
		</div> <!-- end .container -->

<?php get_footer(); ?>