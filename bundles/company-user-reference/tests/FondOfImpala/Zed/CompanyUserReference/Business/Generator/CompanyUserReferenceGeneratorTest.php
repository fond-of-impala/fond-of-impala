<?php

namespace FondOfImpala\Zed\CompanyUserReference\Business\Generator;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserReference\CompanyUserReferenceConfig;
use FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToSequenceNumberFacadeInterface;
use FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToStoreFacadeInterface;
use Generated\Shared\Transfer\StoreTransfer;

class CompanyUserReferenceGeneratorTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Business\Generator\CompanyUserReferenceGenerator
     */
    protected $companyUserReferenceGenerator;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToSequenceNumberFacadeInterface
     */
    protected $companyUserReferenceToSequenceNumberFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToStoreFacadeInterface
     */
    protected $companyUserReferenceToStoreFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReference\CompanyUserReferenceConfig
     */
    protected $companyUserReferenceConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\StoreTransfer
     */
    protected $storeTransferMock;

    /**
     * @var string
     */
    protected $storeName;

    /**
     * @var string
     */
    protected $environmentPrefix;

    /**
     * @var string
     */
    protected $generatedString;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserReferenceToSequenceNumberFacadeInterfaceMock = $this->getMockBuilder(CompanyUserReferenceToSequenceNumberFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceToStoreFacadeInterfaceMock = $this->getMockBuilder(CompanyUserReferenceToStoreFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceConfigMock = $this->getMockBuilder(CompanyUserReferenceConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeTransferMock = $this->getMockBuilder(StoreTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeName = 'store-name';

        $this->environmentPrefix = 'environment-prefix';

        $this->generatedString = 'generated-string';

        $this->companyUserReferenceGenerator = new CompanyUserReferenceGenerator(
            $this->companyUserReferenceToSequenceNumberFacadeInterfaceMock,
            $this->companyUserReferenceToStoreFacadeInterfaceMock,
            $this->companyUserReferenceConfigMock,
        );
    }

    /**
     * @return void
     */
    public function testGenerate(): void
    {
        $this->companyUserReferenceToStoreFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getCurrentStore')
            ->willReturn($this->storeTransferMock);

        $this->storeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn($this->storeName);

        $this->companyUserReferenceConfigMock->expects($this->atLeastOnce())
            ->method('getEnvironmentPrefix')
            ->willReturn($this->environmentPrefix);

        $this->companyUserReferenceToSequenceNumberFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('generate')
            ->willReturn($this->generatedString);

        $this->assertSame(
            $this->generatedString,
            $this->companyUserReferenceGenerator->generate(),
        );
    }
}
