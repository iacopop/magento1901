<?php
/**
 * Created by PhpStorm.
 * User: iacopop
 * Date: 10/06/14
 * Time: 16.05
 */ 
class Custom_Sort_Model_Config extends Mage_Catalog_Model_Config
{
    /**
     * Retrieve Attributes Used for Sort by as array
     * key = code, value = name
     *
     * @return array
     */
    public function getAttributeUsedForSortByArray()
    {
        $options = array(
            'position'  => Mage::helper('catalog')->__('Position'),
            'created_at'  => Mage::helper('catalog')->__('Created at')
        );
        foreach ($this->getAttributesUsedForSortBy() as $attribute) {
            /* @var $attribute Mage_Eav_Model_Entity_Attribute_Abstract */
            $options[$attribute->getAttributeCode()] = $attribute->getStoreLabel();
        }

        return $options;
    }

}