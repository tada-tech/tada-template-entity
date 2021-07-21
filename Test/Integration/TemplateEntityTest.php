<?php
declare(strict_types=1);

namespace Tada\TemplateEntity\Test\Integration;

use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;
use Tada\TemplateEntity\Api\Data\TemplateEntityExtensionFactory;
use Tada\TemplateEntity\Api\TemplateEntityRepositoryInterface;
use Tada\TemplateEntity\Model\TemplateEntity;
use Tada\TemplateEntity\Model\TemplateEntityFactory;
use Tada\TemplateEntity\Api\Data\TemplateEntityExtensionInterface;

class TemplateEntityTest extends TestCase
{
    protected $templateEntity;
    /**
     * @var TemplateEntityFactory
     */
    protected $templateEntityFactory;

    /**
     * @var mixed|TemplateEntityRepositoryInterface
     */
    protected $templateEntityRepository;

    /**
     * @var mixed|TemplateEntityExtensionFactory
     */
    protected $templateEntityExtensionFactory;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objManager;

    public function setUp()
    {
        $this->objManager = Bootstrap::getObjectManager();
        $this->templateEntityFactory = $this->objManager->get(TemplateEntityFactory::class);
        $this->templateEntityRepository = $this->objManager->get(TemplateEntityRepositoryInterface::class);
        $this->templateEntityExtensionFactory = $this->objManager->get(TemplateEntityExtensionFactory::class);
    }

    public function testSetExtensionAttributes()
    {
        $data = [
            'attribute_one' => 'MAFL#R!FFAFa',
            'attribute_two' => 53,
            'attribute_three' => 443
        ];

        $this->templateEntity = $this->templateEntityFactory->create();
        $this->templateEntity->setData($data);
        $this->templateEntity = $this->templateEntityRepository->save($this->templateEntity);
        $extensionAttributes = $this->templateEntity->getExtensionAttributes();
        $this->templateEntity->setExtensionAttributes($extensionAttributes);

        $this->assertInstanceOf(TemplateEntityExtensionInterface::class, $extensionAttributes);
        $this->assertInstanceOf(TemplateEntity::class, $this->templateEntity);
    }
}
