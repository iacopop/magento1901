<?php

class DataExchange_Iris_Model_Parser_Order_Default extends DataExchange_Iris_Model_Parser_Order_Abstract {
    
    
    /**
     * Esporta gli ordini che sono in stati presenti all'interno degli stati passati in input
     * @param type $statusArray
     * @return type
     */
    public function getOrdersToExportForDal($statusArray) {
        //se orderId
        $orders_collection = Mage::getModel('sales/order')
        ->getCollection()
        ->addAttributeToSelect('*')
        ->addAttributeToFilter('status', array('in' => $statusArray));
        
        $ordersForDal = array();
        
        foreach ($orders_collection as $order) {
            $ordersForDal[] = $this->__prepareOrderForDal($order);
        }

        return $ordersForDal;        
    }
    
    
    /**
     * return a unico DataExchange_Iris_Model_Data_Order_Default che dovrà essere passato al DAL
     * @param type $order
     */
    private function __prepareOrderForDal($order){
        if ($order->getId()) {

            //testata ordine, oggetto DataExchange_Iris_Model_Data_Order_Default
            $orderForDal = $this->__prepareOrder($order);


            //righe
            $row = 1;
            foreach ($order->getAllItems() as $item) {
                if ($item->getProductType() != Mage_Catalog_Model_Product_Type::TYPE_SIMPLE) {
                    continue;
                }

                $rowForDal = $this->__prepareRow($item, $row, $order);
                $orderForDal->addRow($rowForDal);
                $row++;
            }

            return $orderForDal;
        }
        return null;        
        
    }
    
