<?php
declare(strict_types=1);

namespace App\Database\Fixture;

use App\Database\Entity\Permission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PermissionFixture extends Fixture
{

    private array $types = ['*', 'create', 'update', 'delete', 'view'];
    private array $namespaces = ['user', 'post', 'post_type'];

    public function load(ObjectManager $manager)
    {
        foreach ($this->namespaces as $namespace) {
            foreach ($this->types as $type) {
                $permission = new Permission();
                $permission->setName("{$namespace}.{$type}");
                $manager->persist($permission);
            }
        }

        $manager->flush();
    }
}