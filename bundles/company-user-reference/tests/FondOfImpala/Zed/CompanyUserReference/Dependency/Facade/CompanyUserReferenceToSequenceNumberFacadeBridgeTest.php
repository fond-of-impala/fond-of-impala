<?php

namespace FondOfImpala\Zed\CompanyUserReference\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\SequenceNumberSettingsTransfer;
use Spryker\Zed\SequenceNumber\Business\SequenceNumberFacadeInterface;

class CompanyUserReferenceToSequenceNumberFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToSequenceNumberFacadeBridge
     */
    protected $companyUserReferenceToSequenceNumberFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\SequenceNumber\Business\SequenceNumberFacadeInterface
     */
    protected $sequenceNumberFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\SequenceNumberSettingsTransfer
     */
    protected $sequenceNumberSettingsTransferMock;

    /**
     * @var string
     */
    protected $generatedString;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->sequenceNumberFacadeInterfaceMock = $this->getMockBuilder(SequenceNumberFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->sequenceNumberSettingsTransferMock = $this->getMockBuilder(SequenceNumberSettingsTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->generatedString = 'generated-string';

        $this->companyUserReferenceToSequenceNumberFacadeBridge = new CompanyUserReferenceToSequenceNumberFacadeBridge(
            $this->sequenceNumberFacadeInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testGenerate(): void
    {
        $this->sequenceNumberFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('generate')
            ->with($this->sequenceNumberSettingsTransferMock)
            ->willReturn($this->generatedString);

        $this->assertSame(
            $this->generatedString,
            $this->companyUserReferenceToSequenceNumberFacadeBridge->generate(
                $this->sequenceNumberSettingsTransferMock,
            ),
        );
    }
}
