<?php

/**
 * banner actions.
 *
 * @package    yozoa
 * @subpackage banner
 * @author     Falcon
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class bannerActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->banners = Doctrine::getTable('Banner')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new BannerForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new BannerForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($banner = Doctrine::getTable('Banner')->find(array($request->getParameter('id'))), sprintf('Object banner does not exist (%s).', $request->getParameter('id')));
    $this->form = new BannerForm($banner);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($banner = Doctrine::getTable('Banner')->find(array($request->getParameter('id'))), sprintf('Object banner does not exist (%s).', $request->getParameter('id')));
    $this->form = new BannerForm($banner);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($banner = Doctrine::getTable('Banner')->find(array($request->getParameter('id'))), sprintf('Object banner does not exist (%s).', $request->getParameter('id')));
    $banner->delete();

    $this->redirect('banner/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $banner = $form->save();

      $this->redirect('banner/index');
    }
  }
}