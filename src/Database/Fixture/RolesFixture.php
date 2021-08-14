<?php
declare(strict_types=1);

namespace App\Database\Fixture;

use App\Database\Entity\Role;
use App\Database\Repository\PermissionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ObjectManager;

class RolesFixture extends Fixture
{

    private array $roles = [
        'superAdministrator' => [
            'fullName' => 'ROLE_SUPER_ADMIN',
        ],
        'administrator' => [
            'fullName' => 'ROLE_ADMIN',
            'permission' => ['user.*', 'post.*', 'post_type.*']
        ],
        'editor' => [
            'fullName' => 'ROLE_EDITOR',
            'permission' => ['post.*', 'post_type.*']
        ],
        'user' => [
            'fullName' => 'ROLE_USER',
            'permission' => ['post.view', 'post_type.view']
        ]
    ];
    private PermissionRepository $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->roles as $name => $data) {
            $role = new Role();
            $role->setName($name)
                ->setFullName($data['fullName']);

            if (isset($data['permission'])) {
                foreach ($data['permission'] as $permission) {
                    $permission = $this->permissionRepository->findByName($permission);
                    $role->addPermission($permission);
                }
            }

            $manager->persist($role);
        }

        $manager->flush();
    }
}