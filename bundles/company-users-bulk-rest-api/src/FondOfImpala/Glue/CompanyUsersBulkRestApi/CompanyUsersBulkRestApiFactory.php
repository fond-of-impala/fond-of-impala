<?php

namespace FondOfImpala\Glue\CompanyUsersBulkRestApi;

use FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Builder\RestResponseBuilder;
use FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\CompanyUsersBulk\CompanyUsersBulkProcessor;
use FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\CompanyUsersBulk\CompanyUsersBulkProcessorInterface;
use FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Mapper\RestCompanyUsersBulkRequestMapper;
use FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Mapper\RestCompanyUsersBulkRequestMapperInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfImpala\Client\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiClientInterface getClient()
 */
class CompanyUsersBulkRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\CompanyUsersBulk\CompanyUsersBulkProcessorInterface
     */
    public function createCompanyUsersBulkProcessor(): CompanyUsersBulkProcessorInterface
    {
        return new CompanyUsersBulkProcessor(
            $this->createRestCompanyUsersBulkRequestMapper(),
            $this->getClient(),
            $this->createRestResponseBuilder(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Mapper\RestCompanyUsersBulkRequestMapperInterface
     */
    protected function createRestCompanyUsersBulkRequestMapper(): RestCompanyUsersBulkRequestMapperInterface
    {
        return new RestCompanyUsersBulkRequestMapper();
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Builder\RestResponseBuilderInterface
     */
    protected function createRestResponseBuilder(): RestResponseBuilderInterface
    {
        return new RestResponseBuilder($this->getResourceBuilder());
    }
}
