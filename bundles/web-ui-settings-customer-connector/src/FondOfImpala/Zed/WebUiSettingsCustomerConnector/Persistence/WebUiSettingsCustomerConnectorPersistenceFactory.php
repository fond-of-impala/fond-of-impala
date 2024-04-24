<?php

namespace FondOfImpala\Zed\WebUiSettingsCustomerConnector\Persistence;

use FondOfImpala\Zed\WebUiSettingsCustomerConnector\Persistence\Propel\Mapper\WebUiSettingsMapper;
use FondOfImpala\Zed\WebUiSettingsCustomerConnector\Persistence\Propel\Mapper\WebUiSettingsMapperInterface;
use Orm\Zed\Customer\Persistence\FoiWebUiSettingsQuery;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class WebUiSettingsCustomerConnectorPersistenceFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\WebUiSettingsCustomerConnector\Persistence\Propel\Mapper\WebUiSettingsMapperInterface
     */
    public function createWebUiSettingsMapper(): WebUiSettingsMapperInterface
    {
        return new WebUiSettingsMapper();
    }

    /**
     * @return \Orm\Zed\Customer\Persistence\FoiWebUiSettingsQuery
     */
    public function createWebUiSettingsQuery(): FoiWebUiSettingsQuery
    {
        return FoiWebUiSettingsQuery::create()->clear();
    }
}
