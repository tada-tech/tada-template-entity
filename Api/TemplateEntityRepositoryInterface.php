<?php
namespace Tada\TemplateEntity\Api;

use Tada\TemplateEntity\Api\Data\TemplateEntityInterface;

interface TemplateEntityRepositoryInterface
{
    /**
     * @param TemplateEntityInterface $object
     * @return TemplateEntityInterface
     */
    public function save(TemplateEntityInterface $object);

    /**
     * @param int $entityId
     * @return TemplateEntityInterface
     */
    public function get($entityId);

    /**
     * @return TemplateEntityInterface[]
     */
    public function getList();
}
