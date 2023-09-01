<?php

namespace FondOfImpala\Zed\CompanyPriceList\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyPriceList\Business\Model\CompanyHydratorInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyPriceListFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyPriceList\Business\CompanyPriceListFacade
     */
    protected CompanyPriceListFacade $companyPriceListFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected MockObject|CompanyTransfer $companyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyPriceList\Business\CompanyPriceListBusinessFactory
     */
    protected MockObject|CompanyPriceListBusinessFactory $companyPriceListBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyPriceList\Business\Model\CompanyHydratorInterface
     */
    protected MockObject|CompanyHydratorInterface $companyHydratorInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyPriceListBusinessFactoryMock = $this->getMockBuilder(CompanyPriceListBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyHydratorInterfaceMock = $this->getMockBuilder(CompanyHydratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyPriceListFacade = new CompanyPriceListFacade();
        $this->companyPriceListFacade->setFactory($this->companyPriceListBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testHydrateCompany(): void
    {
        $this->companyPriceListBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createCompanyHydrator')
            ->willReturn($this->companyHydratorInterfaceMock);

        $this->companyHydratorInterfaceMock->expects(static::atLeastOnce())
            ->method('hydrate')
            ->with($this->companyTransferMock)
            ->willReturn($this->companyTransferMock);

        static::assertEquals(
            $this->companyTransferMock,
            $this->companyPriceListFacade->hydrateCompany(
                $this->companyTransferMock,
            ),
        );
    }
}
