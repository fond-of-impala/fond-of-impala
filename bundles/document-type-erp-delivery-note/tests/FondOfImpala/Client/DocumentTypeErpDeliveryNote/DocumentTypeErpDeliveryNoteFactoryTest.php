<?php

namespace FondOfImpala\Client\DocumentTypeErpDeliveryNote;

use Codeception\Test\Unit;
use FondOfImpala\Client\DocumentTypeErpDeliveryNote\Dependency\Client\DocumentTypeErpDeliveryNoteToZedRequestClientInterface;
use FondOfImpala\Client\DocumentTypeErpDeliveryNote\Zed\DocumentTypeErpDeliveryNoteStub;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;

class DocumentTypeErpDeliveryNoteFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \FondOfImpala\Client\DocumentTypeErpDeliveryNote\Dependency\Client\DocumentTypeErpDeliveryNoteToZedRequestClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|DocumentTypeErpDeliveryNoteToZedRequestClientInterface $zedRequestClientMock;

    /**
     * @var \FondOfImpala\Client\DocumentTypeErpDeliveryNote\DocumentTypeErpDeliveryNoteFactory
     */
    protected DocumentTypeErpDeliveryNoteFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(DocumentTypeErpDeliveryNoteToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new DocumentTypeErpDeliveryNoteFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateDocumentTypeErpDeliveryNoteStub(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(DocumentTypeErpDeliveryNoteDependencyProvider::CLIENT_ZED_REQUEST)
            ->willReturn($this->zedRequestClientMock);

        static::assertInstanceOf(
            DocumentTypeErpDeliveryNoteStub::class,
            $this->factory
                ->createZedDocumentTypeErpDeliveryNoteStub(),
        );
    }
}
