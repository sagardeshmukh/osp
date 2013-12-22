<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

    <?php //include_http_metas() ?>

    <?php //include_metas() ?>

    <?php //include_title() ?>



    <?php include_stylesheets() ?>

    <!--[if IE 6]><link rel="stylesheet" type="text/css" media="screen" href="/css/transdmin/ie6.css" /><![endif]-->

    <!--[if IE 7]><link rel="stylesheet" type="text/css" media="screen" href="/css/transdmin/ie7.css" /><![endif]-->

    <?php include_javascripts() ?>



    <link rel="shortcut icon" href="/favicon.ico" />

    <title>yozoa admin panel</title>

  </head>

  

  <body>

     <body>

    <div id="wrapper">

      <h1><a href="/"><span>yozoa admin panel</span></a></h1>

     <?php if ($sf_user->hasFlash('success')): ?>

      <div class="success"><?php echo $sf_user->getFlash('success') ?></div>

      <?php endif?>

      <div id="containerHolder">

        <div id="container"><br/>

          <div id="main">

            <?php echo $sf_content ?>

          </div>

          <div class="clear"></div>

        </div>

      </div>

      <p id="footer">www.yozoa.mn <a href="http://singleton.mn" target="_blank">Singleton LLC</a></p>

    </div>

  </body>

  </body>

</html>

