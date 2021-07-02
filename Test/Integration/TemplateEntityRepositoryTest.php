<?php
namespace Tada\TemplateEntity\Test\Integration;

use PHPUnit\Framework\TestCase;
use Magento\TestFramework\Helper\Bootstrap;
use Tada\TemplateEntity\Api\TemplateEntityRepositoryInterface;

class TemplateEntityRepositoryTest extends TestCase
{
    protected $templateEntityRepository;
    protected function setUp()
    {
        parent::setUp();
        $this->templateEntityRepository = Bootstrap::getObjectManager()->get(TemplateEntityRepositoryInterface::class);
    }


//    /**
//     * @magentoDataFixture Tada_TemplateEntity::Test/_files/template_entities.php
//     */
//    public function testGetList() {
//        $data = [
//
//        ];
//        $actualData = $this->templateEntityRepository->getList()->getData();
//        self::assertEquals($data, $actualData);
//    }

    public function testCreateEntity() {
        $objectManager = Bootstrap::getObjectManager();
        $templateEntityFactory = $objectManager->get(\Tada\TemplateEntity\Api\Data\TemplateEntityInterfaceFactory::class);
        $templateEntityRepository = $objectManager->get(\Tada\TemplateEntity\Api\TemplateEntityRepositoryInterface::class);

        $data = [
            'attribute_one' => "Nghia Dang",
            'attribute_two' => 10,
            'attribute_three' => 23.5
        ];

        $entity = $templateEntityFactory->create(['data' => $data]);
        $templateEntityRepository->save($entity);

        $data['entity_id'] = 1;
        $actualResult = $this->templateEntityRepository->get(1)->getData();

        self::assertEquals($data, $actualResult);
    }

}
