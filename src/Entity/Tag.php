<?php

namespace App\Entity;

use App\Slug\SlugGenerator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Tag
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column()
     */
    private $name;

    /**
     * @ORM\Column()
     */
    private $slug;

    /**
     * Tag constructor.
     * @param $name
     * @param $slug
     */
    public function __construct($name, $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    // Uniquement des getter et un constructeur
}
