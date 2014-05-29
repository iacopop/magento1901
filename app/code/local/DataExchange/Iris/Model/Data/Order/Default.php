<?php

/**
 * Questa class è l'oggetto Prodotto che viene ritornato dal parser
 */
class DataExchange_Iris_Model_Data_Order_Default {
    
    private $action_type;
    private $status;
    private $note;
    private $created_at;
    private $updated_at;
    private $source;
    private $increment_id;
    private $order_status;
    private $tracking_code;
    private $coupon_code;
    private $shipping_description;
    private $store_id;
    private $base_discount_amount;
    private $base_grand_total;
    private $base_shipping_amount;
    private $base_shipping_tax_amount;
    private $base_subtotal;
    private $base_tax_amount;
    private $base_to_global_rate;
    private $base_to_order_rate;
    private $discount_amount;
    private $grand_total;
    private $shipping_amount;
    private $shipping_tax_amount;
    private $subtotal;
    private $tax_amount;
    private $total_qty_ordered;
    private $base_subtotal_incl_tax;
    private $subtotal_incl_tax;
    private $base_currency_code;
    private $global_currency_code;
    private $order_currency_code;
    private $remote_ip;
    private $payment_method;
    private $shipping_method;
    private $order_created_at;
    private $total_item_count;
    private $shipping_incl_tax;
    private $base_shipping_incl_tax;
    private $customer_id;
    private $customer_email;
    private $billing_firstname;
    private $billing_lastname;
    private $billing_street;
    private $billing_co;
    private $billing_zipcode;    
    private $billing_city;
    private $billing_region;    
    private $billing_nation;
    private $billing_codice_fiscale;    
    private $billing_vat;
    private $billing_company;    
    private $billing_phone;
    private $shipping_firstname;    
    private $shipping_lastname;
    private $shipping_street;       
    private $shipping_co;
    private $shipping_zipcode;    
    private $shipping_city;
    private $shipping_region;
    private $shipping_nation;    
    private $shipping_phone;    
    private $shipping_address_id;
    private $billing_address_id;
    
    private $rowArray = array();  
    
    public function getShippingAddressId() {
        return $this->shipping_address_id;
    }

    public function setShippingAddressId($shipping_address_id) {
        $this->shipping_address_id = $shipping_address_id;
    }

    public function getBillingAddressId() {
        return $this->billing_address_id;
    }

    public function setBillingAddressId($billing_address_id) {
        $this->billing_address_id = $billing_address_id;
    }    
    
    public function addRow(DataExchange_Iris_Model_Data_Order_Rows $row){
        $this->rowArray[] = $row;
    }
    
    public function getRows(){
        return $this->rowArray;
    }
    
    public function getActionType() {
        return $this->action_type;
    }

    public function setActionType($action_type) {
        $this->action_type = $action_type;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getNote() {
        return $this->note;
    }

    public function setNote($note) {
        $this->note = $note;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }

    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
    }

    public function getIncrementId() {
        return $this->increment_id;
    }

    public function setIncrementId($increment_id) {
        $this->increment_id = $increment_id;
    }

    public function getOrderStatus() {
        return $this->order_status;
    }

    public function setOrderStatus($order_status) {
        $this->order_status = $order_status;
    }

    public function getTrackingCode() {
        return $this->tracking_code;
    }

    public function setTrackingCode($tracking_code) {
        $this->tracking_code = $tracking_code;
    }

    public function getCouponCode() {
        return $this->coupon_code;
    }

    public function setCouponCode($coupon_code) {
        $this->coupon_code = $coupon_code;
    }

    public function getShippingDescription() {
        return $this->shipping_description;
    }

    public function setShippingDescription($shipping_description) {
        $this->shipping_description = $shipping_description;
    }

    public function getStoreId() {
        return $this->store_id;
    }

    public function setStoreId($store_id) {
        $this->store_id = $store_id;
    }

    public function getBaseDiscountAmount() {
        return $this->base_discount_amount;
    }

    public function setBaseDiscountAmount($base_discount_amount) {
        $this->base_discount_amount = $base_discount_amount;
    }

    public function getBaseGrandTotal() {
        return $this->base_grand_total;
    }

    public function setBaseGrandTotal($base_grand_total) {
        $this->base_grand_total = $base_grand_total;
    }

    public function getBaseShippingAmount() {
        return $this->base_shipping_amount;
    }

    public function setBaseShippingAmount($base_shipping_amount) {
        $this->base_shipping_amount = $base_shipping_amount;
    }

