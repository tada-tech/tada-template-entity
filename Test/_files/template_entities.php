<?php
declare(strict_types=1);

use Magento\TestFramework\Helper\Bootstrap;

$objectManager = Bootstrap::getObjectManager();

/**
 * @var \Tada\TemplateEntity\Api\Data\TemplateEntityInterfaceFactory $templateEntityFactory
 */
$templateEntityFactory = $objectManager->get(\Tada\TemplateEntity\Api\Data\TemplateEntityInterfaceFactory::class);

/** @var \Tada\TemplateEntity\Api\TemplateEntityRepositoryInterface $templateEntityRepository */
$templateEntityRepository = $objectManager->get(\Tada\TemplateEntity\Api\TemplateEntityRepositoryInterface::class);

$data = [
    'attribute_one' => "Attribute Number One",
    'attribute_two' => 10,
    'attribute_three' => 23.53
];

/** @var \Tada\TemplateEntity\Api\Data\TemplateEntityInterface $entity */
$entity = $templateEntityFactory->create();
$entity->setData($data);
$newEntity = $templateEntityRepository->save($entity);
