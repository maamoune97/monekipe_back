<?php

namespace App\State\MediaObject;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

use App\Entity\MediaObject\MediaObject;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final readonly class SaveMediaObject implements ProcessorInterface
{
    public function __construct(
        #[Autowire('@api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $processor
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $uploadedFile = $context['request']->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $mediaObject = new MediaObject();
        $mediaObject->setFile($uploadedFile)
            ->setMimeType($uploadedFile->getMimeType())
            ->setSize($uploadedFile->getSize())
            ->setName($uploadedFile->getClientOriginalName());
        return $this->processor->process($mediaObject, $operation, $uriVariables, $context);
    }
}