<?php

namespace FondOfImpala\Glue\ErpOrderCancellationRestApi;

use FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Builder\RestResponseBuilder;
use FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Manager\CancellationManager;
use FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Manager\CancellationManagerInterface;
use FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Mapper\ErpOrderCancellationMapper;
use FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Mapper\ErpOrderCancellationMapperInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfImpala\Client\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiClient getClient()
 * @method \FondOfImpala\Glue\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiConfig getConfig()
 */
class ErpOrderCancellationRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Manager\CancellationManagerInterface
     */
    public function createCancellationManager(): CancellationManagerInterface
    {
        return new CancellationManager(
            $this->getClient(),
            $this->createErpOrderCancellationMapper(),
            $this->createRestResponseBuilder(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Mapper\ErpOrderCancellationMapperInterface
     */
    public function createErpOrderCancellationMapper(): ErpOrderCancellationMapperInterface
    {
        return new ErpOrderCancellationMapper();
    }

    /**
     * @return \FondOfImpala\Glue\ErpOrderCancellationRestApi\Processor\Builder\RestResponseBuilderInterface
     */
    public function createRestResponseBuilder(): RestResponseBuilderInterface
    {
        return new RestResponseBuilder($this->getResourceBuilder());
    }
}
