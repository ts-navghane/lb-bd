<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass="App\Model\Repository\VariantRepository")
 * @ORM\Table(
 *     name="variant",
 *     uniqueConstraints={
 *          @UniqueConstraint(
 *              name="unique_variant",
 *              columns={"color", "size"}
 *          )
 *      }
 * )
 */
class Variant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(name="uuid")
     */
    private string $uuid;

    /**
     * @ORM\Column(name="color", type="string", length=255)
     */
    private string $color;

    /**
     * @ORM\Column(name="size", type="string", length=255)
     */
    private string $size;

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }
}
