<?php
declare(strict_types=1);

namespace Tada\TemplateEntity\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Tada\TemplateEntity\Api\Data\TemplateEntityInterface;
use Tada\TemplateEntity\Api\TemplateEntityRepositoryInterface;
use Tada\TemplateEntity\Api\Data\TemplateEntitySearchResultInterface;
use Tada\TemplateEntity\Model\ResourceModel\TemplateEntity\Collection;

class TemplateEntityRepository implements TemplateEntityRepositoryInterface
{
    /**
     * @var \Tada\TemplateEntity\Model\TemplateEntity[]
     */
    private $registry = [];

    /**
     * @var ResourceModel\TemplateEntity
     */
    private $resourceModel;

    /**
     * @var TemplateEntityFactory
     */
    private $modelFactory;

    /**
     * @var ResourceModel\TemplateEntity\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var \Tada\TemplateEntity\Api\Data\TemplateEntitySearchResultInterfaceFactory
     */
    protected $searchResultFactory;

    /**
     * TemplateEntityRepository constructor.
     * @param ResourceModel\TemplateEntity $resourceModel
     * @param TemplateEntityFactory $modelFactory
     * @param ResourceModel\TemplateEntity\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     * @param \Tada\TemplateEntity\Api\Data\TemplateEntitySearchResultInterfaceFactory $searchResultInterfaceFactory
     */
    public function __construct(
        \Tada\TemplateEntity\Model\ResourceModel\TemplateEntity $resourceModel,
        \Tada\TemplateEntity\Model\TemplateEntityFactory $modelFactory,
        \Tada\TemplateEntity\Model\ResourceModel\TemplateEntity\CollectionFactory $collectionFactory,
        \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor,
        \Tada\TemplateEntity\Api\Data\TemplateEntitySearchResultInterfaceFactory $searchResultInterfaceFactory
    ) {
        $this->resourceModel = $resourceModel;
        $this->modelFactory = $modelFactory;
        $this->collectionFactory = $collectionFactory;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultFactory = $searchResultInterfaceFactory;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return TemplateEntitySearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $this->extensionAttributesJoinProcessor->process(
            $collection
        );
        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var TemplateEntitySearchResultInterface $searchResults */
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @param TemplateEntityInterface $object
     * @return TemplateEntityInterface
     * @throws CouldNotSaveException
     */
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

    /**
     * @param int $entityId
     * @param bool $forceReload
     * @return TemplateEntityInterface|TemplateEntity
     * @throws NoSuchEntityException
     */
    public function get(int $entityId, bool $forceReload = true)
    {
        if (isset($this->registry[$entityId]) && !$forceReload) {
            return $this->registry[$entityId];
        }

        $model = $this->modelFactory->create();
        $this->resourceModel->load($model, $entityId);

        if (!$model->getEntityId()) {
            throw NoSuchEntityException::singleField('entityId', $entityId);
        }

        $this->registry[$entityId] = $model;

        return $model;
    }

    /**
     * @param TemplateEntityInterface $object
     * @return TemplateEntityInterface
     * @throws \Exception
     */
    public function delete(TemplateEntityInterface $object): TemplateEntityInterface
    {
        $entityId = $object->getEntityId();
        unset($this->registry[$entityId]);
        $this->resourceModel->delete($object);
        return $object;
    }
}
