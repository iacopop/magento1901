<?php

/**
 * Questa class è l'oggetto Prodotto che viene ritornato dal parser
 */
class DataExchange_Iris_Model_Data_Order_Rows {
    
    private $action_order_id;
    private $product_id;
    private $product_type;
    private $weight;
    private $is_virtual;
    private $sku;
    private $name;
    private $base_cost;
    private $price;
    private $qty_ordered;
    private $base_price;    
    private $original_price;
    private $base_original_price;
    private $tax_percent;
    private $tax_amount;
    private $base_tax_amount;
    private $discount_amount;
    private $base_discount_amount;
    private $row_total;
    private $base_row_total;
    private $row_weight;
    private $base_tax_before_discount;
    private $tax_before_discount;
    private $price_incl_tax;
    private $base_price_incl_tax;
    private $row_total_incl_tax;
    private $base_row_total_incl_tax;

    public function getActionOrderId() {
        return $this->action_order_id;
    }

    public function setActionOrderId($action_order_id) {
        $this->action_order_id = $action_order_id;
    }

    public function getProductId() {
        return $this->product_id;
    }

    public function setProductId($product_id) {
        $this->product_id = $product_id;
    }
    
    public function getQtyOrdered() {
        return $this->qty_ordered;
    }

    public function setQtyOrdered($qty_ordered) {
        $this->qty_ordered = $qty_ordered;
    }

    
    public function getProductType() {
        return $this->product_type;
    }

    public function setProductType($product_type) {
        $this->product_type = $product_type;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    public function getIsVirtual() {
        return $this->is_virtual;
    }

    public function setIsVirtual($is_virtual) {
        $this->is_virtual = $is_virtual;
    }

    public function getSku() {
        return $this->sku;
    }

    public function setSku($sku) {
        $this->sku = $sku;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getBaseCost() {
        return $this->base_cost;
    }

    public function setBaseCost($base_cost) {
        $this->base_cost = $base_cost;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getBasePrice() {
        return $this->base_price;
    }

    public function setBasePrice($base_price) {
        $this->base_price = $base_price;
    }

    public function getOriginalPrice() {
        return $this->original_price;
    }

    public function setOriginalPrice($original_price) {
        $this->original_price = $original_price;
    }

    public function getBaseOriginalPrice() {
        return $this->base_original_price;
    }

    public function setBaseOriginalPrice($base_original_price) {
        $this->base_original_price = $base_original_price;
    }

    public function getTaxPercent() {
        return $this->tax_percent;
    }

    public function setTaxPercent($tax_percent) {
        $this->tax_percent = $tax_percent;
    }

    public function getTaxAmount() {
        return $this->tax_amount;
    }

    public function setTaxAmount($tax_amount) {
        $this->tax_amount = $tax_amount;
    }

    public function getBaseTaxAmount() {
        return $this->base_tax_amount;
    }

    public function setBaseTaxAmount($base_tax_amount) {
        $this->base_tax_amount = $base_tax_amount;
    }

    public function getDiscountAmount() {
        return $this->discount_amount;
    }

    public function setDiscountAmount($discount_amount) {
        $this->discount_amount = $discount_amount;
    }

    public function getBaseDiscountAmount() {
        return $this->base_discount_amount;
    }

    public function setBaseDiscountAmount($base_discount_amount) {
        $this->base_discount_amount = $base_discount_amount;
    }

    public function getRowTotal() {
        return $this->row_total;
    }

    public function setRowTotal($row_total) {
        $this->row_total = $row_total;
    }

    public function getBaseRowTotal() {
        return $this->base_row_total;
    }

    public function setBaseRowTotal($base_row_total) {
        $this->base_row_total = $base_row_total;
    }

    public function getRowWeight() {
        return $this->row_weight;
    }

    public function setRowWeight($row_weight) {
        $this->row_weight = $row_weight;
    }

    public function getBaseTaxBeforeDiscount() {
        return $this->base_tax_before_discount;
    }

    public function setBaseTaxBeforeDiscount($base_tax_before_discount) {
        $this->base_tax_before_discount = $base_tax_before_discount;
    }

    public function getTaxBeforeDiscount() {
        return $this->tax_before_discount;
    }

    public function setTaxBeforeDiscount($tax_before_discount) {
        $this->tax_before_discount = $tax_before_discount;
    }

    public function getPriceInclTax() {
        return $this->price_incl_tax;
    }

    public function setPriceInclTax($price_incl_tax) {
        $this->price_incl_tax = $price_incl_tax;
    }

    public function getBasePriceInclTax() {
        return $this->base_price_incl_tax;
    }

    public function setBasePriceInclTax($base_price_incl_tax) {
        $this->base_price_incl_tax = $base_price_incl_tax;
    }

    public function getRowTotalInclTax() {
        return $this->row_total_incl_tax;
    }

    public function setRowTotalInclTax($row_total_incl_tax) {
        $this->row_total_incl_tax = $row_total_incl_tax;
    }

    public function getBaseRowTotalInclTax() {
        return $this->base_row_total_incl_tax;
    }

    public function setBaseRowTotalInclTax($base_row_total_incl_tax) {
        $this->base_row_total_incl_tax = $base_row_total_incl_tax;
    }


}

?>
