<?php

class DataExchange_Iris_Block_Adminhtml_Inventory_Iris_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('inventoryirisGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {

        $collection = Mage::getModel('iris/action_inventory')->getCollection();
        $collection->getSelect()
                ->group(array('sku'));
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('id', array(
            'header' => Mage::helper('iris')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'id',
        ));

        $this->addColumn('sku', array(
            'header' => Mage::helper('iris')->__('Sku'),
            'align' => 'left',
            'index' => 'sku',
        ));

//        $this->addColumn('action_type', array(
//            'header' => Mage::helper('iris')->__('Action Type'),
//            'align' => 'left',
//            'index' => 'action_type',
//        ));
//
//        $this->addColumn('status', array(
//            'header' => Mage::helper('iris')->__('Status'),
//            'align' => 'left',
//            'index' => 'status',
//        ));
//
//        $this->addColumn('created_at', array(
//            'header' => Mage::helper('iris')->__('Created At'),
//            'align' => 'left',
//            'index' => 'created_at',
//        ));
//
//        $this->addColumn('updated_at', array(
//            'header' => Mage::helper('iris')->__('Updated At'),
//            'align' => 'left',
//            'index' => 'updated_at',
//        ));
//
//        $this->addColumn('source', array(
//            'header' => Mage::helper('iris')->__('Source'),
//            'align' => 'left',
//            'index' => 'source',
//        ));
//
//        /*
//          $this->addColumn('content', array(
//          'header'    => Mage::helper('web')->__('Item Content'),
//          'width'     => '150px',
//          'index'     => 'content',
//          ));
//         */
//
//        $this->addColumn('status', array(
//            'header' => Mage::helper('web')->__('Status'),
//            'align' => 'left',
//            'width' => '80px',
//            'index' => 'status',
//            'type' => 'options',
//            'options' => array(
//                1 => 'Enabled',
//                2 => 'Disabled',
//            ),
//        ));
//
//        $this->addColumn('action', array(
//            'header' => Mage::helper('web')->__('Action'),
//            'width' => '100',
//            'type' => 'action',
//            'getter' => 'getId',
//            'actions' => array(
//                array(
//                    'caption' => Mage::helper('web')->__('Edit'),
//                    'url' => array('base' => '*/*/edit'),
//                    'field' => 'id'
//                )
//            ),
//            'filter' => false,
//            'sortable' => false,
//            'index' => 'stores',
//            'is_system' => true,
//        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('iris')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('iris')->__('XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction() {
//        $this->setMassactionIdField('web_id');
//        $this->getMassactionBlock()->setFormFieldName('web');
//
//        $this->getMassactionBlock()->addItem('delete', array(
//            'label' => Mage::helper('web')->__('Delete'),
//            'url' => $this->getUrl('*/*/massDelete'),
//            'confirm' => Mage::helper('web')->__('Are you sure?')
//        ));
//
//        $statuses = Mage::getSingleton('web/status')->getOptionArray();
//
//        array_unshift($statuses, array('label' => '', 'value' => ''));
//        $this->getMassactionBlock()->addItem('status', array(
//            'label' => Mage::helper('web')->__('Change status'),
//            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
//            'additional' => array(
//                'visibility' => array(
//                    'name' => 'status',
//                    'type' => 'select',
//                    'class' => 'required-entry',
//                    'label' => Mage::helper('web')->__('Status'),
//                    'values' => $statuses
//                )
//            )
//        ));
//        return $this;
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/view', array('id' => $row->getId()));
    }

}