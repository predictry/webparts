<?php get_header(); ?>

<section class="gray-section inner_page_title">
	<div class="row">
        <div class="col-lg-12 text-center">
            <div class="navy-line"></div>
            <h1>
				<?php if(is_category()) : ?>
					<?php single_cat_title(); ?>
				<?php else : ?>
					Blog
				<?php endif; ?>
			</h1>
        </div>
    </div>
</section>

<section  class="container page_content jobs_section">
    
	
	
    <div class="row">
       	<div class="col-md-9">
		
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	
		<div class="post">
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<div class="post_meta">
				<span>Posted on <?php the_time('d.m.Y'); ?></span>
				<span><?php the_category(' '); ?></span>
			</div>
			<div class="small_desc"><?php the_excerpt(); ?></div>
			<a href="<?php the_permalink(); ?>">Read More</a>
        </div>
		<?php endwhile; else : ?>
		<?php endif; ?>
		
		<div class="row pager">
			<div class="col-xs-6" style="text-align:left;"><?php next_posts_link( '&larr; Older Posts ', 0 ); ?></div>
			<div class="col-xs-6" style="text-align:right;"><?php previous_posts_link( 'Newer Posts &rarr;', 0 ); ?></div>
		</div>
		</div>
		<div class="col-md-3">
			<?php get_sidebar(); ?>
		</div>
    </div>
	
	
	
    
</section>

<?php get_footer(); ?>