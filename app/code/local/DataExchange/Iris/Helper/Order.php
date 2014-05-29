<?php

class OrderExportResult {
    /** @var String  */ 
    public $result_code;    
    /** @var OrderExport[]  */
    public $orders;   
}

class OrderExport {    
    /** @var OrderHeader  */ 
    public $header;
    /** @var OrderRow[]  */
    public $rows;        
    /** @var OrderCustomer  */
    public $customer;      
}

class OrderHeader {
    /** @var String  */
    public $created_at;
    /** @var String  */
    public $updated_at;
    /** @var String  */
    public $source;
    /** @var String  */
    public $increment_id;
    /** @var String  */
    public $status;
    /** @var String  */
    public $tracking_code;
    /** @var String  */
    public $coupon_code;
    /** @var String  */
    public $shipping_description;
    /** @var String  */
    public $store_id;
    /** @var String  */
    public $base_discount_amount;
    /** @var String  */
    public $base_grand_total;
    /** @var String  */
    public $base_shipping_amount;
    /** @var String  */
    public $base_shipping_tax_amount;
    /** @var String  */
    public $base_subtotal;
    /** @var String  */
    public $base_tax_amount;
    /** @var String  */
    public $base_to_global_rate;
    /** @var String  */
    public $base_to_order_rate;
    /** @var String  */
    public $discount_amount;
    /** @var String  */
    public $grand_total;
    /** @var String  */
    public $shipping_amount;
    /** @var String  */
    public $shipping_tax_amount;    
    /** @var String  */
    public $subtotal;    
    /** @var String  */
    public $tax_amount;    
    /** @var String  */
    public $total_qty_ordered;    
    /** @var String  */
    public $base_subtotal_incl_tax;    
    /** @var String  */
    public $subtotal_incl_tax;    
    /** @var String  */
    public $base_currency_code;    
    /** @var String  */
    public $global_currency_code;    
    /** @var String  */
    public $order_currency_code;    
    /** @var String  */
    public $remote_ip;    
    /** @var String  */
    public $payment_method;    
    /** @var String  */
    public $shipping_method;    
    /** @var String  */
    public $total_item_count;    
    /** @var String  */
    public $shipping_incl_tax;    
    /** @var String  */
    public $cod_fee;        
    /** @var String  */
    public $base_cod_fee;        
    /** @var String  */
    public $cod_tax_amount;        
    /** @var String  */
    public $base_cod_tax_amount;        
    /** @var String  */
    public $anonymous_package;                           
    /** @var String  */
    public $points_balance_change;    
    /** @var String  */
    public $base_money_for_points;          
}

class OrderRow {
    /** @var String  */
    public $order_id;
    /** @var String  */
    public $sku;
    /** @var String  */
    public $name;
    /** @var String  */
    public $qty;            
    /** @var String  */
    public $is_expiry;       
    /** @var String  */
    public $date_expiry;           
    /** @var String  */
    public $base_cost;                
    /** @var String  */
    public $price;
    /** @var String  */
    public $base_price;
    /** @var String  */
    public $original_price;
    /** @var String  */
    public $base_original_price;
    /** @var String  */
    public $tax_percent;
    /** @var String  */
    public $tax_amount;
    /** @var String  */
    public $base_tax_amount;
    /** @var String  */
    public $discount_amount;
    /** @var String  */
    public $base_discount_amount;
    /** @var String  */
    public $row_total;
    /** @var String  */
    public $base_row_total;
    /** @var String  */
    public $row_weight;
    /** @var String  */
    public $base_tax_before_discount;
    /** @var String  */
    public $price_incl_tax;
    /** @var String  */
    public $base_price_incl_tax;
    /** @var String  */
    public $base_row_total_incl_tax;       
}

