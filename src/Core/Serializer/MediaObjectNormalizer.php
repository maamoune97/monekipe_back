<?php

namespace App\Core\Serializer;

use App\Core\Entity\MediaObject\MediaObject;
use ArrayObject;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Vich\UploaderBundle\Storage\StorageInterface;

class MediaObjectNormalizer implements NormalizerInterface
{

    private const string ALREADY_CALLED = 'MEDIA_OBJECT_NORMALIZER_ALREADY_CALLED';

    public function __construct(
        #[Autowire(service: 'api_platform.jsonld.normalizer.item')]
        private readonly NormalizerInterface $normalizer,
        private readonly StorageInterface $storage
    ) {
    }

    /**
     * @param MediaObject $data
     * @param string|null $format
     * @param array $context
     * @return array|string|int|float|bool|ArrayObject|null
     * @throws ExceptionInterface
     */
    public function normalize(mixed $data, ?string $format = null, array $context = []): array|string|int|float|bool|ArrayObject|null
    {
        $context[self::ALREADY_CALLED] = true;

        $data->setContentUrl($this->storage->resolveUri($data, 'file'));

        return $this->normalizer->normalize($data, $format, $context);
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {

        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof MediaObject;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            MediaObject::class => true,
        ];
    }
}