    /**
     * Ritorna un DataExchange_Iris_Model_Data_Order_Default
     * @param type $order
     * @return type DataExchange_Iris_Model_Data_Order_Default
     */
    private function __prepareOrder($order) {

        $incrementId = $order->getIncrementId();

        $clientOrderDate = $evasione = $orderDate = $order->getCreatedAt();

        if ($order->getCustomerIsGuest() || !$order->getCustomerId())
            $customerId = "guest_".$incrementId;
        else
            $customerId = $order->getCustomerId();



        $billingAddress = $order->getBillingAddress();
        $shippingAddress = $order->getShippingAddress();

        if ($order->getCustomerIsGuest() || !$order->getCustomerId()) {
            $billingId = "billing_".$incrementId;
        } else {
            if ($billingAddress->getId() && $billingAddress->getCustomerAddressId()) {
                $billingId = $billingAddress->getCustomerAddressId();
            } else {
                $billingId = "billing_".$incrementId;
            }
        }
        $firstname = $billingAddress->getFirstname();
        $lastname = $billingAddress->getLastname();
        $presso = $billingAddress->getCompany();
        $street = implode(" ", $billingAddress->getStreet());
        $zip = $billingAddress->getPostcode();
        $vat = $billingAddress->getVatId();
        $company = $billingAddress->getCompany();

        $loca = $billingAddress->getCity();

        $country = Mage::getModel('directory/country')->loadByCode($billingAddress->getCountryId());

        $provincia = $billingAddress->getRegion();

        if ($billingAddress->getRegionId() && $billingAddress->getCountryId() == 'IT')
            $provincia = Mage::getModel('directory/region')->load($billingAddress->getRegionId())->getCode();



        $nazione = $billingAddress->getCountry();

        $pIva = $cf = $order->getCustomerTaxvat();
        $tel = $billingAddress->getTelephone();
        $email = $order->getCustomerEmail();

        $pressoShipping = $shippingAddress->getCompany();
        if ($pressoShipping)
            $pressoShipping = $pressoShipping;
        else
            $pressoShipping = '';

        if ($order->getCustomerIsGuest() || !$order->getCustomerId()) {
            $idShipping = "shipping_".$incrementId;
        } else {
            if ($shippingAddress->getId() && $shippingAddress->getCustomerAddressId()) {
                $idShipping = $shippingAddress->getCustomerAddressId();
            } else {
                $idShipping = "shipping_".$incrementId;
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

        $paymentMethod = $order->getPayment()->getMethodInstance()->getCode();

        $valuta = $order->getOrderCurrencyCode();

        
        $dataOrder = new DataExchange_Iris_Model_Data_Order_Default();

        $dataOrder->setActionType(DataExchange_Iris_Model_Dal_Order_Default::ACTION_TYPE_INSERT);
        $dataOrder->setStatus(DataExchange_Iris_Model_Dal_Order_Default::ACTION_STATUS_TO_BE_PROCESSED);
        $dataOrder->setNote("");
        $dataOrder->setCreatedAt($order->getCreatedAt());
        $dataOrder->setUpdatedAt($order->getUpdatedAt());
        $dataOrder->setSource("standard order parser");
        $dataOrder->setIncrementId($incrementId);
        $dataOrder->setOrderStatus($order->getStatus());
        $dataOrder->setTrackingCode("");
        $dataOrder->setCouponCode($order->getCouponCode());
        $dataOrder->setShippingDescription($order->getShippingDescription());
        $dataOrder->setStoreId($order->getStoreId());
        $dataOrder->setBaseDiscountAmount($order->getBaseDiscountAmount());
        $dataOrder->setBaseGrandTotal($order->getBaseGrandTotal());
        $dataOrder->setBaseShippingAmount($order->getBaseShippingAmount());
        $dataOrder->setBaseShippingTaxAmount($order->getBaseShippingTaxAmount());
        $dataOrder->setBaseSubtotal($order->getBaseSubtotal());
        $dataOrder->setBaseTaxAmount($order->getBaseTaxAmount());
        $dataOrder->setBaseToGlobalRate($order->getBaseToGlobalRate());
        $dataOrder->setBaseToOrderRate($order->getBaseToOrderRate());
        $dataOrder->setDiscountAmount($order->getDiscountAmount());
        $dataOrder->setGrandTotal($order->getGrandTotal());
        $dataOrder->setShippingAmount($order->getShippingAmount());
        $dataOrder->setShippingTaxAmount($order->getShippingTaxAmount());
        $dataOrder->setSubtotal($order->getSubtotal());
        $dataOrder->setTaxAmount($order->getTaxAmount());
        $dataOrder->setTotalQtyOrdered($order->getTotalQtyOrdered());
        $dataOrder->setBaseSubtotalInclTax($order->getBaseSubtotalInclTax());
        $dataOrder->setSubtotalInclTax($order->getSubtotalInclTax());
        $dataOrder->setBaseCurrencyCode($order->getBaseCurrencyCode());
        $dataOrder->setGlobalCurrencyCode($order->getGlobalCurrencyCode());
        $dataOrder->setOrderCurrencyCode($order->getOrderCurrencyCode());
        $dataOrder->setRemoteIp($order->getRemoteIp());
        $dataOrder->setPaymentMethod($paymentMethod);
        $dataOrder->setShippingMethod($order->getShippingDescription());
        $dataOrder->setOrderCreatedAt($order->getOrderCreatedAt());
        $dataOrder->setTotalItemCount($order->getTotalItemCount());
        $dataOrder->setShippingInclTax($order->getShippingInclTax());
        $dataOrder->setBaseShippingInclTax($order->getBaseShippingInclTax());
        //dati utente
        $dataOrder->setCustomerId($customerId);
        $dataOrder->setCustomerEmail($email);
        $dataOrder->setBillingFirstname($firstname);
        $dataOrder->setBillingLastname($lastname);
        $dataOrder->setBillingStreet($street);
        $dataOrder->setBillingCo($presso);
        $dataOrder->setBillingZipcode($zip);
        $dataOrder->setBillingCity($loca);
        $dataOrder->setBillingRegion($provincia);
        $dataOrder->setBillingNation($nazione);
        $dataOrder->setBillingCodiceFiscale($cf);
        $dataOrder->setBillingVat($vat);
        $dataOrder->setBillingCompany($company);
        $dataOrder->setBillingPhone($tel);
        $dataOrder->setShippingFirstname($firstnameShipping);
        $dataOrder->setShippingLastname($lastnameShipping);
        $dataOrder->setShippingStreet($streetShipping);
        $dataOrder->setShippingCo($pressoShipping);
        $dataOrder->setShippingZipcode($zipShipping);
        $dataOrder->setShippingCity($locaShipping);
        $dataOrder->setShippingRegion($provinciaShipping);
        $dataOrder->setShippingNation($nazioneShipping);
        $dataOrder->setShippingPhone($telShipping);
        $dataOrder->setBillingAddressId($billingId);
        $dataOrder->setShippingAddressId($idShipping);
        
        return $dataOrder;
    }

    
    /**
     * Ritorna un oggetto riga ordine, di tipo DataExchange_Iris_Model_Data_Order_Rows
     * @param type $item
     * @param type $row
     * @param type $order
     * @return type DataExchange_Iris_Model_Data_Order_Rows
     */
    private function __prepareRow($item, $row, $order) {

        $parent = $item;

        if ($item->getParentItemId())
            $parent = $item->getParentItem();

        $qty = $parent->getQtyOrdered();
        $product = Mage::getModel("catalog/product")->load($item->getProductId());

        $total = (float) ($parent->getRowTotalInclTax() / $qty);

        $itemData = array(
            'order_id' => $order->getIncrementId(),
            'sku' => $product->getSku(),
            'qty' => $qty,
            'price' => number_format($total, 2),
        );
        
        $row = new DataExchange_Iris_Model_Data_Order_Rows();
        $row->setProductId($product->getId());
        $row->setWeight($product->getWeight());
        if($parent->getId() != $product->getId()){
            $row->setProductType($parent->getTypeID());
        }else{
            $row->setProductType($product->getTypeID());
        }

        $row->setIsVirtual("");
        $row->setSku($product->getSku());
        $row->setName($product->getName());
        $row->setQtyOrdered($parent->getQtyOrdered());
        $row->setBaseCost($parent->getBaseCost());
        $row->setPrice($parent->getPrice());
        $row->setBasePrice($parent->getBasePrice());
        $row->setOriginalPrice($parent->getOriginalPrice());
        $row->setBaseOriginalPrice($parent->getBaseOriginalPrice());
        $row->setTaxPercent($parent->getTaxPercent());
        $row->setTaxAmount($parent->getTaxAmount());
        $row->setBaseTaxAmount($parent->getBaseTaxAmount());
        $row->setDiscountAmount($parent->getDiscountAmount());
        $row->setBaseDiscountAmount($parent->getBaseDiscountAmount());
        $row->setRowTotal($parent->getRowTotal());
        $row->setBaseRowTotal($parent->getBaseRowTotal());
        $row->setRowWeight($parent->getRowWeight());
        $row->setBaseTaxBeforeDiscount($parent->getBaseTaxBeforeDiscount());
        $row->setPriceInclTax($parent->getPriceInclTax());
        $row->setBasePriceInclTax($parent->getBasePriceInclTax());
        $row->setRowTotal($parent->getRowTotal());
        $row->setBaseRowTotalInclTax($parent->getBaseRowTotalInclTax());
        
        return $row;
    }    
}
?>
