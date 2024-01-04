<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form\DataProvider;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityGui\Dependency\Facade\AllowedProductQuantityGuiToAllowedProductQuantityFacadeInterface;
use Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer;
use Generated\Shared\Transfer\AllowedProductQuantityTransfer;

class AllowedQuantityFormDataProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form\DataProvider\AllowedQuantityFormDataProvider
     */
    protected $allowedQuantityFormDataProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantityGui\Dependency\Facade\AllowedProductQuantityGuiToAllowedProductQuantityFacadeInterface
     */
    protected $allowedProductQuantityFacadeMock;

    /**
     * @var int
     */
    protected $idProductAbstract;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer
     */
    protected $allowedProductQuantityResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\AllowedProductQuantityTransfer
     */
    protected $allowedProductQuantityTransferMock;

    /**
     * @var array
     */
    protected $options;

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
