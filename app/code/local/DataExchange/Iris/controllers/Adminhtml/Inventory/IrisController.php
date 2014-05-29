<?php

class DataExchange_Iris_Adminhtml_Inventory_IrisController extends Mage_Adminhtml_Controller_action {

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('iris/inventory')
                ->_addBreadcrumb(Mage::helper('iris')->__('Inventory Manager'), Mage::helper('iris')->__('Inventory Manager'));

        return $this;
    }

    public function indexAction() {
        $this->_initAction()
                ->renderLayout();
    }

    public function viewAction() {
        $this->_title($this->__('Iris'))->_title($this->__('Inventory'));

        if (($iris = $this->_initInventory()) !== false) {
            $this->_initAction();

            $this->_title(sprintf("#%s", $iris->getId()));

            $this->renderLayout();
        }
    }

    protected function _initInventory() {
        $id = $this->getRequest()->getParam('id');
        $iris = Mage::getModel('iris/action_inventory')->load($id);
        //print_r($order->getData());

        if (!$iris->getId()) {
            $this->_getSession()->addError($this->__('This action no longer exists.'));
            $this->_redirect('*/*/');
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return false;
        }

        Mage::register('iris_action_inventory', $iris);
        Mage::register('current_action_inventory', $iris);
        return $iris;
    }

    protected function _sendUploadResponse($fileName, $content, $contentType = 'application/octet-stream') {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK', '');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename=' . $fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }

}