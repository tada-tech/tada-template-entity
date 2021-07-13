<?php
declare(strict_types=1);

namespace Tada\TemplateEntity\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Tada\TemplateEntity\Api\Data\TemplateEntityInterface;
use Tada\TemplateEntity\Api\Data\TemplateEntitySearchResultInterface;
use Tada\TemplateEntity\Model\TemplateEntity;

interface TemplateEntityRepositoryInterface
{
    /**
     * @param TemplateEntityInterface $object
     * @return TemplateEntityInterface
     */
    public function save(TemplateEntityInterface $object);

    /**
     * @param int $entityId
     * @param bool $forceReload
     * @return TemplateEntityInterface|TemplateEntity
     * @throws NoSuchEntityException
     */
    public function get(int $entityId, bool $forceReload = true);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return TemplateEntitySearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param TemplateEntityInterface $object
     * @return TemplateEntityInterface
     * @throws \Exception
     */
    public function delete(TemplateEntityInterface $object): TemplateEntityInterface;
}
