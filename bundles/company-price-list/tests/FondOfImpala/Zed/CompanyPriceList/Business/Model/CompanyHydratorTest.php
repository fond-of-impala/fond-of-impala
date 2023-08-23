<?php

namespace FondOfImpala\Zed\CompanyPriceList\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyPriceList\Dependency\Facade\CompanyPriceListToPriceListFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\PriceListTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyHydratorTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyPriceList\Business\Model\CompanyHydrator
     */
    protected CompanyHydrator $companyHydrator;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyPriceList\Dependency\Facade\CompanyPriceListToPriceListFacadeInterface
     */
    protected MockObject|CompanyPriceListToPriceListFacadeInterface $companyPriceListToPriceListFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected MockObject|CompanyTransfer $companyTransferMock;

    /**
     * @var int
     */
    protected int $idPriceList;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListTransfer
     */
    protected MockObject|PriceListTransfer $priceListTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyPriceListToPriceListFacadeInterfaceMock = $this->getMockBuilder(CompanyPriceListToPriceListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListTransferMock = $this->getMockBuilder(PriceListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idPriceList = 1;

        $this->companyHydrator = new CompanyHydrator(
            $this->companyPriceListToPriceListFacadeInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testHydrate(): void
    {
        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getFkPriceList')
            ->willReturn($this->idPriceList);

        $this->companyPriceListToPriceListFacadeInterfaceMock->expects(static::atLeastOnce())
            ->method('findPriceListById')
            ->willReturn($this->priceListTransferMock);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('setPriceList')
            ->with($this->priceListTransferMock)
            ->willReturn($this->companyTransferMock);

        static::assertEquals(
            $this->companyTransferMock,
            $this->companyHydrator->hydrate(
                $this->companyTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testHydrateIdPriceListNull(): void
    {
        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getFkPriceList')
            ->willReturn(null);

        static::assertEquals(
            $this->companyTransferMock,
            $this->companyHydrator->hydrate(
                $this->companyTransferMock,
            ),
        );
    }
}
