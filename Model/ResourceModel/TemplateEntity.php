<?php
declare(strict_types=1);

namespace Tada\TemplateEntity\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Tada\TemplateEntity\Api\Data\TemplateEntityInterface;

class TemplateEntity extends AbstractDb
{
    /**
     * @inheridoc
     */
    protected function _construct()
    {
        $this->_init(
            TemplateEntityInterface::TBL_NAME,
            TemplateEntityInterface::ENTITY_ID
        );
    }
}
