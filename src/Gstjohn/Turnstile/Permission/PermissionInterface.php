<?php namespace Gstjohn\Turnstile\Permission;

interface PermissionInterface
{

    /**
     * Get permission between two resources
     * @param  object $fromResource The originating object
     * @param  object $toResource   The subject object
     * @param  string $perms        Permission value to check
     */
    public function getPermission($fromResource, $toResource, $perm);

    /**
     * Revoke permission between two resources
     * @param  object      $fromResource The object gaining set permission
     * @param  object      $toResource   The object on which set permission is added
     * @param  string|null $perms        Permission value to revoke. If null, all permissions are revoked.
     */
    public function revokePermission($fromResource, $toResource, $perm = null);

    /**
     * Set permission between two resources
     * @param  object       $fromResource The object gaining set permission
     * @param  object       $toResource   The object on which set permission is added
     * @param  string|array $perms        Permission value to set
     * @return bool         True if permission was set. Otherwise false.
     */
    public function setPermission($fromResource, $toResource, $perm);
}
