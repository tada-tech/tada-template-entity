<?php
declare(strict_types=1);

namespace Tada\TemplateEntity\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Tada\TemplateEntity\Api\Data\TemplateEntityInterface;
use Tada\TemplateEntity\Api\TemplateEntityRepositoryInterface;

class TemplateEntityRepository implements TemplateEntityRepositoryInterface
{
    private $resourceModel;
    private $modelFactory;
    private $collectionFactory;

    public function __construct(
        \Tada\TemplateEntity\Model\ResourceModel\TemplateEntity $resourceModel,
        \Tada\TemplateEntity\Model\TemplateEntityFactory $modelFactory,
        \Tada\TemplateEntity\Model\ResourceModel\TemplateEntity\CollectionFactory $collectionFactory
    ) {
        $this->resourceModel = $resourceModel;
        $this->modelFactory = $modelFactory;
        $this->collectionFactory = $collectionFactory;
    }

    public function save(TemplateEntityInterface $object)
    {
        try {
            $this->resourceModel->save($object);
        } catch (\Exception $e) {
            if ($object->getEntityId()) {
                throw new CouldNotSaveException(
                    __(
                        'Unable to save $object with ID %1. Error: %2',
                        [$object->getEntityId(), $e->getMessage()]
                    )
                );
            }

            throw new CouldNotSaveException(
                __('Unable to save new $object. Error: %1', $e->getMessage())
            );
        }
        return $object;
    }

    public function get($entityId)
    {
        $model = $this->modelFactory->create();
        $this->resourceModel->load($model, $entityId);
        return $model;
    }

    /**
     * @return TemplateEntityInterface[]
     */
    public function getList()
    {
        $collection = $this->collectionFactory->create();
        return $collection;
    }

    public function delete(TemplateEntityInterface $object)
    {
        return $this->deleteById($object->getEntityId());
    }

    protected function deleteById($id)
    {
        $model = $this->modelFactory->create();
        $this->resourceModel->load($model, $id);
        $this->resourceModel->delete($model);
        return true;
    }
}
