<?php

class DataExchange_Iris_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }
    
    public function downloadAction(){
        $invoicePrefix = "F_";
        //controllo se è loggato
        if(!Mage::helper('customer')->isLoggedIn()){
            //redirect to homepage
            $this->_redirectUrl(Mage::helper('core/url')->getHomeUrl());
            return;
        }
        
        $orderParam = Mage::getSingleton('core/app')->getRequest()->getParam("id");
        if(!$orderParam){
            return;
        }        
                            
        //prendo il parametro in input
        $userId = Mage::helper('customer')->getCustomer()->getEntityId();
        
        
        //controllo se il parametro in input (id ordine) appartiene a quell'utente
        $userOrdersCollection = Mage::getModel("sales/order")->getCollection()
                ->addAttributeToSelect("increment_id")
                ->addAttributeToSelect("customer_id")
                ->addFieldToFilter("customer_id",array("eq" => $userId))
                ->addFieldToFilter("increment_id",array("eq" => $orderParam));
        if($userOrdersCollection->count() > 0){
            $this->__sendFile(Mage::getBaseDir().DS.Mage::getStoreConfig("iris_files/settings/invoice_directory").DS.$invoicePrefix.$orderParam.".pdf");
        }else{
            //controllo se l'ordine è nello storico
            $userOrdersCollection = Mage::getModel("fborder/order")->getCollection()
                ->addFieldToFilter("customer_id",array("eq" => $userId))
                ->addFieldToFilter("increment_id",array("eq" => $orderParam));            
            if($userOrdersCollection->count() > 0){
                $this->__sendFile(Mage::getBaseDir().DS.Mage::getStoreConfig("iris_files/settings/invoice_directory").DS.$invoicePrefix.$orderParam.".pdf");
            }else{
                return;
            }
        }
        return;
    }
    
    
    protected function __sendFile($pdfPath) {
        if (!is_file($pdfPath) || !is_readable($pdfPath)) {
            throw new Exception("File non trovato: ".$pdfPath);
        }
        $this->getResponse()
                ->setHttpResponseCode(200)
                ->setHeader('Pragma', 'public', true)
                ->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
                /* View in browser */
                //->setHeader ( 'Content-type', 'application/pdf', true )
                /*  Download */
                ->setHeader('Content-type', 'application/force-download')
                ->setHeader('Content-Length', filesize($pdfPath))
                ->setHeader('Content-Disposition', 'inline' . '; filename=' . basename($pdfPath));
        $this->getResponse()->clearBody();
        $this->getResponse()->sendHeaders();
        readfile($pdfPath);
        exit(0);
    }    

}