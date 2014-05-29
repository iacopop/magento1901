<?php

class DataExchange_Iris_Model_Parser_Customer_Csv_Default extends DataExchange_Iris_Model_Parser_Customer_Abstract {

    private $filePath;
    private $ftpHost;
    private $ftpUser;
    private $ftpPass;
    private $directory;

    /**
     * TODO: inserire nel costruttore i parametri necessari a prendere i file
     */
    public static function fromLocalFile($filePath) {
        $parser = new DataExchange_Iris_Model_Parser_Customer_Csv_Default();
        $parser->filePath = $filePath;

        return $parser;
    }

    public function setFilePath($filePath) {
        $this->filePath = $filePath;
        return $this;
    }

    public function setDirectory($dir) {
        $this->directory = $dir;
        return $this;
    }

    public static function fromFtpFile($filePath, $ftpHost, $ftpUser, $ftpPass) {
        $parser = new DataExchange_Iris_Model_Parser_Product_Csv_Default();
        $parser->filePath = $filePath;
        $parser->ftpHost = $ftpHost;
        $parser->ftpUser = $ftpUser;
        $parser->ftpPass = $ftpPass;

        return $parser;
    }

    /**
     * legge il file csv e ritorna un oggetto 
     */
    public function readData() {
        $returnArray = array();
        $files = $this->_getFilesToBeProcessed();

        foreach ($files as $file) {
            $handle = fopen($file, "r");
            while (($data = fgetcsv($handle, 0, ';')) !== false) {
                //inizio il parsing

                $curCustomer = new DataExchange_Iris_Model_Data_Customer_Default();
                $curCustomer->setSource($this->filePath);
                
                $curCustomer->setCustomerEmail($data[2]);
                $curCustomer->setPassword($data[3]);
                $curCustomer->setBillingFirstname($data[4]);
                $curCustomer->setBillingLastname($data[5]);
                $curCustomer->setBillingCompany($data[7]);
                $curCustomer->setBillingNation($data[8]);
                $curCustomer->setBillingCity($data[9]);
                $curCustomer->setBillingRegion($data[10]);
                $curCustomer->setBillingStreet($data[11]);
                $curCustomer->setBillingPhone($data[13]);
                $curCustomer->setBillingZipcode($data[14]);
                $curCustomer->setBillingVat($data[15]);
                $returnArray[] = $curCustomer;
            }
            fclose($handle);
        }
        return $returnArray;
    }

    protected function _getFilesToBeProcessed() {
        $files = array();

        if ($this->filePath)
            $files[] = $this->filePath;

        if ($this->directory) {
            foreach (scandir($this->directory) as $file) {
                if (is_file($this->directory . $file) && filesize($this->directory . $file) > 0)
                    $files[] = $this->directory . $file;
            }
        }

        return $files;
    }

}

?>
