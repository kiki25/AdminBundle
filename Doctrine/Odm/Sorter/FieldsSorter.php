<?php

/*
 * This file is part of the AdminBundle package.
 *
 * (c) Muhammad Surya Ihsanuddin <surya.kejawen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfonian\Indonesia\AdminBundle\Doctrine\Odm\Sorter;

use Symfonian\Indonesia\AdminBundle\Contract\SorterInterface;
use Symfonian\Indonesia\AdminBundle\Manager\Driver;
use Symfonian\Indonesia\AdminBundle\Manager\ManagerFactory;

/**
 * @author Muhammad Surya Ihsanuddin <surya.kejawen@gmail.com>
 */
class FieldsSorter implements SorterInterface
{
    const DRIVER = Driver::DOCTRINE_ODM;

    /**
     * @var ManagerFactory
     */
    private $managerFactory;

    public function __construct(ManagerFactory $managerFactory)
    {
        $this->managerFactory = $managerFactory;
    }

    /**
     * @param string                                                         $entityClass
     * @param \Doctrine\ORM\QueryBuilder|\Doctrine\ODM\MongoDB\Query\Builder $queryBuilder
     * @param string                                                         $sortBy
     */
    public function sort($entityClass, $queryBuilder, $sortBy)
    {
        $classMetadata = $this->getClassMetadata($entityClass);
        $metadata = $classMetadata->getFieldMapping($sortBy);
        $queryBuilder->sort(array(
            $metadata['fieldName'] => 'asc',
        ));
    }

    /**
     * @param $entityClass
     *
     * @return \Doctrine\ODM\MongoDB\Mapping\ClassMetadata|\Doctrine\ORM\Mapping\ClassMetadata
     */
    private function getClassMetadata($entityClass)
    {
        return $this->managerFactory->getManager(self::DRIVER)->getClassMetadata($entityClass);
    }
}
