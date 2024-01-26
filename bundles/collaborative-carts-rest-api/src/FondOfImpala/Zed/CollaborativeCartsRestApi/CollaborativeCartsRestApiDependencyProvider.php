<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi;

use FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToCollaborativeCartFacadeBridge;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToQuoteFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CollaborativeCartsRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_QUOTE = 'FACADE_QUOTE';

    /**
     * @var string
     */
    public const FACADE_COLLABORATIVE_CART = 'FACADE_COLLABORATIVE_CART';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addQuoteFacade($container);

        return $this->addCollaborativeCartFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addQuoteFacade(Container $container): Container
    {
        $container[static::FACADE_QUOTE] = static fn (Container $container): CollaborativeCartsRestApiToQuoteFacadeBridge => new CollaborativeCartsRestApiToQuoteFacadeBridge(
            $container->getLocator()->quote()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addCollaborativeCartFacade(Container $container): Container
    {
        $container[static::FACADE_COLLABORATIVE_CART] = static fn (Container $container): CollaborativeCartsRestApiToCollaborativeCartFacadeBridge => new CollaborativeCartsRestApiToCollaborativeCartFacadeBridge(
            $container->getLocator()->collaborativeCart()->facade(),
        );

        return $container;
    }
}
