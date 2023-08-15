<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\Model\CompanyBusinessUnitExpanderInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyBusinessUnitPriceListFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\CompanyBusinessUnitPriceListFacade
     */
    protected CompanyBusinessUnitPriceListFacade $companyBusinessUnitPriceListFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\CompanyBusinessUnitPriceListBusinessFactory
     */
    protected MockObject|CompanyBusinessUnitPriceListBusinessFactory $companyBusinessUnitPriceListBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected MockObject|CompanyBusinessUnitTransfer $companyBusinessUnitTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\Model\CompanyBusinessUnitExpanderInterface
     */
    protected MockObject|CompanyBusinessUnitExpanderInterface $companyBusinessUnitExpanderInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitPriceListBusinessFactoryMock = $this->getMockBuilder(CompanyBusinessUnitPriceListBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitExpanderInterfaceMock = $this->getMockBuilder(CompanyBusinessUnitExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitPriceListFacade = new CompanyBusinessUnitPriceListFacade();
        $this->companyBusinessUnitPriceListFacade->setFactory($this->companyBusinessUnitPriceListBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testExpandCompanyBusinessUnit(): void
    {
        $this->companyBusinessUnitPriceListBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createCompanyBusinessUnitExpander')
            ->willReturn($this->companyBusinessUnitExpanderInterfaceMock);

        $this->companyBusinessUnitExpanderInterfaceMock->expects(static::atLeastOnce())
            ->method('expand')
            ->willReturn($this->companyBusinessUnitTransferMock);

        static::assertInstanceOf(
            CompanyBusinessUnitTransfer::class,
            $this->companyBusinessUnitPriceListFacade->expandCompanyBusinessUnit($this->companyBusinessUnitTransferMock),
        );
    }
}
