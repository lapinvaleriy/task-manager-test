<?php

namespace App\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class EntitySerializer
{
    /**
     * @var Serializer
     */
    private Serializer $serializer;

    public function __construct()
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    protected function serialize($object)
    {
        return $this->serializer->serialize($object, 'json');
    }
}