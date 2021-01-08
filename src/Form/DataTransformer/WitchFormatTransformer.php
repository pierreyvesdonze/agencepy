<?php

namespace App\Form\DataTransformer;

use App\Entity\WitchFormat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class WitchFormatTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    

    /**
     * Transforms an object (WitchFormat) to a string (number).
     *
     * @param  WitchFormat|null $witchFormat
     */
    public function transform($witchFormat): string
    {
        if (null === $witchFormat) {
            return '';
        }

        return $witchFormat->getId();
    }

    /**
     * Transforms a string (number) to an object (witchFormat).
     *
     * @param  string $issueNumber
     * @throws TransformationFailedException if object (witchFormat) is not found.
     */
    public function reverseTransform($issueNumber): ?WitchFormat
    {
        // no issue number? It's optional, so that's ok
        if (!$issueNumber) {
            return null;
        }

        $witchFormat = $this->entityManager
            ->getRepository(WitchFormat::class)
            // query for the issue with this id
            ->find($issueNumber)
        ;

        if (null === $witchFormat) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An witchFormat with number "%s" does not exist!',
                $issueNumber
            ));
        }

        return $witchFormat;
    }
}