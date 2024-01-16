<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business;

use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Claimer\CartClaimer;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Claimer\CartClaimerInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper\ClaimCartRequestMapper;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper\ClaimCartRequestMapperInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper\ReleaseCartRequestMapper;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper\ReleaseCartRequestMapperInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Reader\QuoteReader;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Reader\QuoteReaderInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Releaser\CartReleaser;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Releaser\CartReleaserInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\CollaborativeCartsRestApiDependencyProvider;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToCollaborativeCartFacadeInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToQuoteFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class CollaborativeCartsRestApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Claimer\CartClaimerInterface
     */
    public function createCartClaimer(): CartClaimerInterface
    {
        return new CartClaimer(
            $this->createQuoteReader(),
            $this->createClaimCartRequestMapper(),
            $this->getCollaborativeCartFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Releaser\CartReleaserInterface
     */
    public function createCartReleaser(): CartReleaserInterface
    {
        return new CartReleaser(
            $this->createQuoteReader(),
            $this->createReleaseCartRequestMapper(),
            $this->getCollaborativeCartFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Reader\QuoteReaderInterface
     */
    protected function createQuoteReader(): QuoteReaderInterface
    {
        return new QuoteReader(
            $this->getQuoteFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper\ClaimCartRequestMapperInterface
     */
    protected function createClaimCartRequestMapper(): ClaimCartRequestMapperInterface
    {
        return new ClaimCartRequestMapper();
    }

    /**
     * @return \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper\ReleaseCartRequestMapperInterface
     */
    protected function createReleaseCartRequestMapper(): ReleaseCartRequestMapperInterface
    {
        return new ReleaseCartRequestMapper();
    }

    /**
     * @return \FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToQuoteFacadeInterface
     */
    protected function getQuoteFacade(): CollaborativeCartsRestApiToQuoteFacadeInterface
    {
        return $this->getProvidedDependency(CollaborativeCartsRestApiDependencyProvider::FACADE_QUOTE);
    }

    /**
     * @return \FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToCollaborativeCartFacadeInterface
     */
    protected function getCollaborativeCartFacade(): CollaborativeCartsRestApiToCollaborativeCartFacadeInterface
    {
        return $this->getProvidedDependency(CollaborativeCartsRestApiDependencyProvider::FACADE_COLLABORATIVE_CART);
    }
}
