<?php
declare(strict_types=1);

namespace Tada\TemplateEntity\Test\Integration;

use PHPUnit\Framework\TestCase;
use Magento\TestFramework\Helper\Bootstrap;
use Tada\TemplateEntity\Api\TemplateEntityRepositoryInterface;
use Tada\TemplateEntity\Api\Data\TemplateEntityInterfaceFactory;

class TemplateEntityRepositoryTest extends TestCase
{
    protected $templateEntityRepository;

    protected function setUp()
    {
        parent::setUp();
        $this->templateEntityRepository = Bootstrap::getObjectManager()->get(TemplateEntityRepositoryInterface::class);
    }

    /**
     * @magentoDataFixture Tada_TemplateEntity::Test/_files/template_entities.php
     */
    public function testGetList()
    {
        $attributeOne = "Attribute Number One";
        $collection = $this->templateEntityRepository->getList();
        $item = $collection->addFieldToFilter('attribute_one', ['eq' => 'Attribute Number One'])->getFirstItem();

        $actualData = $item->getAttributeOne();
        self::assertEquals($attributeOne, $actualData);
    }

    public function testCreateAndDeleteEntity()
    {
        $objectManager = Bootstrap::getObjectManager();
        $templateEntityFactory = $objectManager->get(TemplateEntityInterfaceFactory::class);
        $templateEntityRepository = $objectManager->get(TemplateEntityRepositoryInterface::class);

        $data = [
            'attribute_one' => "Nghia Dang 2",
            'attribute_two' => '10',
            'attribute_three' => '23'
        ];

        $entity = $templateEntityFactory->create();
        $entity->setData($data);
        $templateEntityRepository->save($entity);
        $data['entity_id'] = $entity->getEntityId();

        $actualResult = $this->templateEntityRepository->get($data['entity_id'])->getData();

        self::assertEquals($data['entity_id'], $actualResult['entity_id']);

        //Clean Up
        $this->templateEntityRepository->delete($entity);
    }
}
