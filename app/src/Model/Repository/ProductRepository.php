<?php

declare(strict_types=1);

namespace App\Model\Repository;

use App\Model\Entity\Product;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    public function save(Product $product): Product
    {
        $dateTime = new DateTime();

        if (!$product->getCreatedAt() instanceof DateTimeImmutable) {
            $product->setCreatedAt(DateTimeImmutable::createFromMutable($dateTime));
        }

        $product->setUpdatedAt($dateTime);
        $this->_em->persist($product);
        $this->_em->flush();

        return $product;
    }
}
