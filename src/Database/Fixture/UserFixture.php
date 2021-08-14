<?php
declare(strict_types=1);

namespace App\Database\Fixture;

use App\Database\Entity\User;
use App\Database\Repository\RoleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    private RoleRepository $roleRepository;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(RoleRepository $roleRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->roleRepository = $roleRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $roles = $this->roleRepository->findAll();
        $faker = Factory::create();
        for ($i = 0; $i < 9; $i++) {
            $user = new User();
            $role = array_rand($roles);
            $user->setEmail($faker->email)
                ->setUsername($faker->userName)
                ->setName($faker->name)
                ->setRole($roles[$role]);

            $user->setPassword($this->passwordHasher->hashPassword(
                user: $user,
                plainPassword: $faker->password
            ));

            $manager->persist($user);
        }

        $manager->flush();
    }
}