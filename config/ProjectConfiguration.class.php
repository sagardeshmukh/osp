<?php
if(!is_dir('D:/xampp'))
	require_once '/var/chroot/home/content/39/11374039/html/dev/lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
else
	require_once 'd:/xampp/htdocs/yozoadev/sf_app/lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin', 'sfThumbnailPlugin');
    $this->enablePlugins('sfFeed2Plugin');
    $this->enablePlugins('sfFormExtraPlugin');
	$this->enablePlugins('sfJqueryReloadedPlugin');
  }
}