class OrderCustomer {
    /** @var String  */
    public $customer_id;      
    /** @var String  */
    public $customer_email;  
    /** @var String  */
    public $customer_group;      
    /** @var String  */
    public $billing_firstname;    
    /** @var String  */
    public $billing_lastname;    
    /** @var String  */
    public $billing_street;    
    /** @var String  */
    public $biling_co;    
    /** @var String  */
    public $billing_zipcode;
    /** @var String  */
    public $billing_city;    
    /** @var String  */
    public $billing_region;    
    /** @var String  */
    public $billing_nation;    
    /** @var String  */
    public $billing_codice_fiscale;      
    /** @var String  */
    public $billing_vat;      
    /** @var String  */
    public $billing_company;      
    /** @var String  */
    public $billing_phone;      
    /** @var String  */
    public $shipping_firstname;      
    /** @var String  */
    public $shipping_lastname;      
    /** @var String  */
    public $shipping_street;      
    /** @var String  */
    public $shipping_co;      
    /** @var String  */
    public $shipping_zipcode;      
    /** @var String  */
    public $shipping_city;      
    /** @var String  */
    public $shipping_region;      
    /** @var String  */
    public $shipping_nation;      
    /** @var String  */
    public $shipping_phone;      
    /** @var String  */
    public $billing_address_id;      
    /** @var String  */
    public $shipping_address_id;          
    /** @var String  */
    public $customer_type;    
}
class DataExchange_Iris_Helper_Order {
    /* CAMPI DA ESPORTARE

    state, status, coupon_code, shipping_description, store_id, customer, base_discount_amount, base_grand_total, base_shipping_amount, base_shipping_tax_amount, base_subtotal, base_tax_amount, base_to_global_rate, base_to_order_rate, discount_amount, grand_total, shipping_amount, shipping_tax_amount, subtotal, tax_amount, total_qty_ordered, base_subtotal_incl_tax, subtotal_incl_tax, increment_id, base_currency_code, global_currency_code, order_currency_code, remote_ip, shipping_method, created_at, total_item_count, shipping_incl_tax, base_shipping_incl_tax

     */
    
    public function getOrderExportObject(){
        $obj = new OrderExportResult();
        return $obj;
    }

    /**
     * Completes the Shipment, followed by completing the Order life-cycle
     * It is assumed that the Invoice has already been generated
     * and the amount has been captured.
     */
    public function completeShipment($orderIncrementId, $shipmentTrackingNumber, $customerEmailComments, $shipmentCarrierCode, $shipmentCarrierTitle, $send_email = false) {
        //doing invoice automatically for earn points
        $order = Mage::getModel('sales/order')
                ->loadByIncrementId($orderIncrementId); 
        
        if (!$order->getId()) {
            Mage::throwException("Order does not exist, for the Shipment process to complete");
        }        
        

        try {
            if (!$order->canInvoice()) {
                Mage::helper("iris/log")->log("Unable to create invoice for order " . $orderIncrementId);
            } else {

                $invoice = Mage::getModel('sales/service_order', $order)->prepareInvoice();

                if (!$invoice->getTotalQty()) {
                    Mage::throwException(Mage::helper('core')->__('Cannot create an invoice without products.'));
                }

                $invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_OFFLINE);
                //Or you can use
                //$invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_ONLINE);
                $invoice->register();
                $transactionSave = Mage::getModel('core/resource_transaction')
                        ->addObject($invoice)
                        ->addObject($invoice->getOrder());

                $transactionSave->save();
            }
        } catch (Mage_Core_Exception $e) {
            Mage::helper("iris/log")->log("Error: Unable to create invoice for order " . $orderIncrementId);
        }
        //- See more at: http://excellencemagentoblog.com/useful-code-snippets#sthash.ak38fhBQ.dpuf        






