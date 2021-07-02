<?php

namespace Tada\TemplateEntity\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Mockery;

use Tada\TemplateEntity\Api\Data\TemplateEntityInterface;
use Tada\TemplateEntity\Model\ResourceModel\TemplateEntity;
use Tada\TemplateEntity\Model\TemplateEntityFactory;
use Tada\TemplateEnity\Model\ResourceModel\TemplateEntity\CollectionFactory;
use Tada\TemplateEntity\Model\TemplateEntityRepository;

class TemplateEntityRepositoryTest extends TestCase
{
    protected $resourceModel;
    protected $modelFactory;
    protected $collectionFactory;

    protected $templateEntityRepository;
    protected $objectManager;

    protected function setUp()
    {
        $this->resourceModel = Mockery::mock(TemplateEntity::class);
        $this->modelFactory = Mockery::mock(TemplateEntityFactory::class);
        $this->collectionFactory = Mockery::mock(CollectionFactory::class);

        $this->objectManager = new ObjectManager($this);
        $this->templateEntityRepository = $this->objectManager->getObject(
            TemplateEntityRepository::class,
            [
                'resourceModel' => $this->resourceModel,
                'modelFactory' => $this->modelFactory,
                'collectionFactory' => $this->collectionFactory
            ]
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

        $actualResult = $this->templateEntityRepository->get($entityId);
        $this->assertEquals($model, $actualResult);
    }

    public function testGetList()
    {
        $collection = Mockery::mock(\Tada\TemplateEnity\Model\ResourceModel\TemplateEntity\Collection::class);
        $this->collectionFactory
            ->shouldReceive('create')
            ->andReturn($collection);
        $actualResults = $this->templateEntityRepository->getList();
        $this->assertEquals($collection, $actualResults);
    }
}
