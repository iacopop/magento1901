<?php

class DataExchange_Iris_Model_Dal_Order_Default extends DataExchange_Iris_Model_Dal_Order_Abstract {
    
    const ACTION_TYPE_INSERT = "insert";
    const ACTION_STATUS_TO_BE_PROCESSED = "to_be_processed";        
    const ACTION_STATUS_PROCESSED = "processed";        
    


    public function insertAction(DataExchange_Iris_Model_Data_Order_Default $object) {
        Mage::helper("iris/log")->log("New INSERT action for order: ".$object->getIncrementId());
       

        $insertModelAction = Mage::getModel("iris/action_order");
        $insertModelAction->setData("action_type",$object->getActionType());
        $insertModelAction->setData("status",$object->getStatus());
        $insertModelAction->setData("note",$object->getNote());
        $insertModelAction->setData("created_at",$object->getCreatedAt());
        $insertModelAction->setData("updated_at",$object->getUpdatedAt());
        $insertModelAction->setData("source",$object->getSource());
        $insertModelAction->setData("increment_id",$object->getIncrementId());
        $insertModelAction->setData("order_status",$object->getOrderStatus());
        $insertModelAction->setData("tracking_code",$object->getTrackingCode());
        $insertModelAction->setData("coupon_code",$object->getCouponCode());
        $insertModelAction->setData("shipping_description",$object->getShippingDescription());
        $insertModelAction->setData("store_id",$object->getStoreId());
        $insertModelAction->setData("base_discount_amount",$object->getBaseDiscountAmount());
        $insertModelAction->setData("base_grand_total",$object->getBaseGrandTotal());
        $insertModelAction->setData("base_shipping_amount",$object->getBaseShippingAmount());
        $insertModelAction->setData("base_shipping_tax_amount",$object->getBaseShippingTaxAmount());
        $insertModelAction->setData("base_subtotal",$object->getBaseSubtotal());
        $insertModelAction->setData("base_tax_amount",$object->getBaseTaxAmount());
        $insertModelAction->setData("base_to_global_rate",$object->getBaseToGlobalRate());
        $insertModelAction->setData("base_to_order_rate",$object->getBaseToOrderRate());
        $insertModelAction->setData("discount_amount",$object->getDiscountAmount());
        $insertModelAction->setData("grand_total",$object->getGrandTotal());
        $insertModelAction->setData("shipping_amount",$object->getShippingAmount());
        $insertModelAction->setData("shipping_tax_amount",$object->getShippingTaxAmount());
        $insertModelAction->setData("subtotal",$object->getSubtotal());
        $insertModelAction->setData("tax_amount",$object->getTaxAmount());
        $insertModelAction->setData("total_qty_ordered",$object->getTotalQtyOrdered());
        $insertModelAction->setData("base_subtotal_incl_tax",$object->getBaseSubtotalInclTax());
        $insertModelAction->setData("subtotal_incl_tax",$object->getSubtotalInclTax());
        $insertModelAction->setData("base_currency_code",$object->getBaseCurrencyCode());
        $insertModelAction->setData("global_currency_code",$object->getGlobalCurrencyCode());
        $insertModelAction->setData("order_currency_code",$object->getOrderCurrencyCode());
        $insertModelAction->setData("remote_ip",$object->getRemoteIp());
        $insertModelAction->setData("payment_method",$object->getPaymentMethod());
        $insertModelAction->setData("shipping_method",$object->getShippingMethod());
        $insertModelAction->setData("order_created_at",$object->getOrderCreatedAt());
        $insertModelAction->setData("total_item_count",$object->getTotalItemCount());
        $insertModelAction->setData("shipping_incl_tax",$object->getShippingInclTax());
        $insertModelAction->setData("base_shipping_incl_tax",$object->getBaseShippingInclTax());
        $insertModelAction->setData("customer_id",$object->getCustomerId());
        $insertModelAction->setData("customer_email",$object->getCustomerEmail());
        $insertModelAction->setData("billing_firstname",$object->getBillingFirstname());
        $insertModelAction->setData("billing_lastname",$object->getBillingLastname());
        $insertModelAction->setData("billing_street",$object->getBillingStreet());
        $insertModelAction->setData("billing_co",$object->getBillingCo());
        $insertModelAction->setData("billing_zipcode",$object->getBillingZipcode());
        $insertModelAction->setData("billing_city",$object->getBillingCity());
        $insertModelAction->setData("billing_region",$object->getBillingRegion());
        $insertModelAction->setData("billing_nation",$object->getBillingNation());
        $insertModelAction->setData("billing_codice_fiscale",$object->getBillingCodiceFiscale());
        $insertModelAction->setData("billing_vat",$object->getBillingVat());
        $insertModelAction->setData("billing_company",$object->getBillingCompany());
        $insertModelAction->setData("billing_phone",$object->getBillingPhone());
        $insertModelAction->setData("shipping_firstname",$object->getShippingFirstname());
        $insertModelAction->setData("shipping_lastname",$object->getShippingLastname());
        $insertModelAction->setData("shipping_street",$object->getShippingStreet());
        $insertModelAction->setData("shipping_co",$object->getShippingCo());
        $insertModelAction->setData("shipping_zipcode",$object->getShippingZipcode());
        $insertModelAction->setData("shipping_city",$object->getShippingCity());
        $insertModelAction->setData("shipping_region",$object->getShippingRegion());
        $insertModelAction->setData("shipping_nation",$object->getShippingNation());
        $insertModelAction->setData("shipping_phone",$object->getShippingPhone());
        $insertModelAction->setData("billing_address_id",$object->getBillingAddressId());
        $insertModelAction->setData("shipping_address_id",$object->getShippingAddressId());
   
        $insertedModel = $insertModelAction->save();
        
        
        foreach ($object->getRows() as $row) {

            $insertModelActionRow = Mage::getModel("iris/action_order_rows");
            $insertModelActionRow->setData("action_order_id",$insertedModel->getId());
            $insertModelActionRow->setData("product_id",$row->getProductId());            
            $insertModelActionRow->setData("product_type",$row->getProductType());            
            $insertModelActionRow->setData("weight",$row->getWeight());            
            $insertModelActionRow->setData("is_virtual",$row->getIsVirtual());            
            $insertModelActionRow->setData("sku",$row->getSku());            
            $insertModelActionRow->setData("name",$row->getName());            
            $insertModelActionRow->setData("qty_ordered",$row->getQtyOrdered());            
            $insertModelActionRow->setData("base_cost",$row->getBaseCost());            
            $insertModelActionRow->setData("price",$row->getPrice());            
            $insertModelActionRow->setData("base_price",$row->getBasePrice());            
            $insertModelActionRow->setData("original_price",$row->getOriginalPrice());            
            $insertModelActionRow->setData("base_original_price",$row->getBaseOriginalPrice());            
            $insertModelActionRow->setData("tax_percent",$row->getTaxPercent());            
            $insertModelActionRow->setData("tax_amount",$row->getTaxAmount());            
            $insertModelActionRow->setData("base_tax_amount",$row->getBaseTaxAmount());            
            $insertModelActionRow->setData("discount_amount",$row->getDiscountAmount());            
            $insertModelActionRow->setData("base_discount_amount",$row->getBaseDiscountAmount());            
            $insertModelActionRow->setData("row_total",$row->getRowTotal());            
            $insertModelActionRow->setData("base_row_total",$row->getBaseRowTotal());            
            $insertModelActionRow->setData("row_weight",$row->getRowWeight());            
            $insertModelActionRow->setData("base_tax_before_discount",$row->getBaseTaxBeforeDiscount());            
            $insertModelActionRow->setData("tax_before_discount",$row->getTaxBeforeDiscount());            
            $insertModelActionRow->setData("price_incl_tax",$row->getPriceInclTax());            
            $insertModelActionRow->setData("base_price_incl_tax",$row->getBasePriceInclTax());            
            $insertModelActionRow->setData("row_total_incl_tax",$row->getRowTotalInclTax());            
            $insertModelActionRow->setData("base_row_total_incl_tax",$row->getBaseRowTotalInclTax());    
            $insertModelActionRow->save();
            
        }
        
        return $insertedModel->getId();
                                
    }
}
?>
