<?php

class DataExchange_Iris_Model_Consumer_Order_Csv_VenchiCsv_Default extends DataExchange_Iris_Model_Consumer_Order_Csv_Default {
    private $exportDirectory;

    function __construct($exportDirectory) {
        $this->exportDirectory = $exportDirectory;
    }
    
    public function consumeRows() {
        //prendo tutte le righe ancora da processare ordinate in modo crescente
        $collection = Mage::getModel("iris/action_order")->getCollection()
                ->addFieldToFilter('status', DataExchange_Iris_Model_Dal_Order_Default::ACTION_STATUS_TO_BE_PROCESSED)
                ->setOrder("id", Varien_Data_Collection::SORT_ORDER_ASC);

        //Consumo le righe ordine per l'export
        $exportOrders = array();
        $exportCustomers = array();
        foreach ($collection as $action) {
            if ($action->getActionType() == DataExchange_Iris_Model_Dal_Order_Default::ACTION_TYPE_INSERT) {
                $exportOrders[] = $this->consumeOrder($action->getId());
                $exportCustomers[] = $this->consumeCustomer($action->getId());
                $action->setHasBeenProcessed();
            } else {
                Mage::helper("iris/log")->log("Azione per ordine non implementata");
            }
        }   
        
        //export cusstomers
        $dateString = date("Y_m_d_H_i_s");
        $fpCust = fopen($this->exportDirectory.DS."customers_export_".$dateString.".csv", 'w');
        
        $headerCustomerLine = array();      
        if(isset($exportCustomers[0])){
            foreach ($exportCustomers[0] as $key => $value) {
                $headerCustomerLine[] = $key;
            }
        }
        

        fputcsv($fpCust, $headerCustomerLine,",",'"');        

         
        foreach ($exportCustomers as $customerLine) {            
            fputcsv($fpCust, $customerLine,",",'"');
        }


        fclose($fpCust);          
        
        
        //export ordini
        $dateString = date("Y_m_d_H_i_s");
        $fp = fopen($this->exportDirectory.DS."orders_export_".$dateString.".csv", 'w');
        
        $headerLine = array();      
        if(isset($exportOrders[0][0])){
            foreach ($exportOrders[0][0] as $key => $value) {
                $headerLine[] = $key;
            }
        }
        

        fputcsv($fp, $headerLine,",",'"');        

        foreach ($exportOrders as $order) {            
            foreach ($order as $orderLine) {            
                fputcsv($fp, $orderLine,",",'"');
            }
        }

        fclose($fp);        
    }    

    public function consumeOrder($action_order_id) {
        $actionOrder = Mage::getModel("iris/action_order")->load($action_order_id);
        Mage::helper("iris/log")->log("Exporting order ".$actionOrder->getIncrementId());
        $exportOrder = array();
        $actionOrderArray = array();
        $actionOrderArray["increment_id"] = $actionOrder->getIncrementId();
        
        $formattedDate = date_format(new Datetime($actionOrder->getUpdatedAt()), 'Y-m-d');
        
        $actionOrderArray["created_at"] = $formattedDate;
        $actionOrderArray["order_status"] = $actionOrder->getOrderStatus();
        $actionOrderArray["coupon_code"] = $actionOrder->getCouponCode();
        $actionOrderArray["store_id"] = $actionOrder->getStoreId();
        $actionOrderArray["base_discount_amount"] = $actionOrder->getBaseDiscountAmount();
        $actionOrderArray["base_grand_total"] = $actionOrder->getBaseGrandTotal();
        $actionOrderArray["base_shipping_amount"] = $actionOrder->getBaseShippingAmount();
        $actionOrderArray["base_shipping_incl_tax"] = $actionOrder->getBaseShippingInclTax();
        $actionOrderArray["base_shipping_tax_amount"] = $actionOrder->getBaseShippingTaxAmount();       
        $actionOrderArray["base_subtotal"] = $actionOrder->getBaseSubtotal();        
        $actionOrderArray["base_tax_amount"] = $actionOrder->getBaseTaxAmount();
        $actionOrderArray["base_subtotal_incl_tax"] = $actionOrder->getBaseSubtotalInclTax();        
        $actionOrderArray["base_to_global_rate"] = $actionOrder->getBaseToGlobalRate();
        $actionOrderArray["base_to_order_rate"] = $actionOrder->getBaseToOrderRate();
        $actionOrderArray["total_qty_ordered"] = $actionOrder->getTotalQtyOrdered();
        $actionOrderArray["base_currency_code"] = $actionOrder->getBaseCurrencyCode();
        $actionOrderArray["order_currency_code"] = $actionOrder->getOrderCurrencyCode();
        $actionOrderArray["remote_ip"] = $actionOrder->getRemoteIp();
        $actionOrderArray["shipping_method"] = $actionOrder->getShippingMethod();  
        $actionOrderArray["customer_id"] = $actionOrder->getCustomerId();
        $actionOrderArray["customer_email"] = $actionOrder->getCustomerEmail();
        $actionOrderArray["billing_address_id"] = $actionOrder->getBillingAddressId();
        $actionOrderArray["billing_firstname"] = $actionOrder->getBillingFirstname();
        $actionOrderArray["billing_lastname"] = $actionOrder->getBillingLastname();  
        $actionOrderArray["billing_street"] = $actionOrder->getBillingStreet();
        $actionOrderArray["billing_co"] = $actionOrder->getBillingCo();
        $actionOrderArray["billing_zipcode"] = $actionOrder->getBillingZipcode();
        $actionOrderArray["billing_city"] = $actionOrder->getBillingCity();  
        $actionOrderArray["billing_region"] = $actionOrder->getBillingRegion();
        $actionOrderArray["billing_nation"] = $actionOrder->getBillingNation();
        $actionOrderArray["billing_codice_fiscale"] = $actionOrder->getBillingCodiceFiscale();
        $actionOrderArray["billing_vat"] = $actionOrder->getBillingVat();  
        $actionOrderArray["billing_company"] = $actionOrder->getBillingCompany();
        $actionOrderArray["billing_phone"] = $actionOrder->getBillingPhone();
        $actionOrderArray["shipping_address_id"] = $actionOrder->getShippingAddressId();
        $actionOrderArray["shipping_firstname"] = $actionOrder->getShippingFirstname();
        $actionOrderArray["shipping_lastname"] = $actionOrder->getShippingLastname();       
        $actionOrderArray["shipping_street"] = $actionOrder->getShippingStreet();
        $actionOrderArray["shipping_co"] = $actionOrder->getShippingCo();
        $actionOrderArray["shipping_zipcode"] = $actionOrder->getShippingZipcode();  
        $actionOrderArray["shipping_city"] = $actionOrder->getShippingCity();
        $actionOrderArray["shipping_region"] = $actionOrder->getShippingRegion();
        $actionOrderArray["shipping_nation"] = $actionOrder->getShippingNation();
        $actionOrderArray["shipping_phone"] = $actionOrder->getShippingPhone();       
        
        
                

        foreach ($actionOrder->getRowsCollection() as $row) {
            
            $actionRowArray = array();
            $actionRowArray["row_sku"] = $row->getSku();
            $actionRowArray["row_product_id"] = $row->getProductId();
            $actionRowArray["row_weight"] = $row->getWeight();
            $actionRowArray["row_name"] = $row->getName();
            $actionRowArray["row_qty_ordered"] = $row->getQtyOrdered();
            $actionRowArray["row_base_cost"] = $row->getBaseCost();
            $actionRowArray["row_price"] = $row->getPrice();
            $actionRowArray["row_base_price"] = $row->getBasePrice();
            $actionRowArray["row_tax_percent"] = $row->getTaxPercent();
            $actionRowArray["row_base_tax_amount"] = $row->getBaseTaxAmount();
            $actionRowArray["row_base_discount_amount"] = $row->getBaseDiscountAmount();
            $actionRowArray["row_base_row_total"] = $row->getBaseRowTotal();
            $actionRowArray["row_weight"] = $row->getRowWeight();
            $actionRowArray["row_base_tax_before_discount"] = $row->getBaseTaxBeforeDiscount();
            $actionRowArray["row_tax_before_discount"] = $row->getTaxBeforeDiscount();
            $actionRowArray["row_base_price_incl_tax"] = $row->getBasePriceInclTax();
            $actionRowArray["row_base_row_total_incl_tax"] = $row->getBaseRowTotalInclTax();         

            
            $arrayFullRow = array_merge($actionOrderArray, $actionRowArray);      
            
            $exportOrder[] = $arrayFullRow;

        }

        return $exportOrder;
    }
    
