<?php
declare(strict_types=1);

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

    /**
     * @param TemplateEntityInterface $object
     * @return boolean
     */
    public function delete(TemplateEntityInterface $object);
}
