<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Membre;
use App\Entity\Option;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    /**
     *  @var Generator
     */
    private Generator $faker;

    public function __construct()   
    {
        $this->faker = Factory::create('fr__FR');
    }

    public function load(ObjectManager $manager): void
    {
        
        $competence = ["competence 1","competence 2","competence 3" ];
        $site = ["www.google.come","www.google.come","www.google.come" ];
        
        for($i = 0; $i < 50; $i++){

            
            $membre = new Membre();
            $option = new Option();
            
            // Definition du membre
            $membre
                ->setNom($this->faker->word())
                ->setPrenom($this->faker->word())
                ->setEmail($this->faker->email())
                ->setPassword($this->faker->password())
                ->setMarque($this->faker->word())
                ->setImage('dummyImg.png')
                ->setTelephone( $this->faker->phoneNumber())
                ->setPoste($this->faker->words(4, true))
                ->setDescription($this->faker->words(20, true))
                ->setCompetence($competence)
            ;

            // Definition des options
            $option
                ->setAffnommarque($this->faker->numberBetween(0,2))
                ->setMailnommarque($this->faker->numberBetween(0,2))
                ->setMailtelephone($this->faker->boolean())
                ->setMembre($membre);
            
            $manager->persist($option);

            $manager->persist($membre);
        }

            $manager->flush();
    }
}