    public function consumeCustomer($action_order_id) {
        $actionOrder = Mage::getModel("iris/action_order")->load($action_order_id);
        Mage::helper("iris/log")->log("Exporting customer ".$actionOrder->getCustomerEmail());
        $actionCustomerArray = array();
        $actionCustomerArray["increment_id"] = $actionOrder->getIncrementId();
        $actionCustomerArray["customer_id"] = $actionOrder->getCustomerId();
        $actionCustomerArray["customer_email"] = $actionOrder->getCustomerEmail();
        $actionCustomerArray["billing_address_id"] = $actionOrder->getBillingAddressId();
        $actionCustomerArray["billing_firstname"] = $actionOrder->getBillingFirstname();
        $actionCustomerArray["billing_lastname"] = $actionOrder->getBillingLastname();  
        $actionCustomerArray["billing_street"] = $actionOrder->getBillingStreet();
        $actionCustomerArray["billing_co"] = $actionOrder->getBillingCo();
        $actionCustomerArray["billing_zipcode"] = $actionOrder->getBillingZipcode();
        $actionCustomerArray["billing_city"] = $actionOrder->getBillingCity();  
        $actionCustomerArray["billing_region"] = $actionOrder->getBillingRegion();
        $actionCustomerArray["billing_nation"] = $actionOrder->getBillingNation();
        $actionCustomerArray["billing_codice_fiscale"] = $actionOrder->getBillingCodiceFiscale();
        $actionCustomerArray["billing_vat"] = $actionOrder->getBillingVat();  
        $actionCustomerArray["billing_company"] = $actionOrder->getBillingCompany();
        $actionCustomerArray["billing_phone"] = $actionOrder->getBillingPhone();
        $actionCustomerArray["shipping_address_id"] = $actionOrder->getShippingAddressId();
        $actionCustomerArray["shipping_firstname"] = $actionOrder->getShippingFirstname();
        $actionCustomerArray["shipping_lastname"] = $actionOrder->getShippingLastname();       
        $actionCustomerArray["shipping_street"] = $actionOrder->getShippingStreet();
        $actionCustomerArray["shipping_co"] = $actionOrder->getShippingCo();
        $actionCustomerArray["shipping_zipcode"] = $actionOrder->getShippingZipcode();  
        $actionCustomerArray["shipping_city"] = $actionOrder->getShippingCity();
        $actionCustomerArray["shipping_region"] = $actionOrder->getShippingRegion();
        $actionCustomerArray["shipping_nation"] = $actionOrder->getShippingNation();
        $actionCustomerArray["shipping_phone"] = $actionOrder->getShippingPhone();       
                                
        return $actionCustomerArray;
    }    
    

    
}

?>
