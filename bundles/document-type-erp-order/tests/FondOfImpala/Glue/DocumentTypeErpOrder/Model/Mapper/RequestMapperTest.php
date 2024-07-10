<?php

namespace FondOfImpala\Glue\DocumentTypeErpOrder\Model\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\DocumentRestRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RequestMapperTest extends Unit
{
    protected DocumentRestRequestTransfer|MockObject $documentRestRequestTransferMock;

    protected RequestMapper $mapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->documentRestRequestTransferMock = $this->getMockBuilder(DocumentRestRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mapper = new RequestMapper();
    }

    /**
     * @return void
     */
    public function testFromRestRequest(): void
    {
        $this->documentRestRequestTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        static::assertInstanceOf(
            DocumentRequestTransfer::class,
            $this->mapper->fromRestRequest(
                $this->documentRestRequestTransferMock,
            ),
        );
    }
}
