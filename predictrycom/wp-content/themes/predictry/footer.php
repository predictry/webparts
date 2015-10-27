<?php if(is_front_page()) : ?>
<section id="contact" class="gray-section contact">
    <div class="container">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>Contact Us</h1>
            </div>
        </div>
        <div class="row m-b-lg">
            <div class="col-lg-6 col-lg-offset-3 text-center">
               <?php echo do_shortcode('[contact-form-7 id="217" title="Contact Form Predictry"]'); ?>
            </div>
            
        </div>

    </div>
</section>
<?php endif; ?>
<section id="footer" class="gray-section footer_custom">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <p><strong>Information</strong></p>
				<?php wp_nav_menu( array( 'theme_location' => 'footer1','fallback_cb'=> '', 'container'=>'', 'menu_class'=>'', 'menu_id'=>'') ); ?>
            </div>
			<div class="col-lg-3">
                <p><strong>Read more</strong></p>
				<?php wp_nav_menu( array( 'theme_location' => 'footer2','fallback_cb'=> '', 'container'=>'', 'menu_class'=>'', 'menu_id'=>'') ); ?>
            </div>
			<div class="col-lg-3">
               &nbsp;
            </div>
			<div class="col-lg-3">
                <p><strong>Contact now:</strong></p>
				<p><a href="mailto:hello@predictry.com">hello@predictry.com</a></p>
            </div>
        </div>
		
		<div class="row">
            <div class="col-lg-12">
                <p style="padding-top:20px;"><strong>&copy; 2015 Predictry</strong><br/> A leader in Amazon-like products and item recommendations for e-commerce using Predictive Analytics</p>
            </div>
			
        </div>
		
    </div>
</section>

<script src="<?php bloginfo('template_url'); ?>/js/jquery-2.1.1.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/pace.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/bootstrap.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/classie.js"></script>
<?php if(is_front_page()) : ?>
<script src="<?php bloginfo('template_url'); ?>/js/cbpAnimatedHeader.js"></script>
<?php endif; ?>
<script src="<?php bloginfo('template_url'); ?>/js/inspinia.js"></script>
<script src="<?php bloginfo('template_url'); ?>/owl/owl.carousel.js"></script>
<script>
$(document).ready(function() {
  $("#sponsors").owlCarousel();
 
});
</script>
<?php if(!is_front_page()) : ?>
<script>
$(document).ready(function() {
  $(".navbar ").addClass('navbar-scroll');
 
});
</script>
<?php endif; ?>

<script>
$(document).ready(function() {
 $("h3").click(function() {
    $(this).next("div.answer").toggle("fast");
 });
});
$(document).ready(function() {
 $(".detailed_job").click(function() {
    $(this).prev("div.full_desc").toggle("fast");
 });
});
</script>

<?php wp_footer(); ?>
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-42599195-1', 'auto');
ga('send', 'pageview');
</script>
</body>
</html>
