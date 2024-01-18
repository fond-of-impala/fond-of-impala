<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi;

use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Cart\CartReader;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Cart\CartReaderInterface;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Expander\CartItemByQuoteResourceRelationshipExpander;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Expander\CartItemByQuoteResourceRelationshipExpanderInterface;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper\CartItemMapper;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper\CartItemMapperInterface;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper\CartMapper;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper\CartMapperInterface;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder\CartItemRestResponseBuilder;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder\CartItemRestResponseBuilderInterface;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder\CartRestResponseBuilder;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder\CartRestResponseBuilderInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiClientInterface getClient()
 */
class CompanyBusinessUnitsCartsRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Cart\CartReaderInterface
     */
    public function createCartReader(): CartReaderInterface
    {
        return new CartReader(
            $this->getClient(),
            $this->createCartRestResponseBuilder(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder\CartRestResponseBuilderInterface
     */
    protected function createCartRestResponseBuilder(): CartRestResponseBuilderInterface
    {
        return new CartRestResponseBuilder(
            $this->getResourceBuilder(),
            $this->createCartMapper(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper\CartMapperInterface
     */
    protected function createCartMapper(): CartMapperInterface
    {
        return new CartMapper();
    }

    /**
     * @return \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Expander\CartItemByQuoteResourceRelationshipExpanderInterface
     */
    public function createCartItemByQuoteResourceRelationshipExpander(): CartItemByQuoteResourceRelationshipExpanderInterface
    {
        return new CartItemByQuoteResourceRelationshipExpander(
            $this->createCartItemRestResponseBuilder(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder\CartItemRestResponseBuilderInterface
     */
    protected function createCartItemRestResponseBuilder(): CartItemRestResponseBuilderInterface
    {
        return new CartItemRestResponseBuilder(
            $this->getResourceBuilder(),
            $this->createCartItemMapper(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper\CartItemMapperInterface
     */
    protected function createCartItemMapper(): CartItemMapperInterface
    {
        return new CartItemMapper();
    }
}
