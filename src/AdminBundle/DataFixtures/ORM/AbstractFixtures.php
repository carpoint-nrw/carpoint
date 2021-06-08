<?php

namespace AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture as BaseFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class AbstractFixtures
 *
 * @package AdminBundle\DataFixtures\ORM
 */
abstract class AbstractFixtures extends BaseFixture implements OrderedFixtureInterface
{
    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}