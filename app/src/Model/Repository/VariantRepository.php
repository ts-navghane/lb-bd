<?php

declare(strict_types=1);

namespace App\Model\Repository;

use App\Model\Entity\Variant;
use Doctrine\ORM\EntityRepository;

class VariantRepository extends EntityRepository
{
    public function save(Variant $variant): Variant
    {
        $this->_em->persist($variant);
        $this->_em->flush();

        return $variant;
    }
}
