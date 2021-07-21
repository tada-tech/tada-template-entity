<?php
declare(strict_types=1);

namespace Tada\TemplateEntity\Test\Integration;

use Magento\Framework\Exception\NoSuchEntityException;
use PHPUnit\Framework\TestCase;
use Magento\TestFramework\Helper\Bootstrap;
use Tada\TemplateEntity\Api\Data\TemplateEntityInterface;
use Tada\TemplateEntity\Api\TemplateEntityRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Tada\TemplateEntity\Model\TemplateEntity;
use Tada\TemplateEntity\Model\TemplateEntityFactory;

class TemplateEntityRepositoryTest extends TestCase
{
    /**
     * @var TemplateEntityRepositoryInterface
     */
    protected $templateEntityRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var TemplateEntityFactory
     */
    protected $templateEntityFactory;

    protected function setUp()
    {
        $this->templateEntityRepository = Bootstrap::getObjectManager()->get(TemplateEntityRepositoryInterface::class);
        $this->searchCriteriaBuilder = Bootstrap::getObjectManager()->get(SearchCriteriaBuilder::class);
        $this->templateEntityFactory = Bootstrap::getObjectManager()->get(TemplateEntityFactory::class);
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoDataFixture Tada_TemplateEntity::Test/_files/template_entities.php
     */
    public function testGetList()
    {
        $data = [
            'attribute_one' => "Attribute Number One",
            'attribute_two' => 10,
            'attribute_three' => 24
        ];
        /** @var SearchCriteriaInterface $searchCriteria */
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(TemplateEntityInterface::ATTRIBUTE_ONE, $data['attribute_one'])
            ->create();

        $results = $this->templateEntityRepository->getList($searchCriteria)->getItems();
        $firstItem = current($results);
        unset($firstItem['entity_id']);

        $this->assertEquals($data, $firstItem->getData());
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoDataFixture Tada_TemplateEntity::Test/_files/template_entities.php
     */
    public function testDelete()
    {
        /** @var SearchCriteriaInterface $searchCriteria */
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(TemplateEntityInterface::ATTRIBUTE_ONE, "Attribute Number One")
            ->create();

        $results = $this->templateEntityRepository->getList($searchCriteria)->getItems();
        $firstItem = current($results);
        $entityId = (int) $firstItem->getEntityId();

        $this->templateEntityRepository->delete($firstItem);

        $this->expectException(NoSuchEntityException::class);
        $this->expectExceptionMessage('No such entity with entityId = '. $entityId);
        $this->templateEntityRepository->get($entityId);
    }

    public function testSaveWithCreate()
    {
        $data = [
            'attribute_one' => 'MAFL#R!FFAFa',
            'attribute_two' => 53,
            'attribute_three' => 443
        ];

        /** @var TemplateEntity $model */
        $model =  $this->templateEntityFactory->create();
        $model->setData($data);
        $newModel = $this->templateEntityRepository->save($model);

        $entityId = $newModel->getEntityId();
        $this->assertNotNull($entityId);
    }

    /**
     * @magentoAppIsolation enabled
     */
    public function testSaveWithUpdate()
    {
        $data = [
            'attribute_one' => 'MAFL#R!FFAFa',
            'attribute_two' => 53,
            'attribute_three' => 443
        ];

        /** @var TemplateEntity $model */
        $model =  $this->templateEntityFactory->create();
        $model->setData($data);
        $newModel = $this->templateEntityRepository->save($model);
        $entityId = (int) $newModel->getEntityId();

        $attributeOneNeedUpdate = ")%!*%!(f1f1";
        /** @var TemplateEntity $model */
        $model = $this->templateEntityRepository->get($entityId);
        $model->setAttributeOne($attributeOneNeedUpdate);
        $updatedModel = $this->templateEntityRepository->save($model);

        $this->assertEquals($entityId, $updatedModel->getEntityId());
        $this->assertEquals($attributeOneNeedUpdate, $updatedModel->getAttributeOne());
    }
}
