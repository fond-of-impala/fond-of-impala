<?php

namespace FondOfImpala\Client\DocumentTypeErpOrder;

use Codeception\Test\Unit;
use FondOfImpala\Client\DocumentTypeErpOrder\Dependency\Client\DocumentTypeErpOrderToZedRequestClientInterface;
use FondOfImpala\Client\DocumentTypeErpOrder\Zed\DocumentTypeErpOrderStub;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;

class DocumentTypeErpOrderFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \FondOfImpala\Client\DocumentTypeErpOrder\Dependency\Client\DocumentTypeErpOrderToZedRequestClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|DocumentTypeErpOrderToZedRequestClientInterface $zedRequestClientMock;

    /**
     * @var \FondOfImpala\Client\DocumentTypeErpOrder\DocumentTypeErpOrderFactory
     */
    protected DocumentTypeErpOrderFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(DocumentTypeErpOrderToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new DocumentTypeErpOrderFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateDocumentTypeErpOrderStub(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(DocumentTypeErpOrderDependencyProvider::CLIENT_ZED_REQUEST)
            ->willReturn($this->zedRequestClientMock);

        static::assertInstanceOf(
            DocumentTypeErpOrderStub::class,
            $this->factory
                ->createZedDocumentTypeErpOrderStub(),
        );
    }
}
