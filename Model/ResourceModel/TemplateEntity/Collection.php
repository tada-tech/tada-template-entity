<?php
declare(strict_types=1);

namespace Tada\TemplateEntity\Model\ResourceModel\TemplateEntity;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Tada\TemplateEntity\Model\ResourceModel\TemplateEntity as ResourceModel;
use Tada\TemplateEntity\Model\TemplateEntity as Model;

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
