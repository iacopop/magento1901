<?php
/**
 * Questa class è l'oggetto Prodotto che viene ritornato dal parser
 */
class DataExchange_Iris_Model_Data_Product_Default {
    
    const ATTRIBUTE_SET_ID_DEFAULT = 4;
    const WEBSITE_IDS_DEFAULT = 1;
    const TAX_CLASS_DEFAULT = 2;
    const VISIBILITY_DEFAULT = Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE;
    const VISIBILITY_ALL = Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH;
    const STATUS_ENABLED = 1;
    CONST STATUS_DISABLED = 2;
    
    private $product_type;
    private $sku;
    private $name;
    private $source;
    private $parent_sku;
    private $configurable_attributes;
    private $attribute_set_id;
    private $website_ids;
    private $tax_class;
    private $category_ids;
    private $visibility;
    private $product_status;
    
    /**
     * NOTA: questa classe deve avere delle variabili che sono i dati necessari alla creazione di un prodotto.
     * Esempio di funzioni: getSku(), getName(), getDescription(), getWeight()
     * 
     */
    private $attributesArray = array();
    
    public function __construct(){
        
    }
    
    public function getAttributeSetId() {
        return $this->attribute_set_id;
    }

    public function setAttributeSetId($attribute_set_id) {
        $this->attribute_set_id = $attribute_set_id;
    }

    /**
     * ritorna l'array di website
     */
    public function getWebsiteIds() {
        return $this->website_ids;
    }

    public function setWebsiteIds($website_ids) {
        $this->website_ids = $website_ids;
    }

    public function getTaxClass() {
        return $this->tax_class;
    }

    public function setTaxClass($tax_class) {
        $this->tax_class = $tax_class;
    }

    public function getCategoryIds() {
        return $this->category_ids;
    }

    public function setCategoryIds($category_ids) {
        $this->category_ids = $category_ids;
    }

    public function getVisibility() {
        return $this->visibility;
    }

    public function setVisibility($visibility) {
        $this->visibility = $visibility;
    }

        
    public function addAttribute(DataExchange_Iris_Model_Data_Product_Attribute $attribute){
        $this->attributesArray[] = $attribute;
    }
    
    public function getAttributesList(){
        return $this->attributesArray;
    }
    
    public function getProductType() {
        return $this->product_type;
    }

    public function setProductType($product_type) {
        $this->product_type = $product_type;
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

    public function getSource() {
        return $this->source;
    }

    public function setSource($source) {
        $this->source = $source;
    }

    public function getParentSku() {
        return $this->parent_sku;
    }

    public function setParentSku($parent_sku) {
        $this->parent_sku = $parent_sku;
    }

    public function getConfigurableAttributes() {
        return $this->configurable_attributes;
    }

    public function setConfigurableAttributes($configurable_attributes) {
        $this->configurable_attributes = $configurable_attributes;
    }
    
    public function setProductStatus($status){
        $this->product_status = $status;
    }

    public function getProductStatus(){
        return $this->product_status;
    }

            
}
?>
