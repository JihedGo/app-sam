<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder; 
    }
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_Fr');    
        // $product = new Product();
        // $manager->persist($product);
        $admin = new User();
        $admin->setFirstName($faker->firstName);
        $admin->setLastName($faker->lastName);
        $admin->setTel($faker->phoneNumber);
        $admin->setRole('ROLE_ADMIN');
        $admin->setEmail('admin@health.tn');
        $admin->setPassword($this->encoder->encodePassword($admin, "secret#123"));
        $manager->persist($admin);
        $manager->flush();
    }
}
