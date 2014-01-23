<?php namespace Gstjohn\Turnstile\Permission;

interface PermissionInterface
{

    /**
     * Get permission between two resources
     * @param  object $fromResource The originating object
     * @param  object $toResource   The subject object
     * @param  string $perms        Permission value to check
     * @return array  Array containing: ['object_type', 'object_id', 'permission']
     */
    public function getPermission($fromResource, $toResource, $perm);

    /**
     * Get all permissions for an object that meet criteria
     * @param  object $fromResource The originating object
     * @param  object $toResource   (optional) The subject object. If provided, list will only include permissions between the two objects.
     * @return array  Array of permissions, each containing: ['object_type', 'object_id', 'permission']
     */
    public function getPermissions($fromResource, $toResource = null);

    /**
     * Revoke permission between two resources
     * @param  object      $fromResource The object gaining set permission
     * @param  object      $toResource   The object on which set permission is added
     * @param  string|null $perms        Permission value to revoke. If null, all permissions are revoked.
     */
    public function revokePermission($fromResource, $toResource, $perm = null);

    /**
     * Set permission between two resources
     * @param  object $fromResource The object gaining set permission
     * @param  object $toResource   The object on which set permission is added
     * @param  string $perms        Permission value to set
     * @return bool   True if permission was set. Otherwise false.
     */
    public function setPermission($fromResource, $toResource, $perm);
}
