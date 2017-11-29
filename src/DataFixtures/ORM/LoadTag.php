<?php
/**
 * Created by PhpStorm.
 * User: samuel.bigard
 * Date: 29/11/17
 * Time: 10:11
 */

namespace App\DataFixtures\ORM;


use App\Entity\Tag;
use App\Slug\SlugGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTag extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $slugGenerator = $this->container->get(SlugGenerator::class);
        $tags = [
            new Tag("Sport", $slugGenerator->generate("Sport")),
            new Tag("Food", $slugGenerator->generate("Food")),
            new Tag("Politique", $slugGenerator->generate("Politique")),
        ];

        foreach ($tags as $tag){
            $manager->persist($tag);
        }
        $manager->flush();
    }

}