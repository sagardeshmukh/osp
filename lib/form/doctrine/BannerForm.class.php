<?php

/**
 * Banner form.
 *
 * @package    yozoa
 * @subpackage form
 * @author     Falcon
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BannerForm extends BaseBannerForm
{
  public function configure()
  {
      unset($this["type"]);
      
      $this->widgetSchema['category_id']     = new sfWidgetFormSelect(array('choices'=>array(
          1157      => "Э-худалдаа", 
          1         => "Бараа бүтээгдэхүүн", 
          38        => "Үл хөдлөх", 
          31        => "Автомашин", 
          0         => "Дэлгүүр", 
          108       => "Бэлэг")), array());
          
      $this->widgetSchema['begin_date']      = new sfWidgetFormI18nDate(array('culture'=>'en', 'default'=>date("Y-m-d")), array());
      $this->widgetSchema['end_date']        = new sfWidgetFormI18nDate(array('culture'=>'en', 'default'=>date("Y-m-d")), array());
      $this->widgetSchema['file']            = new sfWidgetFormInputFile(array(), array());

      $this->widgetSchema->setHelp("width", 'px');
      $this->widgetSchema->setHelp("height", 'px');
      
      $this->setValidator('begin_date', new sfValidatorDate(array(), array()));
      $this->setValidator('end_date',   new sfValidatorDate(array(), array()));
      $this->setValidator('file',       new sfValidatorFile(array('path' => sfConfig::get("sf_upload_dir")."/surtalchilgaa")));
      $this->setValidator('link',       new sfValidatorUrl());
      
      $this->getWidgetSchema()->getFormFormatter()->setHelpFormat('%help%');
  }

}