<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantitySearch\Business\Model\AllowedProductQuantitySearchWriterInterface;

class AllowedProductQuantitySearchFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantitySearch\Business\AllowedProductQuantitySearchFacade
     */
    protected $allowedProductQuantitySearchFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantitySearch\Business\AllowedProductQuantitySearchBusinessFactory
     */
    protected $allowedProductQuantitySearchBusinessFactoryMock;

    /**
     * @var array
     */
    protected $allowedProductQuantityIds;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantitySearch\Business\Model\AllowedProductQuantitySearchWriterInterface
     */
    protected $allowedProductQuantitySearchWriterInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->allowedProductQuantitySearchBusinessFactoryMock = $this->getMockBuilder(AllowedProductQuantitySearchBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantitySearchWriterInterfaceMock = $this->getMockBuilder(AllowedProductQuantitySearchWriterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityIds = [];

        $this->allowedProductQuantitySearchFacade = new AllowedProductQuantitySearchFacade();
        $this->allowedProductQuantitySearchFacade->setFactory($this->allowedProductQuantitySearchBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testPublish(): void
    {
        $this->allowedProductQuantitySearchBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createAllowedProductQuantitySearchWriter')
            ->willReturn($this->allowedProductQuantitySearchWriterInterfaceMock);

        $this->allowedProductQuantitySearchFacade->publish($this->allowedProductQuantityIds);
    }

    /**
     * @return void
     */
    public function testUnpublish(): void
    {
        $this->allowedProductQuantitySearchBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createAllowedProductQuantitySearchWriter')
            ->willReturn($this->allowedProductQuantitySearchWriterInterfaceMock);

        $this->allowedProductQuantitySearchFacade->unpublish($this->allowedProductQuantityIds);
    }
}
