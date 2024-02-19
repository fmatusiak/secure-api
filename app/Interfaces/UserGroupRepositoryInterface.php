<?php

namespace App\Interfaces;

interface UserGroupRepositoryInterface
{
    public function assignUserIdsToGroupIds(array $userIds, array $groupIds);

    public function detachUsersIdsFromGroupIds(array $userIds, array $groupIds);
}
