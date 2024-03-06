<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Category;
use App\Entity\Distributeur;
use App\Entity\Instruction;
use App\Entity\Pattern;
use App\Entity\Produit;
use App\Entity\Reference;
use App\Entity\Yarn;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $patterns = [];
        $categories =[];
        $instructions =[];
        $yarns =[];


        for ($i=0; $i <30 ; $i++) { 
            $instruction = new Instruction();
            $instruction->setDescription($faker->text(10000));
            $instructions[] = $instruction;
            $manager->persist($instruction);
        }
        for ($i=0; $i < 30; $i++) { 
            $categorie = new Category();
            $categorie->setName($faker->word);
            $categories[] = $categorie;
            $manager->persist($categorie);
        }

        for ($i=0; $i < 30; $i++) { 
            $yarn = new Yarn();
            $yarn->setName($faker->word);
            $yarn->setPrice($faker->randomFloat(2,1,20));
            $yarn->setColor($faker->colorName());
            $yarn->setWeight($faker->word);
            $yarn->setFiber($faker->word);


            $yarns[] = $yarn;
            $manager->persist($yarn);
        }

        for ($p=0; $p < 30; $p++) { 
            $pattern = new Pattern();
            $pattern->setName($faker->word);
            $pattern->setDescription($faker->text(200));
            $pattern->setImage('https://picsum.photos/200');
            $pattern->setSlug($pattern->getName());
            $pattern->setYardage($faker->randomNumber(3, false));
            $pattern->setPrice($faker->randomFloat(2,1,10));
            for ($c=0; $c <count($categories); $c ++) { 
                $pattern->setCategories($faker->randomElement($categories));
            }
            for ($i =0; $i <count($instructions); $i++) { 
                $pattern->setInstructions($instructions[$p]);
            }
            for ($y =0; $y  <count($yarns); $y++) { 
                $pattern->addYarn($faker->randomElement($yarns));
            }

            $patterns[] = $pattern;
            $manager->persist($pattern);
        }


        $manager->flush();
    }
}
