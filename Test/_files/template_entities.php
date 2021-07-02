<?php
use Magento\TestFramework\Helper\Bootstrap;


$objectManager = Bootstrap::getObjectManager();

$templateEntityFactory = $objectManager->get(\Tada\TemplateEntity\Api\Data\TemplateEntityInterfaceFactory::class);
$templateEntityRepository = $objectManager->get(\Tada\TemplateEntity\Api\TemplateEntityRepositoryInterface::class);

$data = [
    'attribute_one' => "Nghia Dang",
    'attribute_two' => 10,
    'attribute_three' => 23.5
];

$entity = $templateEntityFactory->create(['data' => $data]);
$templateEntityRepository->save($entity);

