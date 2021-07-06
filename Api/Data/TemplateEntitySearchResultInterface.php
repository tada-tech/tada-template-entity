<?php
declare(strict_types=1);

namespace Tada\TemplateEntity\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface TemplateEntitySearchResultInterface extends SearchResultsInterface
{
    /**
     * Get TemplateEntity list
     *
     * @return TemplateEntityInterface[]
     */
    public function getItems();

    /**
     * Set TemplateEntity list
     *
     * @param TemplateEntityInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
