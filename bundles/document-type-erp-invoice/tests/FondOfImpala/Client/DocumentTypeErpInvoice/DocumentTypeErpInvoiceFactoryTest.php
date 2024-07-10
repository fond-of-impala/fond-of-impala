<?php

namespace FondOfImpala\Client\DocumentTypeErpInvoice;

use Codeception\Test\Unit;
use FondOfImpala\Client\DocumentTypeErpInvoice\Dependency\Client\DocumentTypeErpInvoiceToZedRequestClientInterface;
use FondOfImpala\Client\DocumentTypeErpInvoice\Zed\DocumentTypeErpInvoiceStub;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;

class DocumentTypeErpInvoiceFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \FondOfImpala\Client\DocumentTypeErpInvoice\Dependency\Client\DocumentTypeErpInvoiceToZedRequestClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|DocumentTypeErpInvoiceToZedRequestClientInterface $zedRequestClientMock;

    /**
     * @var \FondOfImpala\Client\DocumentTypeErpInvoice\DocumentTypeErpInvoiceFactory
     */
    protected DocumentTypeErpInvoiceFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(DocumentTypeErpInvoiceToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new DocumentTypeErpInvoiceFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateDocumentTypeErpInvoiceStub(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(DocumentTypeErpInvoiceDependencyProvider::CLIENT_ZED_REQUEST)
            ->willReturn($this->zedRequestClientMock);

        static::assertInstanceOf(
            DocumentTypeErpInvoiceStub::class,
            $this->factory
                ->createZedDocumentTypeErpInvoiceStub(),
        );
    }
}
