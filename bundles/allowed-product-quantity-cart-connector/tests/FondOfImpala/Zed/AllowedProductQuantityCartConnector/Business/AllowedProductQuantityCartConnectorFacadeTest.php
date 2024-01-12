<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\ItemValidatorInterface;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\QuoteValidatorInterface;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class AllowedProductQuantityCartConnectorFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\AllowedProductQuantityCartConnectorBusinessFactory
     */
    protected $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\QuoteValidatorInterface
     */
    protected $quoteValidatorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\ItemValidatorInterface
     */
    protected $itemValidatorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected $itemTransferMock;

    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\AllowedProductQuantityCartConnectorFacade
     */
    protected $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(AllowedProductQuantityCartConnectorBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteValidatorMock = $this->getMockBuilder(QuoteValidatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemValidatorMock = $this->getMockBuilder(ItemValidatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new AllowedProductQuantityCartConnectorFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testValidateQuote(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createQuoteValidator')
            ->willReturn($this->quoteValidatorMock);

        $this->quoteValidatorMock->expects(static::atLeastOnce())
            ->method('validateAndAppendResult')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        static::assertEquals($this->quoteTransferMock, $this->facade->validateQuote($this->quoteTransferMock));
    }

    /**
     * @return void
     */
    public function testValidateQuoteItem(): void
    {
        $messageTransfers = new ArrayObject();

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createItemValidator')
            ->willReturn($this->itemValidatorMock);

        $this->itemValidatorMock->expects(static::atLeastOnce())
            ->method('validate')
            ->with($this->itemTransferMock, null)
            ->willReturn($messageTransfers);

        static::assertEquals(
            $messageTransfers->getArrayCopy(),
            $this->facade->validateQuoteItem($this->itemTransferMock),
        );
    }
}
