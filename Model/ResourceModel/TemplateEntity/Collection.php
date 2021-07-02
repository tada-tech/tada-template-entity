<?php

namespace Tada\TemplateEnity\Model\ResourceModel\TemplateEntity;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Tada\TemplateEntity\Model\ResourceModel\TemplateEntity as ResourceModel;
use Tada\TemplateEntity\Model\TemplateEntity as Model;


/**
 * Class Collection
 * @package Central\LineItem\Model\ResourceModel\OrderLineItem
 * @codeCoverageIgnore
 */
class Collection extends AbstractCollection
{
    /**
     *  Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            Model::class,
            ResourceModel::class
        );
    }
}
