<?php
declare(strict_types=1);

namespace App\Http\Controller;

use App\Application\Service\UserService;
use App\Database\Entity\User;
use App\Http\Request\User\CreateUserRequest;
use App\Http\Request\User\UpdateUserRequest;
use App\Http\Request\User\UserRequest;
use App\Http\Response\UserResponse;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private UserService $service;
    private UserResponse $response;

    public function __construct(UserService $service, UserResponse $response)
    {
        $this->service = $service;
        $this->response = $response;
    }

    #[Route(path: '/users', name: 'app.user.index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $this->isGranted('user.view');
        $allUsers = $this->service->getAll();
        return $this->response
            ->data($allUsers)
            ->render();
    }

    #[Route(path: '/users', name: 'app.user.create', methods: ['POST'])]
    public function create(CreateUserRequest $request): JsonResponse
    {
        $this->isGranted('user.create');

        $user = $this->updateData($request);

        return $this->response
            ->data($user)
            ->render();
    }

    #[Route(path: '/users/{username}', name: 'app.user.show', methods: ['GET'])]
    public function show(User $user): JsonResponse
    {
        $this->isGranted('user.view');
        return $this->response
            ->data($user)
            ->render();
    }

    #[Route(path: '/users/{username}', name: 'app.user.update', methods: ['PUT'])]
    public function update(UpdateUserRequest $request): JsonResponse
    {
        $this->isGranted('user.update');

        $user = $this->updateData($request);

        return $this->response
            ->data($user)
            ->render();
    }

    #[Route(path: '/users/{username}', name: 'app.user.delete', methods: ['DELETE'])]
    public function delete(User $user): JsonResponse
    {
        $this->isGranted('user.delete');
        $this->service->delete($user);
        return $this->json("User {$user->getName()} was deleted.");
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    private function updateData(UserRequest $request): User
    {
        return $this->service->createOrUpdate(
            username: $request->username(),
            name: $request->name(),
            email: $request->email(),
            password: $request->password(),
            role: $request->role(),
            media: $request->media()
        );
    }
}