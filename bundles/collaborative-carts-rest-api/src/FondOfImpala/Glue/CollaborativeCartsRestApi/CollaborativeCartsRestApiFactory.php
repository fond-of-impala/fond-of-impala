<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi;

use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder\CollaborativeCartRestResponseBuilder;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder\CollaborativeCartRestResponseBuilderInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Claimer\CartClaimer;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Claimer\CartClaimerInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\CollaborativeCart\CollaborativeCartProcessor;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\CollaborativeCart\CollaborativeCartProcessorInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander\RestClaimCartRequestExpander;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander\RestClaimCartRequestExpanderInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander\RestReleaseCartRequestExpander;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander\RestReleaseCartRequestExpanderInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Filter\RestCustomerFilter;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Filter\RestCustomerFilterInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestClaimCartRequestMapper;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestClaimCartRequestMapperInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestCollaborativeCartsResponseAttributesMapper;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestCollaborativeCartsResponseAttributesMapperInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestReleaseCartRequestMapper;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestReleaseCartRequestMapperInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Releaser\CartReleaser;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Releaser\CartReleaserInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfImpala\Client\CollaborativeCartsRestApi\CollaborativeCartsRestApiClientInterface getClient()
 */
class CollaborativeCartsRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\CollaborativeCart\CollaborativeCartProcessorInterface
     */
    public function createCollaborativeCartProcessor(): CollaborativeCartProcessorInterface
    {
        return new CollaborativeCartProcessor(
            $this->createCollaborativeCartRestResponseBuilder(),
            $this->createCartClaimer(),
            $this->createCartReleaser(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder\CollaborativeCartRestResponseBuilderInterface
     */
    protected function createCollaborativeCartRestResponseBuilder(): CollaborativeCartRestResponseBuilderInterface
    {
        return new CollaborativeCartRestResponseBuilder(
            $this->getResourceBuilder(),
            $this->createRestCollaborativeCartsResponseAttributesMapper(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestCollaborativeCartsResponseAttributesMapperInterface
     */
    protected function createRestCollaborativeCartsResponseAttributesMapper(): RestCollaborativeCartsResponseAttributesMapperInterface
    {
        return new RestCollaborativeCartsResponseAttributesMapper();
    }

    /**
     * @return \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Claimer\CartClaimerInterface
     */
    protected function createCartClaimer(): CartClaimerInterface
    {
        return new CartClaimer(
            $this->createRestClaimCartRequestMapper(),
            $this->createRestClaimCartRequestExpander(),
            $this->createCollaborativeCartRestResponseBuilder(),
            $this->getClient(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestClaimCartRequestMapperInterface
     */
    protected function createRestClaimCartRequestMapper(): RestClaimCartRequestMapperInterface
    {
        return new RestClaimCartRequestMapper();
    }

    /**
     * @return \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander\RestClaimCartRequestExpanderInterface
     */
    protected function createRestClaimCartRequestExpander(): RestClaimCartRequestExpanderInterface
    {
        return new RestClaimCartRequestExpander($this->createRestCustomerFilter());
    }

    /**
     * @return \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Filter\RestCustomerFilterInterface
     */
    protected function createRestCustomerFilter(): RestCustomerFilterInterface
    {
        return new RestCustomerFilter();
    }

    /**
     * @return \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Releaser\CartReleaserInterface
     */
    protected function createCartReleaser(): CartReleaserInterface
    {
        return new CartReleaser(
            $this->createRestReleaseCartRequestMapper(),
            $this->createRestReleaseCartRequestExpander(),
            $this->createCollaborativeCartRestResponseBuilder(),
            $this->getClient(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestReleaseCartRequestMapperInterface
     */
    protected function createRestReleaseCartRequestMapper(): RestReleaseCartRequestMapperInterface
    {
        return new RestReleaseCartRequestMapper();
    }

    /**
     * @return \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander\RestReleaseCartRequestExpanderInterface
     */
    protected function createRestReleaseCartRequestExpander(): RestReleaseCartRequestExpanderInterface
    {
        return new RestReleaseCartRequestExpander($this->createRestCustomerFilter());
    }
}
