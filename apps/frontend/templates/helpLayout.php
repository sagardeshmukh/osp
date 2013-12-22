<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>

    <?php include_partial('global/head') ?>

  </head>

  <body>

    <div id="wrapper">

      <?php include_partial('global/header') ?>

      <div id="content">

        <?php echo $sf_content ?>

      </div>

      <?php include_partial('global/footer') ?>

    </div>

    <script type="text/javascript">

      var _gaq = _gaq || [];

      _gaq.push(['_setAccount', 'UA-16630993-1']);

      _gaq.push(['_setDomainName', '.yozoa.mn']);

      _gaq.push(['_trackPageview']);

	

      (function() {

        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;

        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';

        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);

      })();

    </script>

  </body>

</html>

