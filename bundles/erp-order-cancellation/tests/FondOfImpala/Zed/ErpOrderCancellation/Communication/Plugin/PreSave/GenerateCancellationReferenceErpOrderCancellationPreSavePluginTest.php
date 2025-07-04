<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Communication\Plugin\PostSave;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ReaderInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Communication\ErpOrderCancellationCommunicationFactory;
use FondOfImpala\Zed\ErpOrderCancellation\Communication\Plugin\PreSave\GenerateCancellationReferenceErpOrderCancellationPreSavePlugin;
use FondOfImpala\Zed\ErpOrderCancellation\ErpOrderCancellationConfig;
use Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class GenerateCancellationReferenceErpOrderCancellationPreSavePluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    protected MockObject|ErpOrderCancellationTransfer $erpOrderCancellationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\ErpOrderCancellationConfig
     */
    protected MockObject|ErpOrderCancellationConfig $erpOrderCancellationConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer
     */
    protected MockObject|ErpOrderCancellationConfig $erpOrderCancellationCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ReaderInterface
     */
    protected MockObject|ReaderInterface $erpOrderCancellationReaderMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Communication\Plugin\PreSave\GenerateCancellationReferenceErpOrderCancellationPreSavePlugin
     */
    protected GenerateCancellationReferenceErpOrderCancellationPreSavePlugin $plugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Communication\ErpOrderCancellationCommunicationFactory
     */
    protected MockObject|ErpOrderCancellationCommunicationFactory $factoryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->erpOrderCancellationTransferMock = $this->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationConfigMock = $this->getMockBuilder(ErpOrderCancellationConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationCollectionTransferMock = $this->getMockBuilder(ErpOrderCancellationCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationReaderMock = $this->getMockBuilder(ReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(ErpOrderCancellationCommunicationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new GenerateCancellationReferenceErpOrderCancellationPreSavePlugin();
        $this->plugin->setConfig($this->erpOrderCancellationConfigMock);
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testPreSave(): void
    {
        $cancellations = new ArrayObject();
        $cancellations->append($this->erpOrderCancellationTransferMock);
        $cancellationNumber = 'prefix100000000-1';
        $prefixToReplace = 'prefixToReplace';
        $reference = $prefixToReplace . 'reference';
        $prefix = 'prefix';

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getErpOrderReference')
            ->willReturn($reference);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createErpOrderCancellationReader')
            ->willReturn($this->erpOrderCancellationReaderMock);

        $this->erpOrderCancellationReaderMock->expects(static::atLeastOnce())
            ->method('getErpOrderCancellationCollection')
            ->willReturn($this->erpOrderCancellationCollectionTransferMock);

        $this->erpOrderCancellationCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getCancellations')
            ->willReturn($cancellations);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getCancellationNumber')
            ->willReturn($cancellationNumber);

        $this->erpOrderCancellationConfigMock->expects(static::atLeastOnce())
            ->method('getPrefixToReplace')
            ->willReturn($prefixToReplace);

        $this->erpOrderCancellationConfigMock->expects(static::atLeastOnce())
            ->method('getPrefix')
            ->willReturn($prefix);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('setCancellationNumber')
            ->with('prefixreference-2')
            ->willReturn($this->erpOrderCancellationTransferMock);

        static::assertInstanceOf(
            ErpOrderCancellationTransfer::class,
            $this->plugin->preSave($this->erpOrderCancellationTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testPreSaveWithNullReference(): void
    {
        $reference = null;

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getErpOrderReference')
            ->willReturn($reference);

        static::assertInstanceOf(
            ErpOrderCancellationTransfer::class,
            $this->plugin->preSave($this->erpOrderCancellationTransferMock),
        );
    }
}
