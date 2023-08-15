<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceProductFacadeInterface;
use FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListEntityManagerInterface;
use FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListRepositoryInterface;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductDimensionTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\Kernel\Transfer\EntityTransferInterface;

class PriceListPriceWriterTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Business\Model\PriceListPriceWriter
     */
    protected PriceListPriceWriter $priceListPriceWriter;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceProductFacadeInterface
     */
    protected MockObject|PriceProductPriceListToPriceProductFacadeInterface $priceProductFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListRepositoryInterface
     */
    protected MockObject|PriceProductPriceListRepositoryInterface $repositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListEntityManagerInterface
     */
    protected MockObject|PriceProductPriceListEntityManagerInterface $entityManagerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductTransfer
     */
    protected MockObject|PriceProductTransfer $priceProductTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductDimensionTransfer
     */
    protected MockObject|PriceProductDimensionTransfer $priceProductDimensionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\MoneyValueTransfer
     */
    protected MockObject|MoneyValueTransfer $moneyValueTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\Transfer\EntityTransferInterface
     */
    protected MockObject|EntityTransferInterface $entityTransferInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceProductFacadeMock = $this->getMockBuilder(PriceProductPriceListToPriceProductFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(PriceProductPriceListRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityManagerMock = $this->getMockBuilder(PriceProductPriceListEntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductTransferMock = $this->getMockBuilder(PriceProductTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductDimensionTransferMock = $this->getMockBuilder(PriceProductDimensionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->moneyValueTransferMock = $this->getMockBuilder(MoneyValueTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityTransferInterfaceMock = $this->getMockBuilder(EntityTransferInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListPriceWriter = new PriceListPriceWriter(
            $this->priceProductFacadeMock,
            $this->repositoryMock,
            $this->entityManagerMock,
        );
    }

    /**
     * @return void
     */
    public function testDeleteByIdPriceProductStore(): void
    {
        $this->priceListPriceWriter->deleteByIdPriceProductStore(1);
    }
}
