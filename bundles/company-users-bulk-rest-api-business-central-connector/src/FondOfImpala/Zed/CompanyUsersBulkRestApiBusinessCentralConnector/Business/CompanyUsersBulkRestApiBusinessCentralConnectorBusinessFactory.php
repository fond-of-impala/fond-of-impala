<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Business;

use FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Business\Expander\CompanyDebtorNumberExpander;
use FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Business\Expander\ExpanderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Persistence\CompanyUsersBulkRestApiBusinessCentralConnectorRepositoryInterface getRepository()
 */
class CompanyUsersBulkRestApiBusinessCentralConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyUsersBulkRestApiBusinessCentralConnector\Business\Expander\ExpanderInterface
     */
    public function createCompanyDebtorNumberExpander(): ExpanderInterface
    {
        return new CompanyDebtorNumberExpander($this->getRepository());
    }
}
