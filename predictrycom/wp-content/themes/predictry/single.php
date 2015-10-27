<?php get_header(); ?>

<section class="gray-section inner_page_title">
	<div class="row">
        <div class="col-lg-12 text-center">
            <div class="navy-line"></div>
            <h1>
				<?php the_title(); ?>
			</h1>
        </div>
    </div>
</section>

<section  class="container page_content jobs_section">
    
	
	
    <div class="row">
       	<div class="col-md-9">
		
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	
		<div class="post">
			<div class="post_meta">
				<span>Posted on <?php the_time('d.m.Y'); ?></span>
				<span><?php the_category(' '); ?></span>
			</div>
			<div class="small_desc"><?php the_content(); ?></div>
			
        </div>
		<?php endwhile; else : ?>
		<?php endif; ?>
		
		
		</div>
		<div class="col-md-3">
			<?php get_sidebar(); ?>
		</div>
    </div>
	
	
	
    
</section>

<?php get_footer(); ?>