        if ($order->canShip()) {
            try {
                $shipment = Mage::getModel('sales/service_order', $order)
                        ->prepareShipment($this->__getItemQtys($order));

                /**
                 * Carrier Codes can be like "ups" / "fedex" / "custom",
                 * but they need to be active from the System Configuration area.
                 * These variables can be provided custom-value, but it is always
                 * suggested to use Order values
                 */
                //$shipmentCarrierCode = 'SPECIFIC_CARRIER_CODE';
                //$shipmentCarrierTitle = 'SPECIFIC_CARRIER_TITLE';

                $arrTracking = array(
                    'carrier_code' => isset($shipmentCarrierCode) ? $shipmentCarrierCode : $order->getShippingCarrier()->getCarrierCode(),
                    'title' => isset($shipmentCarrierTitle) ? $shipmentCarrierTitle : $order->getShippingCarrier()->getConfigData('title'),
                    'number' => $shipmentTrackingNumber,
                );

                $track = Mage::getModel('sales/order_shipment_track')->addData($arrTracking);
                $shipment->addTrack($track);

                // Register Shipment
                $shipment->register();

                // Save the Shipment
                $this->__saveShipment($shipment, $order, $customerEmailComments, $send_email);

                // Finally, Save the Order
                $this->__saveOrder($order);
            } catch (Exception $e) {
                throw $e;
            }
        }else{
            Mage::throwException("Cannot ship order ".$orderIncrementId);            
        }
    }
    
    /**
     * Get the Quantities shipped for the Order, based on an item-level
     * This method can also be modified, to have the Partial Shipment functionality in place
     *
     * @param $order Mage_Sales_Model_Order
     * @return array
     */
    private function __getItemQtys(Mage_Sales_Model_Order $order) {
        $qty = array();

        foreach ($order->getAllItems() as $_eachItem) {
            if ($_eachItem->getParentItemId()) {
                $qty[$_eachItem->getParentItemId()] = $_eachItem->getQtyOrdered();
            } else {
                $qty[$_eachItem->getId()] = $_eachItem->getQtyOrdered();
            }
        }

        return $qty;
    }

    /**
     * Saves the Shipment changes in the Order
     *
     * @param $shipment Mage_Sales_Model_Order_Shipment
     * @param $order Mage_Sales_Model_Order
     * @param $customerEmailComments string
     */
    private function __saveShipment(Mage_Sales_Model_Order_Shipment $shipment, Mage_Sales_Model_Order $order, $customerEmailComments = '', $send_email) {
        $shipment->getOrder()->setIsInProcess(true);
        $transactionSave = Mage::getModel('core/resource_transaction')
                ->addObject($shipment)
                ->addObject($order)
                ->save();

        $emailSentStatus = $shipment->getData('email_sent');
        if ($send_email && !$emailSentStatus) {
            $shipment->sendEmail(true, $customerEmailComments);
            $shipment->setEmailSent(true);
        }

        return $this;
    }

    /**
     * Saves the Order, to complete the full life-cycle of the Order
     * Order status will now show as Complete
     *
     * @param $order Mage_Sales_Model_Order
     */
    private function __saveOrder(Mage_Sales_Model_Order $order) {
        $order->setData('state', Mage_Sales_Model_Order::STATE_COMPLETE);
        $order->setData('status', Mage_Sales_Model_Order::STATE_COMPLETE);

        $order->save();

        return $this;
    }
    
    
    /**
     * Cambia lo stato dell'ordine
     * @param type $orderId
     * @param type $status
     */
    public function updateOrderStatus($orderId, $status) {
        $order = Mage::getModel("sales/order")->loadByIncrementId($orderId);
        
        if ($order->getId()) {
            
            //status solo "complete" e "canceled"
            $order->setData('status', $status);
            $order->save();
            Mage::helper('iris/log')->log('Order update: ' . $order->getId() . " with status: " . $order->getStatus());
            return true;
        } else {
            Mage::helper('iris/log')->log('Unable to update order: ' . $orderId . " with status: " . $status);
            return false;
            
        }
    }
    
    public function createCreditMemo($orderIncrementId) {
        $order = Mage::getModel("sales/order")->loadByIncrementId($orderIncrementId);

        if ($order->getId()) {
            //controllo se posso fare la nota di credito
            if (!$order->canCreditmemo()) {
                $order->setStatus('canceled');
                $order->save();
            } else {
                $data = array();


                $service = Mage::getModel('sales/service_order', $order);

                $creditmemo = $service->prepareCreditmemo($data);

                $creditmemo->setPaymentRefundDisallowed(true)->register();


                Mage::getModel('core/resource_transaction')
                        ->addObject($creditmemo)
                        ->addObject($order)
                        ->save();
                //- See more at: http://excellencemagentoblog.com/useful-code-snippets#sthash.fFmGdvFr.dpuf                        
            }
        }
    }

    /**
     * Esporta l'ordine in formato array
     * @param type $orderId è l'entityId dell'ordine
     */
    public function exportSingleOrderData($orderId) {
        $order = Mage::getModel("sales/order")->load($orderId);
        if ($order->getId()) {

            //testata
            $orderHeader = $this->__prepareOrder($order);


            //righe
            $row = 1;
            $orderRows = array();
            foreach ($order->getAllItems() as $item) {
                if ($item->getProductType() != Mage_Catalog_Model_Product_Type::TYPE_SIMPLE) {
                    continue;
                }


                $orderRows[] = $this->__prepareItem($item, $row, $order);
                $row++;
            }

            return array("header" => $orderHeader, "rows" => $orderRows);
        }
        return null;
    }

    /**
     * Esporta l'ordine in formato array
     * @param type $orderId è l'entityId dell'ordine
     */
    public function exportSingleOrderDataObject($orderId) {
        $order = Mage::getModel("sales/order")->load($orderId);
        if ($order->getId()) {
            $orderExport = new OrderExport();

            //testata
            $orderHeader = $this->__prepareOrderObject($order);
            $orderCustomer = $this->__prepareOrderCustomer($order);
            $orderExport->header = $orderHeader;
            $orderExport->customer = $orderCustomer;
            


            //righe
            $row = 1;
            foreach ($order->getAllItems() as $item) {
                if ($item->getProductType() != Mage_Catalog_Model_Product_Type::TYPE_SIMPLE) {
                    continue;
                }


                $orderExport->rows[] = $this->__prepareItemObject($item, $row, $order);
                $row++;
            }
            

            return $orderExport;
        }
        return null;
    }    
    
    private function __prepareOrderObject($order) {
        $orderObject = new OrderHeader();

        $paymentMethod = $order->getPayment()->getMethodInstance()->getCode();


                
        $orderObject->created_at = Mage::helper('core')->formatTime($order->getCreatedAt(), $format='short', $showDate=true);
        $orderObject->updated_at = Mage::helper('core')->formatTime($order->getUpdatedAt(), $format='short', $showDate=true);
        $orderObject->source = $order->getSource();
        $orderObject->increment_id = "M".$order->getIncrementId();
        $orderObject->status = $order->getStatus();
        $orderObject->tracking_code = $order->getTrackingCode();
        $orderObject->coupon_code = $order->getCouponCode();
        $orderObject->shipping_description = $order->getShippingDescription();
        $orderObject->store_id = $order->getStoreId();
        $orderObject->base_discount_amount = $order->getBaseDiscountAmount();
        $orderObject->base_grand_total = $order->getBaseGrandTotal();
        $orderObject->base_shipping_amount = $order->getBaseShippingAmount();
        $orderObject->base_shipping_tax_amount = $order->getBaseShippingTaxAmount();
        $orderObject->base_subtotal = $order->getBaseSubtotal();
        $orderObject->base_tax_amount = $order->getBaseTaxAmount();
        $orderObject->base_to_global_rate = $order->getBaseToGlobalRate();
        $orderObject->base_to_order_rate = $order->getBaseToOrderRate();
        $orderObject->discount_amount = $order->getDiscountAmount();
        $orderObject->grand_total = $order->getGrandTotal();
        $orderObject->shipping_amount = $order->getShippingAmount();
        $orderObject->shipping_tax_amount = $order->getShippingTaxAmount();
        $orderObject->subtotal = $order->getSubtotal();
        $orderObject->tax_amount = $order->getTaxAmount();
        $orderObject->total_qty_ordered = $order->getTotalQtyOrdered();
        $orderObject->base_subtotal_incl_tax = $order->getBaseSubtotalInclTax();
        $orderObject->subtotal_incl_tax = $order->getSubtotalInclTax();
        $orderObject->base_currency_code = $order->getBaseCurrencyCode();
        $orderObject->global_currency_code = $order->getGlobalCurrencyCode();
        $orderObject->order_currency_code = $order->getOrderCurrencyCode();
        $orderObject->remote_ip = $order->getRemoteIp();
        $orderObject->payment_method = $paymentMethod;
        $orderObject->shipping_method = $order->getShippingMethod();
        $orderObject->total_item_count = $order->getTotalItemCount();
        $orderObject->shipping_incl_tax = $order->getShippingInclTax();
        $orderObject->cod_fee = $order->getCodFee();
        $orderObject->base_cod_fee = $order->getBaseCodFee();
        $orderObject->cod_tax_amount = $order->getCodTaxAmount();
        $orderObject->base_cod_tax_amount  = $order->getBaseCodTaxAmount();
        $orderObject->anonymous_package = $order->getData("anonymous_package");                
        $orderObject->base_money_for_points = $order->getData("base_money_for_points");
        $orderObject->points_balance_change = $order->getData("points_balance_change");
        
                            
        return $orderObject;
    }    
   
    private function __prepareOrderCustomer($order) {
        $orderObject = new OrderCustomer();
        $billingAddress = $order->getBillingAddress();
        //Mage::helper("iris/log")->log($billingAddress->getData());
        $shippingAddress = $order->getShippingAddress();
               
        $orderObject->customer_id = $order->getCustomerId();
        $customer = Mage::getModel("customer/customer")->load($order->getCustomerId());

        $orderObject->customer_email = $order->getCustomerEmail();
        
        $group = Mage::getModel('customer/group')->load($order->getCustomerGroupId());
        $orderObject->customer_group = $group->getCode();
        $orderObject->billing_firstname = $billingAddress->getFirstname();
        $orderObject->billing_lastname = $billingAddress->getLastname();
        $street = $billingAddress->getStreet();  
        $address = "";
        if(isset($street[0])){
            $address .= $street[0];
        }
        if(isset($street[1])){
            $address = $address." ".$street[1];
        }        
        
        //controllo se il customer è B2C o B2B
        if($customer->getData("website_id") == "1"){
            $orderObject->customer_type = "B2C";
            $orderObject->billing_codice_fiscale = $billingAddress->getVatId();
            $orderObject->billing_vat = "";
        }
        
        if($customer->getData("website_id") == "2"){
            $orderObject->customer_type = "B2B";
            $orderObject->billing_codice_fiscale = $customer->getData("codice_fiscale");
            $orderObject->billing_vat = $customer->getData("taxvat");
        }        
        
        
        $orderObject->billing_street = $address;
        $orderObject->biling_co = $billingAddress->getPresso();
        $orderObject->billing_zipcode = $billingAddress->getPostcode();
        $orderObject->billing_city = $billingAddress->getCity();
        $orderObject->billing_region = $billingAddress->getRegion();
        $orderObject->billing_nation = $billingAddress->getCountryId();
        $orderObject->billing_company = $billingAddress->getCompany();
        $orderObject->billing_phone = $billingAddress->getTelephone();
        $orderObject->shipping_firstname = $shippingAddress->getFirstname();
        $orderObject->shipping_lastname = $shippingAddress->getLastname();
        $street = $shippingAddress->getStreet();
        $address = "";
        if(isset($street[0])){
            $address .= $street[0];
        }
        if(isset($street[1])){
            $address = $address." ".$street[1];
        }           
        $orderObject->shipping_street = $address;
        $orderObject->shipping_co = $shippingAddress->getPresso();
        $orderObject->shipping_zipcode = $shippingAddress->getPostcode();
        $orderObject->shipping_city = $shippingAddress->getCity();
        $orderObject->shipping_region = $shippingAddress->getRegion();
        $orderObject->shipping_nation = $shippingAddress->getCountryId();
        $orderObject->shipping_phone = $shippingAddress->getTelephone();
        $orderObject->billing_address_id = "S".$billingAddress->getId();
        $orderObject->shipping_address_id = "S".$shippingAddress->getId();       

        return $orderObject;
    }        
    
    private function __prepareItemObject($item, $row, $order) {
        $parent = $item;
        
        if ($item->getParentItemId())
            $parent = $item->getParentItem();

        $qty = $this->__formatQtyOrdered($parent->getQtyOrdered());
        $product = Mage::getModel("catalog/product")->load($item->getProductId());

        $total = (float) ($parent->getRowTotalInclTax() / $qty);

        $orderRow = new OrderRow();
        $orderRow->order_id = $order->getIncrementId();
        $orderRow->sku = $parent->getSku();
        $orderRow->name = $parent->getName();
        $orderRow->qty = $parent->getQtyOrdered();
        
        $orderRow->is_expiry = $item->getData("scadenza_breve");
        $orderRow->date_expiry = $item->getData("scadenza");
        
        $orderRow->base_cost = $parent->getBaseCost();
        $orderRow->price = $parent->getPrice();
        $orderRow->base_price = $parent->getBasePrice();
        $orderRow->original_price = $parent->getOriginalPrice();
        $orderRow->base_original_price = $parent->getBaseOriginalPrice();
        $orderRow->tax_percent = $parent->getTaxPercent();
        $orderRow->tax_amount = $parent->getTaxAmount();
        $orderRow->base_tax_amount = $parent->getBaseTaxAmount();
        $orderRow->discount_amount = $parent->getDiscountAmount();
        $orderRow->base_discount_amount = $parent->getBaseDiscountAmount();
        $orderRow->row_total = $parent->getRowTotal();
        $orderRow->base_row_total = $parent->getBaseRowTotal();
        $orderRow->row_weight = $parent->getRowWeight();
        $orderRow->base_tax_before_discount = $parent->getBaseTaxBeforeDiscount();
        $orderRow->price_incl_tax = $parent->getPriceInclTax();
        $orderRow->base_price_incl_tax = $parent->getBasePriceInclTax();
        $orderRow->base_row_total_incl_tax = $parent->getBaseRowTotalInclTax();  


        return $orderRow;
    }    
    
    private function __prepareOrder($order) {

        $incrementId = $order->getIncrementId();

        $clientOrderDate = $evasione = $orderDate = $order->getCreatedAt();

        if ($order->getCustomerIsGuest() || !$order->getCustomerId())
            $customerId = $incrementId;
        else
            $customerId = $order->getCustomerId();
        

        $billingAddress = $order->getBillingAddress();
        $shippingAddress = $order->getShippingAddress();

        if ($order->getCustomerIsGuest() || !$order->getCustomerId()) {
            $billingId = $incrementId;
        } else {
            if ($billingAddress->getId() && $billingAddress->getCustomerAddressId()) {
                $billingId = $billingAddress->getCustomerAddressId();
            } else {
                $billingId = $incrementId;
            }
        }
        $firstname = $billingAddress->getFirstname();
        $lastname = $billingAddress->getLastname();
        $presso = $billingAddress->getCompany();
        $street = implode(" ", $billingAddress->getStreet());
        $zip = $billingAddress->getPostcode();

        $loca = $billingAddress->getCity();

        $country = Mage::getModel('directory/country')->loadByCode($billingAddress->getCountryId());

        $provincia = $billingAddress->getRegion();

        if ($billingAddress->getRegionId() && $billingAddress->getCountryId() == 'IT')
            $provincia = Mage::getModel('directory/region')->load($billingAddress->getRegionId())->getCode();



        $nazione = $billingAddress->getCountry();

        $pIva = $order->getCustomerTaxvat();
        $cf = $billingAddress->getVatId();
        
        $tel = $billingAddress->getTelephone();
        $email = $order->getCustomerEmail();

        $pressoShipping = $shippingAddress->getCompany();
        if ($pressoShipping)
            $pressoShipping = $pressoShipping;
        else
            $pressoShipping = '';

        if ($order->getCustomerIsGuest() || !$order->getCustomerId()) {
            $idShipping = $incrementId;
        } else {
            if ($shippingAddress->getId() && $shippingAddress->getCustomerAddressId()) {
                $idShipping = $shippingAddress->getCustomerAddressId();
            } else {
                $idShipping = $incrementId;
            }
        }

        $firstnameShipping = $shippingAddress->getFirstname();
        $lastnameShipping = $shippingAddress->getLastname();
        $streetShipping = implode(" ", $shippingAddress->getStreet());
        $zipShipping = $shippingAddress->getPostcode();
        $locaShipping = $shippingAddress->getCity();
        $countrySh = Mage::getModel('directory/country')->loadByCode($shippingAddress->getCountryId());
        $provinciaShipping = $shippingAddress->getRegion();
        if ($shippingAddress->getRegionId() && $shippingAddress->getCountryId() == 'IT')
            $provinciaShipping = Mage::getModel('directory/region')->load($shippingAddress->getRegionId())->getCode();

        $nazioneShipping = $shippingAddress->getCountry();
        $pIvaShipping = $cfShipping = $order->getCustomerTaxvat();
        $telShipping = $shippingAddress->getTelephone();
        $emailShipping = $order->getCustomerEmail();
        $shippingCost = $order->getShippingInclTax();
        $shippingMethod = $order->getShippingDescription();
        $discountAmount = $order->getDiscountAmount();
        $couponCode = $order->getCouponCode();
        $vettore = ($shippingAddress->getCountryId() == 'IT') ? 'TNT' : 'UPS';
        $note = $confezioneRegalo = $bigliettoAuguri = $testoAuguri = '';

        /*
         * Confezione regalo
         */
        if ($order->getGwId())
            $confezioneRegalo = 1;

        $giftCost = $order->getGwPrice() + $order->getGwTaxAmount();
        if ($order->getGiftMessageId()) {
            $giftMessage = str_replace("\n", " ", Mage::getModel('giftmessage/message')->load($order->getGiftMessageId())->getMessage());
            $giftMessage = str_replace("\r\n", " ", $giftMessage);
        } else {
            $giftMessage = '';
        }

        $orderTotal = $order->getGrandTotal();

        $paymentMethod = $order->getPayment()->getMethodInstance()->getTitle();

        $valuta = $order->getOrderCurrencyCode();

        $dataOrder = array(
            'id' => $incrementId,
            'order_date' => $clientOrderDate,
            'customer_id' => $customerId,
            'customer_email' => $email,
            'billing_firstname' => $firstname,
            'billing_lastname' => $lastname,
            'billing_street' => $street,
            'billing_co' => $presso,
            'billing_zipcode' => $zip,
            'billing_city' => $loca,
            'billing_region' => $provincia,
            'billing_nation' => $nazione,
            'codice_fiscale' => $cf,
            'piva' => $pIva,
            'billing_phone' => $tel,
            'payment_method' => $paymentMethod,
            'shipping_method' => $shippingMethod,
            'shipping_firstname' => $firstnameShipping,
            'shipping_lastname' => $lastnameShipping,
            'shipping_street' => $streetShipping,
            'shipping_co' => $pressoShipping,
            'shipping_zipcode' => $zipShipping,
            'shipping_city' => $locaShipping,
            'shipping_region' => $provinciaShipping,
            'shipping_nation' => $nazioneShipping,
            'shipping_phone' => $telShipping,
            'currency_code' => $valuta,
            'shipping_cost' => number_format($shippingCost, 2),
            'order_total' => number_format($orderTotal, 2)
        );

        return $dataOrder;
    }

    private function __prepareItem($item, $row, $order) {

        $parent = $item;

        if ($item->getParentItemId())
            $parent = $item->getParentItem();

        $qty = $this->__formatQtyOrdered($parent->getQtyOrdered());
        $product = Mage::getModel("catalog/product")->load($item->getProductId());

        $total = (float) ($parent->getRowTotalInclTax() / $qty);

        $itemData = array(
            'order_id' => $order->getIncrementId(),
            'sku' => $product->getSku(),
            'qty' => $qty,
            'price' => number_format($total, 2),
        );

        return $itemData;
    }

    private function __formatQtyOrdered($qty) {
        list($int, $dec) = explode(".", $qty);

        $int = str_replace(",", "", $int);
        $dec = $this->__formatLenght($dec, 3);

        return $int . '.' . $dec;
    }

    private function __formatLenght($string, $num) {

        $string = str_replace(array(";", "''"), " ", $string);

        if (strlen(utf8_decode($string)) >= $num)
            return substr($string, 0, $num);

        for ($i = strlen(utf8_decode($string)); $i < $num; $i++)
            $string .= " ";


        return utf8_decode($string);
    }
        
}

?>
