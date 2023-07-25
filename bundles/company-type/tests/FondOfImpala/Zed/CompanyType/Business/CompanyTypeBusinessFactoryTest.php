<?php

namespace FondOfImpala\Zed\CompanyType\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeReader;
use FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeWriter;
use FondOfImpala\Zed\CompanyType\CompanyTypeConfig;
use FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeEntityManager;
use FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeRepository;

class CompanyTypeBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyType\Business\CompanyTypeBusinessFactory
     */
    protected $companyTypeBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyType\CompanyTypeConfig
     */
    protected $companyTypeConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeRepository
     */
    protected $companyTypeRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeEntityManager
     */
    protected $companyTypeEntityManagerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeConfigMock = $this->getMockBuilder(CompanyTypeConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeRepositoryMock = $this->getMockBuilder(CompanyTypeRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeEntityManagerMock = $this->getMockBuilder(CompanyTypeEntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeBusinessFactory = new CompanyTypeBusinessFactory();

        $this->companyTypeBusinessFactory->setRepository($this->companyTypeRepositoryMock)
            ->setEntityManager($this->companyTypeEntityManagerMock)
            ->setConfig($this->companyTypeConfigMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyTypeReader(): void
    {
        $this->assertInstanceOf(
            CompanyTypeReader::class,
            $this->companyTypeBusinessFactory->createCompanyTypeReader(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyTypeWriter(): void
    {
        $this->assertInstanceOf(
            CompanyTypeWriter::class,
            $this->companyTypeBusinessFactory->createCompanyTypeWriter(),
        );
    }
}
