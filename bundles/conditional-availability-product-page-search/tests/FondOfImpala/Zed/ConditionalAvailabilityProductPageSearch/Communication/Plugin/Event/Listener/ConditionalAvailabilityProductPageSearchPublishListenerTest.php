<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\Event\Listener;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\ConditionalAvailabilityProductPageSearchCommunicationFactory;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Generated\Shared\Transfer\EventEntityTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityProductPageSearchPublishListenerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityCollectionTransfer
     */
    protected MockObject|ConditionalAvailabilityCollectionTransfer $conditionalAvailabilityCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityTransfer
     */
    protected MockObject|ConditionalAvailabilityTransfer $conditionalAvailabilityTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\ConditionalAvailabilityProductPageSearchCommunicationFactory
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchCommunicationFactory $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface $eventBehaviorFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\EventEntityTransfer
     */
    protected MockObject|EventEntityTransfer $eventEntityTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\Event\Listener\ConditionalAvailabilityProductPageSearchPublishListener
     */
    protected ConditionalAvailabilityProductPageSearchPublishListener $listener;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface $productPageSearchFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Reader\ProductAbstractReaderInterface
     */
    protected MockObject|ProductAbstractReaderInterface $productAbstractReaderMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityFacadeMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCollectionTransferMock = $this->getMockBuilder(ConditionalAvailabilityCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityTransferMock = $this->getMockBuilder(ConditionalAvailabilityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventBehaviorFacadeMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventEntityTransferMock = $this->getMockBuilder(EventEntityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchCommunicationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractReaderMock = $this->getMockBuilder(ProductAbstractReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productPageSearchFacadeMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->listener = new ConditionalAvailabilityProductPageSearchPublishListener();
        $this->listener->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testHandleBulk(): void
    {
        $eventEntityTransfers = [$this->eventEntityTransferMock];
        $conditionalAvailabilityIds = [1];
        $productAbstractIds = [1];
        $conditionalAvailabilities = new ArrayObject();
        $conditionalAvailabilities->append($this->conditionalAvailabilityTransferMock);
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getEventBehaviorFacade')
            ->willReturn($this->eventBehaviorFacadeMock);

        $this->eventBehaviorFacadeMock->expects(static::atLeastOnce())
            ->method('getEventTransferForeignKeys')
            ->with($eventEntityTransfers)
            ->willReturn($conditionalAvailabilityIds);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityFacade')
            ->willReturn($this->conditionalAvailabilityFacadeMock);

        $this->conditionalAvailabilityFacadeMock->expects(static::atLeastOnce())
            ->method('findConditionalAvailabilities')
            ->willReturn($this->conditionalAvailabilityCollectionTransferMock);

        $this->conditionalAvailabilityCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilities')
            ->willReturn($conditionalAvailabilities);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getFkProduct')
            ->willReturn(1);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createProductAbstractReader')
            ->willReturn($this->productAbstractReaderMock);

        $this->productAbstractReaderMock->expects(static::atLeastOnce())
            ->method('getProductAbstractIdsByConcreteIds')
            ->with([1])
            ->willReturn($productAbstractIds);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getProductPageSearchFacade')
            ->willReturn($this->productPageSearchFacadeMock);

        $this->productPageSearchFacadeMock->expects(static::atLeastOnce())
            ->method('publishProductConcretes')
            ->with([1]);

        $this->productPageSearchFacadeMock->expects(static::atLeastOnce())
            ->method('publish')
            ->with($productAbstractIds);

        $this->listener->handleBulk($eventEntityTransfers, 'eventName');
    }
}
