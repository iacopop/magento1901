<?php

/**
 * Questa class è l'oggetto Prodotto che viene ritornato dal parser
 */
class DataExchange_Iris_Model_Data_Customer_Default {
    
    private $action_type;
    private $status;
    private $note;
    private $created_at;
    private $updated_at;
    private $source;

    private $customer_id;
    private $customer_email;
    private $password;
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
    
    public function setPassword($password){
        $this->password = $password;
    }
    
    public function getPassword(){
        return $this->password;
    }    


    

}

?>
