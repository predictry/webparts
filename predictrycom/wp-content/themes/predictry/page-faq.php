<?php
/*
Template Name: FAQ
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

<section  class="container page_content faq_section">
    
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	
	
    <div class="row">
        <div class="col-md-12">
			<?php the_content(); ?>
        </div>
    </div>
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