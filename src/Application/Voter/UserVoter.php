<?php
declare(strict_types=1);

namespace App\Application\Voter;

use App\Application\Abstract\AbstractVoter;

class UserVoter extends AbstractVoter
{
    protected string $permissionSpace = 'user';
    protected string|array $byPassRole = 'superAdministrator';
    protected string $errorMessage = "Sorry, but you don't have privileges to make this action";
}