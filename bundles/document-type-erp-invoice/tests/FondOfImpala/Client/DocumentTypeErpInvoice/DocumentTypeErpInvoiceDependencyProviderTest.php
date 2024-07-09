<?php

namespace FondOfImpala\Client\DocumentTypeErpInvoice;

use Codeception\Test\Unit;
use FondOfImpala\Client\DocumentTypeErpInvoice\Dependency\Client\DocumentTypeErpInvoiceToZedRequestClientInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Kernel\Locator;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use Spryker\Shared\Kernel\BundleProxy;

class DocumentTypeErpInvoiceDependencyProviderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Locator
     */
    protected MockObject|Locator $locatorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\BundleProxy
     */
    protected MockObject|BundleProxy $bundleProxyMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected ZedRequestClientInterface|MockObject $zedRequestClientMock;

    /**
     * @var \FondOfImpala\Client\DocumentTypeErpInvoice\DocumentTypeErpInvoiceDependencyProvider
     */
    protected DocumentTypeErpInvoiceDependencyProvider $dependencyProvider;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->setMethodsExcept(['factory', 'set', 'offsetSet', 'get', 'offsetGet'])
            ->getMock();

        $this->locatorMock = $this->getMockBuilder(Locator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bundleProxyMock = $this->getMockBuilder(BundleProxy::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(ZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dependencyProvider = new DocumentTypeErpInvoiceDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideServiceLayerDependencies(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects(static::atLeastOnce())
            ->method('__call')
            ->with('zedRequest')
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects(static::atLeastOnce())
            ->method('__call')
            ->with('client')
            ->willReturn($this->zedRequestClientMock);

        $container = $this->dependencyProvider->provideServiceLayerDependencies(
            $this->containerMock,
        );

        static::assertEquals($container, $this->containerMock);
        static::assertInstanceOf(
            DocumentTypeErpInvoiceToZedRequestClientInterface::class,
            $container[DocumentTypeErpInvoiceDependencyProvider::CLIENT_ZED_REQUEST],
        );
    }
}
