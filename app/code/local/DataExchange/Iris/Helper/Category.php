<?php

class DataExchange_Iris_Helper_Category {
    const CATEGORY_SEPARATOR = "|";
    
    function __log($message) {
        Mage::helper("iris/log")->log($message);
    }   
    
    /**
     * Cancella tutte le categorie ad eccezzione della default
     */
    public function deleteAllCategories(){
        $this->__log("Deleting all categories!");
        $categoryCollection = Mage::getModel('catalog/category')->getCollection()
                ->addFieldToFilter('level', array('gteq' => 2));

        foreach ($categoryCollection as $category) {
            if ($category->getProductCount() === 0) {
                $category = Mage::getModel("catalog/category")->load($category->getId());
                $this->__log("Deleting ".$category->getName());
                $category->delete();
            }
        }        
    }

   
    /**
     * Controlla se la categoria ha figli con il nome passato
     * @param type $category
     * @param type $categoryName
     * @return the found category child
     */
    private function __categoryHasChildName($category,$categoryName){
        $this->__log("Check if category ".$category->getName()." has child ".$categoryName);
        $children = $category->getChildrenCategories();
        foreach ($children as $child) {
            $this->__log("Child ".$child->getName()." - ".$categoryName);
            if($child->getName() == $categoryName){
                return $child;
            }            
        }
        return null;
    }
    
    /**
     * Questa funzione prende un path di categoria in questo formato Default|Categoria1|Sottocategoria1
     * e crea le categorie indicate. Ritorna l'id dell'ultima sottocategoria
     * @param type $categoryPath
     * @param type $create
     */
    public function getCategoryIdFromPath($categoryPath, $categoryPathEng, $create = false, $separator = "|"){
        if($separator){
            $pathArray = explode($separator, $categoryPath);
            $pathArrayEng = explode($separator, $categoryPathEng);
        }else{
            $pathArray = explode(DataExchange_Iris_Helper_Category::CATEGORY_SEPARATOR, $categoryPath);
            $pathArrayEng = explode(DataExchange_Iris_Helper_Category::CATEGORY_SEPARATOR, $categoryPathEng);
        }
        
        //controllo esistenza categoria root
        $rootCategory = Mage::getModel('catalog/category')->loadByAttribute('name', $pathArray[0]);
        if(!$rootCategory){
            Mage::helper("iris/log")->log("Categoria root non esistente!");
            return null;
        }
        $found = -1;
        
        //path di default delle categorie
        $path = "1/2";
        for ($index = 1; $index < count($pathArray); $index++) {
            Mage::helper("iris/log")->log("Category: ".$pathArray[$index]);
            //carico la categoria per nome
            $parentCatId = $this->__getCategoryIdByPath($path);           
            $parentCategory = Mage::getModel("catalog/category")->load($parentCatId);
            if(!$parentCategory){
                $this->__log("Root category not found!");
                return;
            }else{
                Mage::helper("iris/log")->log("Category loaded ".$parentCategory->getId());
            }
            
            //controllo se ha figli e se nei figli c'è quello con il nome cercato
            $curCat = $this->__categoryHasChildName($parentCategory, $pathArray[$index]);
            
            if(!$curCat){
                if($create){
                    //creo la categoria
                    $this->__log("Creating category: ".$pathArray[$index]." with path: ".$path);
                    $newCatId = $this->__createCategory(trim($pathArray[$index]), $path, trim($pathArrayEng[$index]));
                    $path = $path."/".$newCatId;
                    $found = $newCatId;
                }
            }else{
                $this->__log("Category already exists: " . $curCat->getName());
                $found = $curCat->getId();
                $path = $path . "/" . $curCat->getId();                
            }
        }
        
        if($found == -1){
            return null;
        }else{
            return $found;
        }
    }      
    
    
    function __createCategory($categoryName, $categoryParentPath, $categoryNameEng = null){
        // Create category object
        if(trim($categoryName) == "" || $categoryName == null){
            Mage::log("categoria nulla passata!");
        }        
        $category = Mage::getModel('catalog/category');
        $category->setStoreId(0); // No store is assigned to this category. 

        $rootCategory['name'] = $categoryName;
        $rootCategory['path'] = $categoryParentPath;
//        $rootCategory['meta_title'] = "Meta Title";
//        $rootCategory['meta_keywords'] = "Meta Keywords";
//        $rootCategory['meta_description'] = "Meta Description";
        $rootCategory['display_mode'] = "PRODUCTS";
        $rootCategory['is_active'] = 1;
        $rootCategory['is_anchor'] = 1;
        $rootCategory['is_anchor'] = 1;
        $rootCategory['custom_use_parent_settings'] = 1;
        
        $category->addData($rootCategory);

        try {
            $category->save();
            //Mage::helper("iris/transaction")->saveObjectTransaction($category);    
            $this->translateCategory($category->getId(), 3, array("name" => $categoryNameEng, "url_key" => $categoryNameEng));
            $this->translateCategory($category->getId(), 4, array("name" => $categoryNameEng, "url_key" => $categoryNameEng));
            return $category->getId();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    /**
     * Ritorna la categoria con un certo path
     * @param type $path
     * @return null
     */
    private function __getCategoryIdByPath($path){
        $collection = Mage::getModel("catalog/category")->getCollection()->addFieldToFilter('path', array('eq' => $path));

        if($collection->count() == 1){            
            $category = $collection->getFirstItem();
            return $category->getId();
        }else{
            return null;
        }
        
    }   
    
    
    /**
     * Traduce gli attributi di una categoria
     * @param type $categoryId
     * @param type $storeId
     * @param type $attributesArray ex: array("name" => "nome tradotto", "meta_keywords" => "meta1, meta2, meta3")
     */
    public function translateCategory($categoryId,$storeId,$attributesArray){
        $cat = Mage::getModel("catalog/category")->load($categoryId);
        if($cat->getId()){
            foreach ($attributesArray as $key => $value) {
                $cat->setStoreId($storeId)->setData($key,$value);            
            }
            $cat->save();     
        }
    }
    
  
}
?>
