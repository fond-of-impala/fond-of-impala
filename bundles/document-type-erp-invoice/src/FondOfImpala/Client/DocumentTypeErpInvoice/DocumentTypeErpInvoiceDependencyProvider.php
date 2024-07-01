<?php

namespace FondOfImpala\Client\DocumentTypeErpInvoice;

use FondOfImpala\Client\DocumentTypeErpInvoice\Dependency\Client\DocumentTypeErpInvoiceToZedRequestClientBridge;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class DocumentTypeErpInvoiceDependencyProvider extends AbstractDependencyProvider
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
        $container[static::CLIENT_ZED_REQUEST] = static fn (Container $container): DocumentTypeErpInvoiceToZedRequestClientBridge => new DocumentTypeErpInvoiceToZedRequestClientBridge($container->getLocator()->zedRequest()->client());

        return $container;
    }
}
