<?php
/*
Template Name: Team
*/
?>
<?php get_header(); ?>

<?php if(!get_field('title_off')) : ?>
<section class="gray-section inner_page_title">
	<div class="row">
        <div class="col-lg-12 text-center">
            <div class="navy-line"></div>
            <h1><?php the_title(); ?></h1>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	

<section  class="container page_content" style="margin-bottom:0;">
	
    <div class="row">
        <div class="col-md-12">
			<?php the_content(); ?>
        </div>
    </div>
    
</section>

<section class="team" style="margin: 20px 0 40px 0;">
    <div class="container">
		<?php if(get_field('team_title')) : ?>        
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line" style="margin-top: 30px;"></div>
                <h1><?php the_field('team_title'); ?></h1>
                <?php the_field('team_subtitle'); ?>
            </div>
        </div>
       <?php endif; ?>
        <div class="row">
		<?php $t=0; while(has_sub_field('team')) : $t++; ?>
            <div class="col-sm-4">
                <div class="team-member">
                    <img src="<?php the_sub_field('team_photo'); ?>" class="img-responsive img-circle <?php if(!get_sub_field('team_big')) : ?>img-small<?php endif; ?>" alt="">
                    <h4><?php the_sub_field('team_title'); ?></h4>
                    <?php the_sub_field('team_content'); ?>
                </div>
            </div>
			<?php if(($t%3) == 0) : ?><div style="clear:both; padding-top:20px;"></div><?php endif; ?>
		<?php endwhile; ?>
            
        </div>
       
    </div>
</section>

<?php endwhile; else : ?>
<?php endif; ?>


<?php get_footer(); ?>