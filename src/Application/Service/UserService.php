<?php
declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Exception\UserExistsException;
use App\Database\Entity\User;
use App\Database\Repository\MediaRepository;
use App\Database\Repository\RoleRepository;
use App\Database\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private UserRepository $repository;
    private UserPasswordHasherInterface $passwordHasher;
    private RoleRepository $roleRepository;
    private MediaRepository $mediaRepository;

    public function __construct(UserRepository $repository, RoleRepository $roleRepository, MediaRepository $mediaRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->repository = $repository;
        $this->passwordHasher = $passwordHasher;
        $this->roleRepository = $roleRepository;
        $this->mediaRepository = $mediaRepository;
    }

    public function getAll(): ArrayCollection
    {
        return new ArrayCollection($this->repository->findAll());
    }

    public function getByUsername(string|null $username): User|null
    {
        return $this->repository->findOneBy(['username' => $username]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function createOrUpdate(string|null $username, string|null $name, string|null $email, string|null $password, int|null $role, int|null $media): User
    {
        if ($this->usersExists($email)) {
            throw new UserExistsException($email);
        }

        $role = $this->roleRepository->findOneBy(['id' => $role]);
        $media = $this->mediaRepository->findOneBy(['id' => $media]);

        $user = $this->repository->findOrCreate($username);
        $password = $password ? $this->passwordHasher->hashPassword($user, $password) : null;
        $user->setUsername($username)
            ->setName($name)
            ->setEmail($email)
            ->setPassword($password)
            ->setRole($role)
            ->setMedia($media);

        $this->repository->save($user);

        return $user;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function delete(User $user): void
    {
        $this->repository->delete($user);
    }

    private function usersExists(string|null $email): bool
    {
        $user = $this->repository->findOneBy(['email' => $email]);
        return !!$user;
    }
}