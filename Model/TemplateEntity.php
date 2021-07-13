<?php
declare(strict_types=1);

namespace Tada\TemplateEntity\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Tada\TemplateEntity\Api\Data\TemplateEntityInterface;
use Tada\TemplateEntity\Model\ResourceModel\TemplateEntity as ResourceModel;
use Tada\TemplateEntity\Api\Data\TemplateEntityExtensionInterface;

class TemplateEntity extends AbstractExtensibleModel implements TemplateEntityInterface
{
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'template_entity';

    /**
     * @inheridoc
     */
    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return int|mixed|null
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @param int $value
     * @return TemplateEntity|void
     */
    public function setEntityId($value)
    {
        $this->setData(self::ENTITY_ID, $value);
    }

    /**
     * @return string
     */
    public function getAttributeOne()
    {
        return $this->getData(self::ATTRIBUTE_ONE);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setAttributeOne(string $value)
    {
        $this->setData(self::ATTRIBUTE_ONE, $value);
    }

    /**
     * @return float
     */
    public function getAttributeTwo()
    {
        return $this->getData(self::ATTRIBUTE_TWO);
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setAttributeTwo(float $value)
    {
        $this->setData(self::ATTRIBUTE_TWO, $value);
    }

    /**
     * @return int
     */
    public function getAttributeThree()
    {
        return $this->getData(self::ATTRIBUTE_THREE);
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setAttributeThree(int $value)
    {
        $this->setData(self::ATTRIBUTE_THREE, $value);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Tada\TemplateEntity\Api\Data\TemplateEntityExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     *
     * @param \Tada\TemplateEntity\Api\Data\TemplateEntityExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(TemplateEntityExtensionInterface $extensionAttributes)
    {
        return $this->setExtensionAttributes($extensionAttributes);
    }
}