    public function getBaseShippingTaxAmount() {
        return $this->base_shipping_tax_amount;
    }

    public function setBaseShippingTaxAmount($base_shipping_tax_amount) {
        $this->base_shipping_tax_amount = $base_shipping_tax_amount;
    }

    public function getBaseSubtotal() {
        return $this->base_subtotal;
    }

    public function setBaseSubtotal($base_subtotal) {
        $this->base_subtotal = $base_subtotal;
    }

    public function getBaseTaxAmount() {
        return $this->base_tax_amount;
    }

    public function setBaseTaxAmount($base_tax_amount) {
        $this->base_tax_amount = $base_tax_amount;
    }

    public function getBaseToGlobalRate() {
        return $this->base_to_global_rate;
    }

    public function setBaseToGlobalRate($base_to_global_rate) {
        $this->base_to_global_rate = $base_to_global_rate;
    }

    public function getBaseToOrderRate() {
        return $this->base_to_order_rate;
    }

    public function setBaseToOrderRate($base_to_order_rate) {
        $this->base_to_order_rate = $base_to_order_rate;
    }

    public function getDiscountAmount() {
        return $this->discount_amount;
    }

    public function setDiscountAmount($discount_amount) {
        $this->discount_amount = $discount_amount;
    }

    public function getGrandTotal() {
        return $this->grand_total;
    }

    public function setGrandTotal($grand_total) {
        $this->grand_total = $grand_total;
    }

    public function getShippingAmount() {
        return $this->shipping_amount;
    }

    public function setShippingAmount($shipping_amount) {
        $this->shipping_amount = $shipping_amount;
    }

    public function getShippingTaxAmount() {
        return $this->shipping_tax_amount;
    }

    public function setShippingTaxAmount($shipping_tax_amount) {
        $this->shipping_tax_amount = $shipping_tax_amount;
    }

    public function getSubtotal() {
        return $this->subtotal;
    }

    public function setSubtotal($subtotal) {
        $this->subtotal = $subtotal;
    }

    public function getTaxAmount() {
        return $this->tax_amount;
    }

    public function setTaxAmount($tax_amount) {
        $this->tax_amount = $tax_amount;
    }

    public function getTotalQtyOrdered() {
        return $this->total_qty_ordered;
    }

    public function setTotalQtyOrdered($total_qty_ordered) {
        $this->total_qty_ordered = $total_qty_ordered;
    }

    public function getBaseSubtotalInclTax() {
        return $this->base_subtotal_incl_tax;
    }

    public function setBaseSubtotalInclTax($base_subtotal_incl_tax) {
        $this->base_subtotal_incl_tax = $base_subtotal_incl_tax;
    }

    public function getSubtotalInclTax() {
        return $this->subtotal_incl_tax;
    }

    public function setSubtotalInclTax($subtotal_incl_tax) {
        $this->subtotal_incl_tax = $subtotal_incl_tax;
    }

    public function getBaseCurrencyCode() {
        return $this->base_currency_code;
    }

    public function setBaseCurrencyCode($base_currency_code) {
        $this->base_currency_code = $base_currency_code;
    }

    public function getGlobalCurrencyCode() {
        return $this->global_currency_code;
    }

    public function setGlobalCurrencyCode($global_currency_code) {
        $this->global_currency_code = $global_currency_code;
    }

    public function getOrderCurrencyCode() {
        return $this->order_currency_code;
    }

    public function setOrderCurrencyCode($order_currency_code) {
        $this->order_currency_code = $order_currency_code;
    }

    public function getRemoteIp() {
        return $this->remote_ip;
    }

    public function setRemoteIp($remote_ip) {
        $this->remote_ip = $remote_ip;
    }

    public function getShippingMethod() {
        return $this->shipping_method;
    }

    public function setShippingMethod($shipping_method) {
        $this->shipping_method = $shipping_method;
    }

    public function getOrderCreatedAt() {
        return $this->order_created_at;
    }

    public function setOrderCreatedAt($order_created_at) {
        $this->order_created_at = $order_created_at;
    }

    public function getTotalItemCount() {
        return $this->total_item_count;
    }

    public function setTotalItemCount($total_item_count) {
        $this->total_item_count = $total_item_count;
    }

    public function getShippingInclTax() {
        return $this->shipping_incl_tax;
    }

    public function setShippingInclTax($shipping_incl_tax) {
        $this->shipping_incl_tax = $shipping_incl_tax;
    }

