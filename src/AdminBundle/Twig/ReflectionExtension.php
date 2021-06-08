<?php

namespace AdminBundle\Twig;

use InvalidArgumentException;
use ReflectionClass;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class ReflectionExtension
 *
 * @package AdminBundle\Twig
 */
class ReflectionExtension extends Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('classConstant', [$this, 'getConstant']),
        ];
    }

    /**
     * Get constant.
     *
     * @param string $class
     * @param string $property
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public function getConstant(string $class, string $property)
    {
        $ref = new reflectionClass($class);

        if ($ref->hasConstant($property)) {
            return $ref->getConstant($property);
        }

        throw new InvalidArgumentException(
            sprintf(
                'Invalid constant for class %s and constant %s', $class,
                $property
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'reflection';
    }
}