<?php

class DataExchange_Iris_Helper_Attribute extends Mage_Core_Helper_Abstract {

    /**
     * Crea un attributo prodotto
     * @param type $attribute_code
     * @param type $attribute_type
     */
    public function createProductAttribute($attribute_code, $attribute_type) {
        $installer = new Mage_Eav_Model_Entity_Setup('core_setup');

        $installer->startSetup();

        switch ($attribute_type) {
            case "text":
                $installer->addAttribute('catalog_product', $attribute_code, array(
                    'type'                       => 'varchar',
                    'label'                      => $attribute_code,
                    'input'                      => 'text',
                    'required'                   => false,
                    'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    'group'                     => 'General'
                ));  
                $installer->endSetup();
                break;
            case "select":
                $installer->addAttribute('catalog_product', $attribute_code, array(
                    'type'                       => 'int',
                    'label'                      => $attribute_code,
                    'input'                      => 'select',
                    'is_user_defined'            => '1',
                    'required'                   => false,
                    'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    'group'                      => 'General',
                    'source'                     => 'eav/entity_attribute_source_table',
                ));  
                $installer->endSetup();
                break;                
            case "multiselect":
                $installer->addAttribute('catalog_product', $attribute_code, array(
                    'type'                       => 'varchar',
                    'label'                      => $attribute_code,
                    'input'                      => 'multiselect',
                    'required'                   => false,
                    'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    'group'                     => 'General'
                ));  
                $installer->endSetup();
                break;
            case "textarea":
                $installer->addAttribute('catalog_product', $attribute_code, array(
                    'type'                       => 'textarea',
                    'label'                      => $attribute_code,
                    'input'                      => 'text',
                    'required'                   => false,
                    'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                    'group'                     => 'General'
                ));  
                $installer->endSetup();
                break;            
            default:
                break;
        }     
    }

    /**
     * Ritorna il valore della option per un attributo select/dropdown
     * @param type $arg_attribute
     * @param type $arg_value
     * @return int
     * used for select / magento drop down attributes to check if they exist
     */
    function getAttributeOptionValue($arg_attribute, $arg_value) {
        $attribute_model = Mage::getModel('eav/entity_attribute');
        $attribute_options_model = Mage::getModel('eav/entity_attribute_source_table');

        $attribute_code = $attribute_model->getIdByCode('catalog_product', $arg_attribute);
        $attribute = $attribute_model->load($attribute_code);

        $attribute_table = $attribute_options_model->setAttribute($attribute);
        $options = $attribute_options_model->getAllOptions(false);

        foreach ($options as $option) {
            if ($option['label'] == $arg_value) {
                return $option['value'];
            }
        }

        return false;
    }

    /**
     * Aggiunge l'opzione ad un attributo select/dropdown
     * @return int / id of the value
     */
    function addAttributeOption($arg_attribute, $arg_value) {
        $attribute_model = Mage::getModel('eav/entity_attribute');
        $attribute_options_model = Mage::getModel('eav/entity_attribute_source_table');

        $attribute_code = $attribute_model->getIdByCode('catalog_product', $arg_attribute);
        $attribute = $attribute_model->load($attribute_code);

        $attribute_table = $attribute_options_model->setAttribute($attribute);
        $options = $attribute_options_model->getAllOptions(false);

        $value['option'] = array($arg_value);
        $result = array('value' => $value);
        $attribute->setData('option', $result);
        $attribute->save();

        return $this->getAttributeOptionValue($arg_attribute, $arg_value);
    }

}