    public function getBaseShippingInclTax() {
        return $this->base_shipping_incl_tax;
    }

    public function setBaseShippingInclTax($base_shipping_incl_tax) {
        $this->base_shipping_incl_tax = $base_shipping_incl_tax;
    }

    public function getCustomerId() {
        return $this->customer_id;
    }

    public function setCustomerId($customer_id) {
        $this->customer_id = $customer_id;
    }

    public function getCustomerEmail() {
        return $this->customer_email;
    }

    public function setCustomerEmail($customer_email) {
        $this->customer_email = $customer_email;
    }

    public function getBillingFirstname() {
        return $this->billing_firstname;
    }

    public function setBillingFirstname($billing_firstname) {
        $this->billing_firstname = $billing_firstname;
    }

    public function getBillingLastname() {
        return $this->billing_lastname;
    }

    public function setBillingLastname($billing_lastname) {
        $this->billing_lastname = $billing_lastname;
    }

    public function getBillingStreet() {
        return $this->billing_street;
    }

    public function setBillingStreet($billing_street) {
        $this->billing_street = $billing_street;
    }

    public function getBillingCo() {
        return $this->billing_co;
    }

    public function setBillingCo($billing_co) {
        $this->billing_co = $billing_co;
    }

    public function getBillingZipcode() {
        return $this->billing_zipcode;
    }

    public function setBillingZipcode($billing_zipcode) {
        $this->billing_zipcode = $billing_zipcode;
    }

    public function getBillingCity() {
        return $this->billing_city;
    }

    public function setBillingCity($billing_city) {
        $this->billing_city = $billing_city;
    }

    public function getBillingRegion() {
        return $this->billing_region;
    }

    public function setBillingRegion($billing_region) {
        $this->billing_region = $billing_region;
    }

    public function getBillingNation() {
        return $this->billing_nation;
    }

    public function setBillingNation($billing_nation) {
        $this->billing_nation = $billing_nation;
    }

    public function getBillingCodiceFiscale() {
        return $this->billing_codice_fiscale;
    }

    public function setBillingCodiceFiscale($billing_codice_fiscale) {
        $this->billing_codice_fiscale = $billing_codice_fiscale;
    }

    public function getBillingVat() {
        return $this->billing_vat;
    }

    public function setBillingVat($billing_vat) {
        $this->billing_vat = $billing_vat;
    }

    public function getBillingCompany() {
        return $this->billing_company;
    }

    public function setBillingCompany($billing_company) {
        $this->billing_company = $billing_company;
    }

    public function getBillingPhone() {
        return $this->billing_phone;
    }

    public function setBillingPhone($billing_phone) {
        $this->billing_phone = $billing_phone;
    }

    public function getShippingFirstname() {
        return $this->shipping_firstname;
    }

    public function setShippingFirstname($shipping_firstname) {
        $this->shipping_firstname = $shipping_firstname;
    }

    public function getShippingLastname() {
        return $this->shipping_lastname;
    }

    public function setShippingLastname($shipping_lastname) {
        $this->shipping_lastname = $shipping_lastname;
    }

    public function getShippingStreet() {
        return $this->shipping_street;
    }

    public function setShippingStreet($shipping_street) {
        $this->shipping_street = $shipping_street;
    }

    public function getShippingCo() {
        return $this->shipping_co;
    }

    public function setShippingCo($shipping_co) {
        $this->shipping_co = $shipping_co;
    }

    public function getShippingZipcode() {
        return $this->shipping_zipcode;
    }

    public function setShippingZipcode($shipping_zipcode) {
        $this->shipping_zipcode = $shipping_zipcode;
    }

    public function getShippingCity() {
        return $this->shipping_city;
    }

    public function setShippingCity($shipping_city) {
        $this->shipping_city = $shipping_city;
    }

    public function getShippingRegion() {
        return $this->shipping_region;
    }

    public function setShippingRegion($shipping_region) {
        $this->shipping_region = $shipping_region;
    }

    public function getShippingNation() {
        return $this->shipping_nation;
    }

    public function setShippingNation($shipping_nation) {
        $this->shipping_nation = $shipping_nation;
    }

    public function getShippingPhone() {
        return $this->shipping_phone;
    }

    public function setShippingPhone($shipping_phone) {
        $this->shipping_phone = $shipping_phone;
    }

    public function setPaymentMethod($method){
        $this->payment_method = $method;
    }
    
    public function getPaymentMethod(){
        return $this->payment_method;
    }

    

}

?>
