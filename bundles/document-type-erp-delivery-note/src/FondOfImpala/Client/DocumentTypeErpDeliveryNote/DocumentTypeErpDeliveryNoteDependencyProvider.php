<?php

namespace FondOfImpala\Client\DocumentTypeErpDeliveryNote;

use FondOfImpala\Client\DocumentTypeErpDeliveryNote\Dependency\Client\DocumentTypeErpDeliveryNoteToZedRequestClientBridge;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class DocumentTypeErpDeliveryNoteDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_ZED_REQUEST = 'CLIENT_ZED_REQUEST';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = parent::provideServiceLayerDependencies($container);

        return $this->addZedRequestClient($container);
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addZedRequestClient(Container $container): Container
    {
        $container[static::CLIENT_ZED_REQUEST] = static fn (Container $container): DocumentTypeErpDeliveryNoteToZedRequestClientBridge => new DocumentTypeErpDeliveryNoteToZedRequestClientBridge($container->getLocator()->zedRequest()->client());

        return $container;
    }
}
