<?php
declare(strict_types=1);

namespace Tada\TemplateEntity\Test\Unit\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Mockery;
use Tada\TemplateEntity\Api\Data\TemplateEntitySearchResultInterface;
use Tada\TemplateEntity\Model\ResourceModel\TemplateEntity;
use Tada\TemplateEntity\Model\TemplateEntityFactory;
use Tada\TemplateEntity\Model\ResourceModel\TemplateEntity\CollectionFactory;
use Tada\TemplateEntity\Model\TemplateEntityRepository;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Tada\TemplateEntity\Api\Data\TemplateEntitySearchResultInterfaceFactory;
use Tada\TemplateEntity\Model\ResourceModel\TemplateEntity\Collection;

class TemplateEntityRepositoryTest extends TestCase
{
    /**
     * @var Mockery\MockInterface
     */
    protected $resourceModel;

    /**
     * @var Mockery\MockInterface
     */
    protected $modelFactory;

    /**
     * @var Mockery\MockInterface
     */
    protected $collectionFactory;

    /**
     * @var Mockery\MockInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var Mockery\MockInterface
     */
    protected $collectionProcessor;

    /**
     * @var Mockery\MockInterface
     */
    protected $searchResultFactory;

    /**
     * @var TemplateEntityRepository
     */
    protected $templateEntityRepository;

    /**
     * @var ObjectManager
     */
    protected $objectManager;


    protected function setUp()
    {
        $this->resourceModel = Mockery::mock(TemplateEntity::class);
        $this->modelFactory = Mockery::mock(TemplateEntityFactory::class);
        $this->collectionFactory = Mockery::mock(CollectionFactory::class);
        $this->extensionAttributesJoinProcessor = Mockery::mock(JoinProcessorInterface::class);
        $this->collectionProcessor = Mockery::mock(CollectionProcessorInterface::class);
        $this->searchResultFactory = Mockery::mock(TemplateEntitySearchResultInterfaceFactory::class);

        $this->objectManager = new ObjectManager($this);

        $this->templateEntityRepository = new TemplateEntityRepository(
            $this->resourceModel,
            $this->modelFactory,
            $this->collectionFactory,
            $this->extensionAttributesJoinProcessor,
            $this->collectionProcessor,
            $this->searchResultFactory
        );
    }

    protected function tearDown()
    {
        Mockery::close();
    }

    public function testSave()
    {
        $object = Mockery::mock(\Tada\TemplateEntity\Model\TemplateEntity::class);
        $this->resourceModel
            ->shouldReceive('save')
            ->with($object)
            ->andReturnSelf();

        $actualResult = $this->templateEntityRepository->save($object);
        $this->assertEquals($object, $actualResult);
    }

    public function testSaveWithException()
    {
        $object = Mockery::mock(\Tada\TemplateEntity\Model\TemplateEntity::class);
        $this->resourceModel
            ->shouldReceive('save')
            ->with($object)
            ->andThrow(\Exception::class);

        $object->shouldReceive('getEntityId')
            ->andReturn(1);

        $this->expectExceptionMessage('Unable to save $object with ID 1. Error: ');
        $this->templateEntityRepository->save($object);
    }

    public function testSaveWithExceptionAndNotObject()
    {
        $object = Mockery::mock(\Tada\TemplateEntity\Model\TemplateEntity::class);
        $this->resourceModel
            ->shouldReceive('save')
            ->with($object)
            ->andThrow(\Exception::class);

        $object->shouldReceive('getEntityId')
            ->andReturnNull();

        $this->expectExceptionMessage('Unable to save new $object. Error: ');

        $this->templateEntityRepository->save($object);
    }

    public function testGet()
    {
        $entityId = 1;
        $model = Mockery::mock(\Tada\TemplateEntity\Model\TemplateEntity::class);
        $this->modelFactory
            ->shouldReceive('create')
            ->andReturn($model);

        $this->resourceModel
            ->shouldReceive('load')
            ->with($model, $entityId)
            ->andReturnSelf();

        $model->shouldReceive('getEntityId')
            ->andReturn($entityId);

        $actualResult = $this->templateEntityRepository->get($entityId);
        $this->assertEquals($model, $actualResult);
    }

    public function testGetWithException()
    {
        $entityId = 0;
        $model = Mockery::mock(\Tada\TemplateEntity\Model\TemplateEntity::class);
        $this->modelFactory
            ->shouldReceive('create')
            ->andReturn($model);

        $this->resourceModel
            ->shouldReceive('load')
            ->with($model, $entityId)
            ->andReturnSelf();

        $model->shouldReceive('getEntityId')
            ->andReturn($entityId);

        $this->expectException(NoSuchEntityException::class);
        $this->expectExceptionMessage("No such entity with entityId = ${entityId}");
        $actualResult = $this->templateEntityRepository->get($entityId);
    }

    public function testDelete()
    {
        $object = Mockery::mock(\Tada\TemplateEntity\Model\TemplateEntity::class);
        $object->shouldReceive('getEntityId')
            ->andReturn(1);
        $this->resourceModel->shouldReceive('delete')
            ->with($object)
            ->andReturnSelf();
        $result = $this->templateEntityRepository->delete($object);
        $this->assertTrue($result);
    }

    public function testGetList()
    {
        $searchCriteria = Mockery::mock(SearchCriteriaInterface::class);
        $collection = Mockery::mock(Collection::class);
        $this->collectionFactory
            ->shouldReceive('create')
            ->andReturn($collection);

        $this->extensionAttributesJoinProcessor
            ->shouldReceive('process')
            ->with(
                $collection
            )
            ->andReturnSelf();

        $this->collectionProcessor
            ->shouldReceive('process')
            ->with($searchCriteria, $collection)
            ->andReturnSelf();

        $searchResults = Mockery::mock(TemplateEntitySearchResultInterface::class);
        $this->searchResultFactory
            ->shouldReceive('create')
            ->andReturn($searchResults);

        $searchResults
            ->shouldReceive('setSearchCriteria')
            ->with($searchCriteria)
            ->andReturnSelf();

        $collection->shouldReceive('getItems')
            ->andReturn([1, 2, 3]);
        $collection->shouldReceive('getSize')
            ->andReturn(3);

        $searchResults
            ->shouldReceive('setItems')
            ->with([1, 2, 3])
            ->andReturnSelf();

        $searchResults
            ->shouldReceive('setTotalCount')
            ->with(3)
            ->andReturnSelf();

        $actualResult = $this->templateEntityRepository->getList($searchCriteria);
        $this->assertEquals($searchResults, $actualResult);
    }
}
