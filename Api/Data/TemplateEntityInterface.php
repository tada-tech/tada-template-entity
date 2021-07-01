<?php
namespace Tada\TemplateEntity\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface TemplateEntityInterface extends ExtensibleDataInterface
{
    const TBL_NAME = 'template_entity';
    const ENTITY_ID = 'entity_id';
    const ATTRIBUTE_ONE = 'attribute_one';
    const ATTRIBUTE_TWO = 'attribute_two';
    const ATTRIBUTE_THREE = 'attribute_three';

    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param $value
     * @return $this
     */
    public function setEntityId($value);

    /**
     * @return string
     */
    public function getAttributeOne();

    /**
     * @param $value
     * @return $this
     */
    public function setAttributeOne($value);

    /**
     * @return float
     */
    public function getAttributeTwo();

    /**
     * @param $value
     * @return $this
     */
    public function setAttributeTwo($value);

    /**
     * @return int
     */
    public function getAttributeThree();

    /**
     * @param $value
     * @return $this
     */
    public function setAttributeThree($value);
}
