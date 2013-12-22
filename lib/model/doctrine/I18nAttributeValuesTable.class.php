<?php


class I18nAttributeValuesTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('I18nAttributeValues');
    }
}