<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Demarket" >
    <!-- Add Your favicon here -->
    <link rel="icon" href="<?php bloginfo('template_url'); ?>/img/favicon.ico" type="image/x-icon" />

    <title>INSPINIA - Landing Page</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?php bloginfo('template_url'); ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="<?php bloginfo('template_url'); ?>/css/style.css" rel="stylesheet">

	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/owl/owl.carousel.css">
 
	<!-- Default Theme -->
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/owl/owl.theme.css">

<?php wp_head(); ?>
</head>
<body id="page-top" <?php body_class( $class ); ?>>
<div class="navbar-wrapper">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="logo-black" href="/"><img src="<?php bloginfo('template_url'); ?>/img/logo.png"></a>
					<a class="logo-white" href="/"><img src="<?php bloginfo('template_url'); ?>/img/logo-white.png"></a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
			
<?php if(is_front_page()) : ?>
<?php wp_nav_menu( array( 'theme_location' => 'top_homepage','fallback_cb'=> '', 'container'=>'', 'menu_class'=>'nav navbar-nav navbar-right', 'menu_id'=>'') ); ?> 
<?php else : ?>
<?php wp_nav_menu( array( 'theme_location' => 'top','fallback_cb'=> '', 'container'=>'', 'menu_class'=>'nav navbar-nav navbar-right', 'menu_id'=>'') ); ?> 
<?php endif; ?>		
	
				<ul class="header_buttons">
					<li><a href="http://dashboard.predictry.com/v2/register?pricing=cpa" class="btn btn-primary btn-lg">Sign up</a></li>
					<li><a href="http://dashboard.predictry.com/v2/login" class="btn btn-primary btn-lg white">Sign in</a></li>
				</ul>
                </div>
				
            </div>
        </nav>
</div>
