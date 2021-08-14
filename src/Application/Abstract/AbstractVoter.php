<?php
declare(strict_types=1);

namespace App\Application\Abstract;

use App\Database\Entity\User;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\Security;

abstract class AbstractVoter extends Voter
{
    protected string $permissionSpace = '';
    protected string|array $byPassRole = '';
    protected string $errorMessage = '';
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        if (!$this->security->getUser()) {
            throw new AuthenticationCredentialsNotFoundException();
        }

        if (!str_starts_with($attribute, $this->permissionSpace)) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var User $user */
        $user = $this->security->getUser();

        if ($this->isBypass($user) || $this->hasAccess($user, $attribute)) {
            return true;
        }

        throw new LogicException($this->errorMessage);
    }

    private function isBypass(User $user): bool
    {
        $byPass = is_array($this->byPassRole) ? $this->byPassRole : [$this->byPassRole];
        return in_array($user->getRole()->getName(), $byPass);
    }

    private function hasAccess(User $user, string $permission): bool
    {
        $permissions = $user->getRole()->getPermissionsNames();
        return $permissions->contains($permission) ||
            $permissions->contains("{$this->permissionSpace}.*");
    }
}