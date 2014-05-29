<?php

class DataExchange_Iris_Helper_Image extends Mage_Core_Helper_Abstract
{
    public function addSingleImageToProduct($imageFullPath, $productId, $remove = true){
        $product = Mage::getModel("catalog/product")->load($productId);

        if($product->getId()){
            //salvo l'immgine
            Mage::helper("iris/log")->log("Importazione immagine per prodotto con sku: ".$product->getSku()." - ".$imageFullPath);
            $visibility = array(
                'thumbnail',
                'small_image',
                'image'
            );

            $product->addImageToMediaGallery($imageFullPath, $visibility, false, $remove);
            $product->save();     
        }
    }
    
    public function removeAllImageFromProduct($productId){
        $product = Mage::getModel("catalog/product")->load($productId);
        //rimuovo immagini dai prodotti
        if($product->getId()){
            Mage::helper("iris/log")->log("Removing image for product with sku " . $product->getSku());

            //rimuovo immagini dai prodotti
            $mediaApi = Mage::getModel("catalog/product_attribute_media_api");
            $items = $mediaApi->items($product->getId());
            foreach ($items as $item) {
                $mediaApi->remove($product->getId(), $item['file']);
            }   
        }
    }
}
?>
