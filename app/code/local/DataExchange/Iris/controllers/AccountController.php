<?php

require_once Mage::getModuleDir('controllers', 'Mage_Customer') . DS . 'AccountController.php';

class DataExchange_Iris_AccountController extends Mage_Customer_AccountController {
    /**
     * Login post action
     */
    public function loginPostAction() {

        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/*/');
            return;
        }
        $session = $this->_getSession();

        if ($this->getRequest()->isPost()) {
            $login = $this->getRequest()->getPost('login');
            if (!empty($login['username']) && !empty($login['password'])) {
                try {
                    $session->login($login['username'], $login['password']);
                    if ($session->getCustomer()->getIsJustConfirmed()) {
                        $this->_welcomeCustomer($session->getCustomer(), true);
                    }
                } catch (Mage_Core_Exception $e) {
                    switch ($e->getCode()) {
                        case Mage_Customer_Model_Customer::EXCEPTION_EMAIL_NOT_CONFIRMED:
                            $value = Mage::helper('customer')->getEmailConfirmationUrl($login['username']);
                            $message = Mage::helper('customer')->__('This account is not confirmed. <a href="%s">Click here</a> to resend confirmation email.', $value);
                            break;
                        case Mage_Customer_Model_Customer::EXCEPTION_INVALID_EMAIL_OR_PASSWORD:
                            //se opzione abilitata
                            if(Mage::getStoreConfig("iris_customer/settings/reset_password") == "1"){
                                $customer = Mage::getModel('customer/customer')
                                        ->setWebsiteId(Mage::app()->getWebsite()->getId())
                                        ->loadByEmail($login['username']);

                                if ($customer->getId()) {

                                    if ($customer->getIsFirstLogin()) {
                                        try {
                                            $customer->changePassword($customer->generatePassword(8))
                                                    ->sendPasswordReminderEmail()
                                                    ->setIsFirstLogin(0)
                                                    ->save();

                                            $e->setMessage($this->__("This is your first login. A new password has been sent to your email. Please check it."));
                                        } catch (Exception $ex) {
                                            Mage::log($ex->getMessage());
                                        }
                                    }
                                }
                            }
                            $message = $e->getMessage();
                            break;
                        default:
                            $message = $e->getMessage();
                    }
                    $session->addError($message);
                    $session->setUsername($login['username']);
                } catch (Exception $e) {
                    // Mage::logException($e); // PA DSS violation: this exception log can disclose customer password
                }
            } else {
                $session->addError($this->__('Login and password are required.'));
            }
        }

        $this->_loginPostRedirect();
    }
}