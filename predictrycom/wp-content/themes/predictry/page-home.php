<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>
<div id="inSlider" class="carousel slide carousel-fade" data-ride="carousel">
    <ol class="carousel-indicators">
    <?php $slide = 0; while(has_sub_field('slides')) : $slide++; ?>    
		<li data-target="#inSlider" data-slide-to="<?php echo $slide; ?>" class="<?php if($slide == 1) : ?>active<?php endif; ?>"></li>
    <?php endwhile; ?>
    </ol>
    <div class="carousel-inner" role="listbox">
	<?php $slide = 0; while(has_sub_field('slides')) : $slide++; ?>
        <div class="item <?php if($slide == 1) : ?>active<?php endif; ?>">
            <div class="container">
                <div class="carousel-caption">
					<?php the_sub_field('slide_text'); ?>
                    
                </div>
				<?php if(get_sub_field('slide_img')) : ?>
                <div class="carousel-image">
                    <img src="<?php the_sub_field('slide_img'); ?>" alt=""/>
                </div>
				<?php endif; ?>
            </div>
            <!-- Set background for slide in css -->
            <div class="header-back" style="background: url(<?php the_sub_field('slide_bg'); ?>); background-size:cover;"></div>

        </div>
	<?php endwhile; ?>

    </div>
	
	<?php if($slide > 1) : ?>
    <a class="left carousel-control" href="#inSlider" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#inSlider" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
	<?php else : ?>
	<style>.carousel-indicators {display:none;}</style>
	<?php endif; ?>
</div>


<section id="features" class="container services">
    <div class="row">
		<?php $c=0; while(has_sub_field('colorbox')) : $c++; ?>
        <div class="col-sm-3">
            <div class="colorbox text-center color_<?php echo $c; ?>">
				<div class="color_icon"><img src="<?php the_sub_field('icon'); ?>"></div>
				<div class="color_title"><?php the_sub_field('title'); ?></div>
				<div class="color_text">
					<?php the_sub_field('desc'); ?>
				</div>
			</div>
        </div>
		<?php endwhile; ?>
    </div>
</section>

<section  class="container features">
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="navy-line"></div>
            <h1><?php the_field('section_2_title'); ?></h1>
            <?php the_field('section_2_subtitle'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 text-center">
		<?php $s2=0; while(has_sub_field('section_2_blocks')) : $s2++; ?>
            <div <?php if($s2 == 2) : ?>class="m-t-lg"<?php endif; ?>>
                <i class="fa <?php the_sub_field('section_2_block_icon'); ?> features-icon"></i>
                <h2><?php the_sub_field('section_2_block_title'); ?></h2>
				<?php the_sub_field('section_2_block_content'); ?>
            </div>
		<?php endwhile; ?>
          
        </div>
        <div class="col-md-6 text-center">
            <center><img src="<?php the_field('section_2_image'); ?>" alt="dashboard" class="img-responsive"></center>
        </div>
        <div class="col-md-3 text-center">
        <?php $s2=0; while(has_sub_field('section_2_blocks_right')) : $s2++; ?>
            <div <?php if($s2 == 2) : ?>class="m-t-lg"<?php endif; ?>>
                <i class="fa <?php the_sub_field('section_2_block_icon'); ?> features-icon"></i>
                <h2><?php the_sub_field('section_2_block_title'); ?></h2>
				<?php the_sub_field('section_2_block_content'); ?>
            </div>
		<?php endwhile; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="navy-line"></div>
            <h1><?php the_field('section_3_title'); ?></h1>
            <?php the_field('section_3_subtitle'); ?>
        </div>
    </div>
    <div class="row features-block">
        <div class="col-lg-6 features-text">
			<?php the_field('section_3_content'); ?>
        </div>
        <div class="col-lg-6 text-right">
            <img src="<?php the_field('section_3_image'); ?>" alt="" class="img-responsive pull-right">
        </div>
    </div>
</section>

<section class="features">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1><?php the_field('section_5_title'); ?></h1>
                <?php the_field('section_5_subtitle'); ?>
            </div>
        </div>
        <div class="row">
		<?php $f=0; while(has_sub_field('section_5_features')) : $f++; ?>
            <div class="col-lg-5 <?php if($f == 1) : ?>col-lg-offset-1<?php endif; ?> features-text">
                <?php the_sub_field('feature_content'); ?>
				
            </div>
			<?php if($f == 2) { $f = 0; echo "<div style='clear:both;'></div>"; } ?>
		<?php endwhile; ?>

        </div>
    </div>

</section>

<section id="testimonials" class="navy-section testimonials" <?php if(get_field('testi_bg')) : ?>style="background: url(<?php the_field('testi_bg'); ?>) no-repeat center center; background-size:cover;"<?php endif; ?>>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <i class="fa fa-comment big-icon"></i>
                <h1>
                    <?php the_field('testi_title'); ?>
                </h1>
			<?php while(has_sub_field('testimonials')) : ?>
                <div class="testimonials-text">
                    <i><?php the_sub_field('testi_content'); ?></i>
                </div>
                <small>
                    <strong><?php the_sub_field('testi_author'); ?></strong>
                </small>
				<br />&nbsp;
			<?php endwhile; ?>
            </div>
        </div>
    </div>

</section>

<section id="logos" class="client_logos">

    <div class="container">
		<div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1><?php the_field('sponsors_title'); ?></h1>
                <?php the_field('sponsors_subtitle'); ?>
            </div>
        </div>
		
        <div class="row">
            <div class="col-lg-12 text-center">
			
				<div id="sponsors" class="owl-carousel">
					<?php while(has_sub_field('clients')) : ?>
						<div><img src="<?php the_sub_field('logo'); ?>"></div>
					<?php endwhile; ?>
				</div>
			
			</div>
		</div>
	</div>
</section>

<section id="pricing" class="pricing">
    <div class="container">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1><?php the_field('price_title'); ?></h1>
                <?php the_field('price_subtitle'); ?>
            </div>
        </div>
        <div class="row">
            
		<?php $p=0; while(has_sub_field('plans')) : $p++; ?>
            <div class="col-lg-4 <?php if($p == 1) : ?>col-lg-offset-2<?php endif; ?>">
                <ul class="pricing-plan list-unstyled">
                    <li class="pricing-title">
                        <?php the_sub_field('title'); ?>
                    </li>
                    <li class="pricing-desc">
                        <?php the_sub_field('desc'); ?>
                    </li>
                    <li class="pricing-price">
                       <?php the_sub_field('price'); ?>
                    </li>
					<?php while(has_sub_field('list')) : ?>
						<li><?php the_sub_field('item'); ?></li>
					<?php endwhile; ?>
                    <li class="plan-action">
                        <a class="btn btn-primary btn-xs orangez" href="<?php the_sub_field('link'); ?>">Try NOW</a>
						<br />&nbsp;
						<div>First 60 days always free<br />No credit card required to sign up</div>
                    </li>

                </ul>
            </div>
		<?php endwhile; ?>
			
        </div>
        
    </div>

</section>

<?php get_footer(); ?>
