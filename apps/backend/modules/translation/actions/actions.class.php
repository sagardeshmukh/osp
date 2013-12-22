<?php

/**
 * translation actions.
 *
 * @package    yozoa
 * @subpackage translation
 * @author     Falcon
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class translationActions extends sfActions
{

    public function executeIndex(sfWebRequest $request)
    {
        $application = sfConfig::get('app_frontend_application', 'frontend');
        $sf_root_dir = sfContext::getInstance()->getConfiguration()->getRootDir();

        $this->i18nLanguages = array();
        $this->messages = array();

        foreach ($this->_getI18nLanguages() as $sf_culture => $language)
        {
            //setting translation file path
            $translationsFile = $sf_root_dir . "/apps/{$application}/i18n/{$sf_culture}/messages.xml";

            //checking file is exist
            if (file_exists($translationsFile))
            {
                $this->i18nLanguages[$sf_culture] = $language;

                $values = $this->_loadTranslationFile($translationsFile, $sf_culture);

                foreach ($values as $id => $message)
                {
                    $this->messages[$id]['source'] = $message['source'];
                    $this->messages[$id][$sf_culture]['target'] = $message[$sf_culture]['target'];
                }
            }
        }
    }

    public function executeGetTranslation(sfWebRequest $request)
    {
        $application = sfConfig::get('app_frontend_application', 'frontend');
        $sf_root_dir = sfContext::getInstance()->getConfiguration()->getRootDir();

        $sf_culture = $request->getParameter('sf_culture');

        $translationsFile = $sf_root_dir . "/apps/{$application}/i18n/{$sf_culture}/messages.xml";

        $messages  = array();
        //checking file is exist
        if (file_exists($translationsFile))
        {
            $values = $this->_loadTranslationFile($translationsFile, $sf_culture);

            foreach ($values as $id => $message)
            {
                $messages[$id] = $message[$sf_culture]['target'];
            }
        }
        return $this->renderText(json_encode($messages));
    }


    public function executeCreateTranslation(sfWebRequest $request)
    {
        $application = sfConfig::get('app_frontend_application', 'frontend');
        $sf_root_dir = sfContext::getInstance()->getConfiguration()->getRootDir();


        $this->i18nLanguages = array();
        $this->messages = array();

        $this->sf_culture = "en";

        foreach ($this->_getI18nLanguages() as $sf_culture => $language)
        {
            //setting translation file path
            $translationsFile = $sf_root_dir . "/apps/{$application}/i18n/{$sf_culture}/messages.xml";

            //checking file is exist
            if (file_exists($translationsFile))
            {
                $this->i18nLanguages[$sf_culture] = $language;

                $values = $this->_loadTranslationFile($translationsFile, $sf_culture);

                foreach ($values as $id => $message)
                {
                    $this->messages[$id]['source'] = $message['source'];
                    $this->messages[$id][$sf_culture]['target'] = $message[$sf_culture]['target'];
                }
            }
        }

        $this->i18nLanguages = $this->_getI18nLanguages();
    }

    public function executeUpdateTranslation(sfWebRequest $request)
    {
        $sf_culture = $request->getParameter('sf_culture');
        $ids = $request->getParameter('id');
        $sources = $request->getParameter('source');
        $targets = $request->getParameter('target');

        $application = sfConfig::get('app_frontend_application', 'frontend');
        $sf_root_dir = sfContext::getInstance()->getConfiguration()->getRootDir();

        $dirname = $sf_root_dir . "/apps/{$application}/i18n/{$sf_culture}";
        $filename = $dirname."/messages.xml";

        if (!file_exists($dirname))
        {
            mkdir($dirname, 0777);
        }

        if ($sf_culture)
        {
            $newXML = '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE xliff PUBLIC "-//XLIFF//DTD XLIFF//EN" "http://www.oasis-open.org/committees/xliff/documents/xliff.dtd">
<xliff version="1.0">
  <file source-language="EN" target-language="' . strtolower($sf_culture) . '" datatype="plaintext" original="messages" date="2008-12-14T12:11:22Z" product-name="messages">
    <header/>
    <body>
    </body>
  </file>
</xliff>';

            $dom = new DOMDocument();
            $dom->loadXML($newXML);
            $xpath = new DomXPath($dom);
            $body = $xpath->query('//body')->item(0);

            foreach ($ids as $id)
            {
                $unit = $dom->createElement('trans-unit');
                $unit->setAttribute('id', $id);
                $source = $dom->createElement('source');
                $source->appendChild($dom->createTextNode($sources[$id]));
                $target = $dom->createElement('target');
                $target->appendChild($dom->createTextNode($targets[$id]));

                $unit->appendChild($dom->createTextNode("\n"));
                $unit->appendChild($source);
                $unit->appendChild($dom->createTextNode("\n"));
                $unit->appendChild($target);
                $unit->appendChild($dom->createTextNode("\n"));

                $body->appendChild($dom->createTextNode("\n"));
                $body->appendChild($unit);
                $body->appendChild($dom->createTextNode("\n"));
            }

            $fileNode = $xpath->query('//file')->item(0);
            $fileNode->setAttribute('date', @date('Y-m-d\TH:i:s\Z'));

            // save it and clear the cache for this variant
            $dom->save($filename);
            $this->_clearCacheI18n();
        }
        return $this->redirect('translation/index');
    }

    /**
     * Create Element
     * @return <type>
     */
    public function executeCreateElement(sfWebRequest $request)
    {
        $this->id = 0;
        $this->i18nLanguages = $this->_getI18nLanguages();
        $this->messages = array();
        foreach ($this->i18nLanguages as $sf_culture => $language)
        {
            $this->messages[$sf_culture]['target'] = '';
        }
        $this->source = "";

        //setting page template
        $this->setTemplate('editElement');
        return sfView::SUCCESS;
    }

    /*
   * EDIT element
    */

    public function executeEditElement(sfWebRequest $request)
    {
        $application = sfConfig::get('app_frontend_application', 'frontend');
        $sf_root_dir = sfContext::getInstance()->getConfiguration()->getRootDir();

        $id = $request->getParameter('id');

        $this->id = $id;
        $this->messages = array();
        $this->i18nLanguages = array();

        foreach ($this->_getI18nLanguages() as $sf_culture => $language)
        {
            $translationsFile = $sf_root_dir . "/apps/{$application}/i18n/{$sf_culture}/messages.xml";
            if (file_exists($translationsFile))
            {
                $message = $this->_getElement($translationsFile, $id);
                $this->i18nLanguages[$sf_culture] = $language;
                $this->messages[$sf_culture] = $message ? $message : '';
            }
        }
        //getting source text
        $keys = array_keys($this->i18nLanguages);
        $this->source = (sizeof($this->messages) > 0) ? $this->messages[$keys[0]]['source'] : "";
    }

    /**
     * Update source elements
     */
    public function executeUpdateElement(sfWebRequest $request)
    {
        $application = sfConfig::get('app_frontend_application', 'frontend');
        $sf_root_dir = sfContext::getInstance()->getConfiguration()->getRootDir();

        $id = $request->getParameter("id");
        $source = $request->getParameter('source');
        $targets = $request->getParameter('target');

        foreach ($targets as $sf_culture => $target)
        {
            $filename = $sf_root_dir . "/apps/{$application}/i18n/{$sf_culture}/messages.xml";

            if (file_exists($filename))
            {
                $this->_updateElement($filename, $id, $source, $target);
            }
        }
        //clearing i18n cache file
        $this->_clearCacheI18n();

        return $this->redirect('translation/index');
    }

    private function _getElement($filename, $id)
    {
        $XML = simplexml_load_file($filename);
        if (!$XML)
        {
            return false;
        }
        $translationUnit = $XML->xpath('//trans-unit');
        foreach ($translationUnit as $unit)
        {
            $source = (string) $unit->source;
            if ((string) $unit['id'] == $id)
            {
                return array('source' => $source, 'target' => (string) $unit->target);
            }
        }
        return false;
    }

    private function _updateElement($filename, $id, $source, $target)
    {
        // create a new dom, import the existing xml
        $dom = new DOMDocument();
        $dom->load($filename);
        // find the body element
        $xpath = new DomXPath($dom);
        $units = $xpath->query('//trans-unit');
        $body = $xpath->query('//body')->item(0);
        $count = 0;
        $found = false;
        // for each of the existin units
        foreach ($units as $unit)
        {
            if ($unit->getAttribute('id') == $id)
            {
                $found = true;
                foreach ($unit->childNodes as $node)
                {
                    // source node
                    if ($node->nodeName == 'source')
                    {
                        $node->nodeValue = $source;
                    }
                    if ($node->nodeName == 'target')
                    {
                        $node->nodeValue = $target;
                    }
                }
            }
            if ($found)
            {
                break;
            }
            $count++;
        }

        $lastNodes = $xpath->query('//trans-unit[not(@id <= preceding-sibling::trans-unit/@id) and not(@id <= following-sibling::trans-unit/@id)]');
        if (null !== $last = $lastNodes->item(0))
        {
            $count = intval($last->getAttribute('id'));
        }

        if (!$found)
        {
            $unit = $dom->createElement('trans-unit');
            if ($id)
            {
                $unit->setAttribute('id', $id);
            } else
            {
                $unit->setAttribute('id', ++$count);
            }

            $sourceNode = $dom->createElement('source');
            $sourceNode->appendChild($dom->createTextNode($source));
            $targetNode = $dom->createElement('target');
            $targetNode->appendChild($dom->createTextNode($target));

            $unit->appendChild($dom->createTextNode("\n"));
            $unit->appendChild($sourceNode);
            $unit->appendChild($dom->createTextNode("\n"));
            $unit->appendChild($targetNode);
            $unit->appendChild($dom->createTextNode("\n"));

            $body->appendChild($dom->createTextNode("\n"));
            $body->appendChild($unit);
            $body->appendChild($dom->createTextNode("\n"));
        }

        $fileNode = $xpath->query('//file')->item(0);
        $fileNode->setAttribute('date', @date('Y-m-d\TH:i:s\Z'));
        $dom->save($filename);
    }

    private function _getI18nLanguages()
    {
        $langs = Doctrine::getTable('Language')->getLangOption();

        return $langs;
    }

    private function _clearCacheI18n()
    {
        $application = sfConfig::get('app_frontend_application', 'frontend');
        $sfRootDir = sfContext::getInstance()->getConfiguration()->getRootDir();

        $clearPath = $sfRootDir . "/cache/{$application}/*/i18n";
        sfToolkit::clearGlob($clearPath);
    }

    private function _loadTranslationFile($filename, $sf_culture)
    {
        //load it.
        $XML = simplexml_load_file($filename);
        if (!$XML)
        {
            return false;
        }
        $translationUnit = $XML->xpath('//trans-unit');
        $translations = array();
        foreach ($translationUnit as $unit)
        {
            $source = (string) $unit->source;
            $translations[(string) $unit['id']]['source'] = $source;
            $translations[(string) $unit['id']][$sf_culture]['target'] = (string) $unit->target;
        }
        return $translations;
    }
}
