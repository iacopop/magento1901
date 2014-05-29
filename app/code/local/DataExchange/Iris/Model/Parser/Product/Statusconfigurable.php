<?php

class DataExchange_Iris_Model_Parser_Product_Statusconfigurable {

    const ENABLED = 1;
    const DISABLED = 2;

    public function toOptionArray() {

        return array(
            array(
                'value' => self::ENABLED,
                'label' => Mage::helper('iris')->__('Enabled')
            ),
            array(
                'value' => self::DISABLED,
                'label' => Mage::helper('iris')->__('Disabled')
            )
        );
    }

}