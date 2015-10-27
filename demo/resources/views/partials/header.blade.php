<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $pageTitle or 'Demo Page' }}</title>

        <?php echo Html::style('css/bootstrap.min.css'); ?>
        <?php echo Html::style('css/font-awesome.css'); ?>
        <?php echo Html::style('css/layout.css'); ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <link media="all" type="text/css" rel="stylesheet" href="http://dashboard.predictry.com/sdk/v4/p.css"/>
        <script type="text/javascript">
            var tenant = '<?php echo $tenant; ?>';
            var api_url = '<?php echo URL::to('api'); ?>' ;
            var _predictry = _predictry || [];
            (function () {
                _predictry.push(['setTenantId', tenant], ['setApiKey', "967ea37d5965fd1308f21a2af32b6303"] 
<?php
if ($tenant == "SOUKAIMY") {
  echo ",['setBaseURL', 'http://www.soukai.my/']";
}
?>
                );
                var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
                g.type = 'text/javascript';
                g.defer = true;
                g.async = true;
                g.src = '//dashboard.predictry.com/sdk/v4/p.js';
                s.parentNode.insertBefore(g, s);
            })();
        </script>
    </head>
    <body>
