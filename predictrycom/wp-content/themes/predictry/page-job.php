<?php
/*
Template Name: Job Opening
*/
?>
<?php get_header(); ?>

<section class="gray-section inner_page_title">
	<div class="row">
        <div class="col-lg-12 text-center">
            <div class="navy-line"></div>
            <h1><?php the_title(); ?></h1>
        </div>
    </div>
</section>

<section  class="container page_content jobs_section">
    
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	
	
	<div class="row">
        <div class="col-md-12">
			<div><?php the_content(); ?></div>
        </div>
    </div>
	
	<?php while(has_sub_field('jobs')) : ?>
    <div class="row">
        <div class="col-md-4">
			<img src="<?php the_sub_field('thumb'); ?>">
        </div>
		<div class="col-md-8">
			<h2><?php the_sub_field('job_title'); ?></h2>
			<div class="small_desc"><?php the_sub_field('small_desc'); ?></div>
			<div class="full_desc"><?php the_sub_field('full_desc'); ?></div>
			<a class="detailed_job">Show More</a>
        </div>
    </div>
	<?php endwhile; ?>
	<?php endwhile; else : ?>
	<div class="row">
        <div class="col-lg-12 text-center">
            <div class="navy-line"></div>
            <h1>Error 404</h1>
			<p>Page not found!</p>
        </div>
    </div>
	<?php endif; ?>
    
</section>

<?php get_footer(); ?>