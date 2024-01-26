<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form\DataProvider;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityGui\Dependency\Facade\AllowedProductQuantityGuiToAllowedProductQuantityFacadeInterface;
use Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer;
use Generated\Shared\Transfer\AllowedProductQuantityTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class AllowedQuantityFormDataProviderTest extends Unit
{
    protected AllowedQuantityFormDataProvider $allowedQuantityFormDataProvider;

    protected MockObject|AllowedProductQuantityGuiToAllowedProductQuantityFacadeInterface $allowedProductQuantityFacadeMock;

    protected int $idProductAbstract;

    protected MockObject|AllowedProductQuantityResponseTransfer $allowedProductQuantityResponseTransferMock;

    protected MockObject|AllowedProductQuantityTransfer $allowedProductQuantityTransferMock;

    protected array $options;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->allowedProductQuantityFacadeMock = $this->getMockBuilder(AllowedProductQuantityGuiToAllowedProductQuantityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityResponseTransferMock = $this->getMockBuilder(AllowedProductQuantityResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityTransferMock = $this->getMockBuilder(AllowedProductQuantityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idProductAbstract = 1;

        $this->options = [];

        $this->allowedQuantityFormDataProvider = new AllowedQuantityFormDataProvider($this->allowedProductQuantityFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetOptions(): void
    {
        $this->allowedProductQuantityFacadeMock->expects($this->atLeastOnce())
            ->method('findProductAbstractAllowedQuantity')
            ->willReturn($this->allowedProductQuantityResponseTransferMock);

        $this->allowedProductQuantityResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->allowedProductQuantityResponseTransferMock->expects($this->atLeastOnce())
            ->method('getAllowedProductQuantityTransfer')
            ->willReturn($this->allowedProductQuantityTransferMock);

        $this->allowedProductQuantityTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn($this->options);

        $this->assertIsArray($this->allowedQuantityFormDataProvider->getOptions($this->idProductAbstract));
    }

    /**
     * @return void
     */
    public function testGetOptionsIsNotSuccessful(): void
    {
        $this->allowedProductQuantityFacadeMock->expects($this->atLeastOnce())
            ->method('findProductAbstractAllowedQuantity')
            ->willReturn($this->allowedProductQuantityResponseTransferMock);

        $this->allowedProductQuantityResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->assertIsArray($this->allowedQuantityFormDataProvider->getOptions($this->idProductAbstract));
    }

    /**
     * @return void
     */
    public function testGetOptionsNoIdProductAbstract(): void
    {
        $this->assertIsArray($this->allowedQuantityFormDataProvider->getOptions());
    }
}
