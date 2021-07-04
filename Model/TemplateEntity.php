<?php
declare(strict_types=1);

namespace Tada\TemplateEntity\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Tada\TemplateEntity\Api\Data\TemplateEntityInterface;
use Tada\TemplateEntity\Model\ResourceModel\TemplateEntity as ResourceModel;

class TemplateEntity extends AbstractExtensibleModel implements TemplateEntityInterface
{

    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    public function setEntityId($value)
    {
        $this->setData(self::ENTITY_ID, $value);
    }

    public function getAttributeOne()
    {
        return $this->getData(self::ATTRIBUTE_ONE);
    }

    public function setAttributeOne($value)
    {
        $this->setData(self::ATTRIBUTE_ONE, $value);
    }

    public function getAttributeTwo()
    {
        return $this->getData(self::ATTRIBUTE_TWO);
    }

    public function setAttributeTwo($value)
    {
        $this->setData(self::ATTRIBUTE_TWO, $value);
    }

    public function getAttributeThree()
    {
        return $this->getData(self::ATTRIBUTE_THREE);
    }


    public function setAttributeThree($value)
    {
        $this->setData(self::ATTRIBUTE_THREE, $value);
    }

    public function getExtensionAttributes()
    {
        return parent::_getExtensionAttributes();
    }

    public function setExtensionAttributes(\Magento\Framework\Api\ExtensionAttributesInterface $extensionAttributes)
    {
        return parent::_setExtensionAttributes($extensionAttributes);
    }
}
