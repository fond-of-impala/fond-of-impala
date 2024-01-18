<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Expander;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder\CartItemRestResponseBuilderInterface;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\MetadataInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CartItemByQuoteResourceRelationshipExpanderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder\CartItemRestResponseBuilderInterface
     */
    protected $cartItemRestResponseBuilderMock;

    /**
     * @var array<\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface>|array<\PHPUnit\Framework\MockObject\MockObject>
     */
    protected $restResourceMocks;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \ArrayObject|\ArrayObject<\PHPUnit\Framework\MockObject\MockObject>|\ArrayObject<\Generated\Shared\Transfer\ItemTransfer>
     */
    protected $itemTransferMocks;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\MetadataInterface
     */
    protected $metadataMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $restResourceMock;

    /**
     * @var \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Expander\CartItemByQuoteResourceRelationshipExpander
     */
    protected $cartItemByQuoteResourceRelationshipExpander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->cartItemRestResponseBuilderMock = $this->getMockBuilder(CartItemRestResponseBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMocks = [
            $this->getMockBuilder(RestResourceInterface::class)
                ->disableOriginalConstructor()
                ->getMock(),
            $this->getMockBuilder(RestResourceInterface::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMocks = new ArrayObject([
            $this->getMockBuilder(ItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ]);

        $this->metadataMock = $this->getMockBuilder(MetadataInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartItemByQuoteResourceRelationshipExpander = new CartItemByQuoteResourceRelationshipExpander(
            $this->cartItemRestResponseBuilderMock,
        );
    }

    /**
     * @return void
     */
    public function testAddResourceRelationships(): void
    {
        $locale = 'de_DE';

        $this->restResourceMocks[0]->expects(self::atLeastOnce())
            ->method('getPayload')
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getItems')
            ->willReturn($this->itemTransferMocks);

        $this->restRequestMock->expects(self::atLeastOnce())
            ->method('getMetadata')
            ->willReturn($this->metadataMock);

        $this->metadataMock->expects(self::atLeastOnce())
            ->method('getLocale')
            ->willReturn($locale);

        $this->cartItemRestResponseBuilderMock->expects(self::atLeastOnce())
            ->method('createCartItemResource')
            ->with(
                $this->restResourceMocks[0],
                $this->itemTransferMocks->offsetGet(0),
                $locale,
            )->willReturn($this->restResourceMock);

        $this->restResourceMocks[0]->expects(self::atLeastOnce())
            ->method('addRelationship')
            ->with($this->restResourceMock)
            ->willReturn($this->restResourceMocks[0]);

        $this->restResourceMocks[1]->expects(self::atLeastOnce())
            ->method('getPayload')
            ->willReturn(null);

        $this->cartItemByQuoteResourceRelationshipExpander->addResourceRelationships(
            $this->restResourceMocks,
            $this->restRequestMock,
        );
    }
}
