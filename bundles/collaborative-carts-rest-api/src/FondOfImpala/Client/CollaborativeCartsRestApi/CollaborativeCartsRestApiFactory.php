<?php

namespace FondOfImpala\Client\CollaborativeCartsRestApi;

use FondOfImpala\Client\CollaborativeCartsRestApi\Dependency\Client\CollaborativeCartsRestApiToZedRequestClientInterface;
use FondOfImpala\Client\CollaborativeCartsRestApi\Zed\CollaborativeCartsRestApiStub;
use FondOfImpala\Client\CollaborativeCartsRestApi\Zed\CollaborativeCartsRestApiStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class CollaborativeCartsRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\CollaborativeCartsRestApi\Zed\CollaborativeCartsRestApiStubInterface
     */
    public function createCollaborativeCartsRestApiStub(): CollaborativeCartsRestApiStubInterface
    {
        return new CollaborativeCartsRestApiStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfImpala\Client\CollaborativeCartsRestApi\Dependency\Client\CollaborativeCartsRestApiToZedRequestClientInterface
     */
    protected function getZedRequestClient(): CollaborativeCartsRestApiToZedRequestClientInterface
    {
        return $this->getProvidedDependency(CollaborativeCartsRestApiDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
