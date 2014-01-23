<?php namespace Gstjohn\Turnstile;

use Gstjohn\Turnstile\Permission\PermissionInterface;

class Turnstile
{

    /**
     * Permission object
     * @var Gstjohn\Turnstile\Permission\PermissionInterface
     */
    protected $permissions;

    /**
     * Constructor
     */
    public function __construct(PermissionInterface $permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * Set permission on the between two resources
     * @param  object       $fromResource The object gaining set permission
     * @param  object       $toResource   The object on which set permission is added
     * @param  string|array $perms        Permission value to set
     * @return bool         True if permission was set. Otherwise false.
     */
    public function allow($fromResource, $toResource, $perms)
    {
        if (is_string($perms)) {
            $perms = (array)$perms;
        }

        $success = true;
        foreach ($perms as $perm) {
            $success = $success && $this->permissions->setPermission($fromResource, $toResource, $perm);
        }

        return $success;
    }

    /**
     * Revoke permission between two resources
     * @param  object      $fromResource The object gaining set permission
     * @param  object      $toResource   The object on which set permission is added
     * @param  string|null $perms        Permission value to revoke. If null, all permissions are revoked.
     * @return bool         True if permission was revoked. Otherwise false.
     */
    public function disallow($fromResource, $toResource, $perms = null)
    {
        if (is_string($perms)) {
            $perms = (array)$perms;
        } elseif (is_null($perms)) {
            $perms = array(null);
        }

        $success = true;
        foreach ($perms as $perm) {
            $success = $success && $this->permissions->revokePermission($fromResource, $toResource, $perms);
        }

        return $success;
    }

    /**
     * Check for specified permission between two resources
     * @param  object $fromResource The object on which to check permission from
     * @param  object $toResource   The object on which to check permission to
     * @param  string $perm         The permission to check
     * @return bool   True if permission set. Otherwise false.
     */
    public function can($fromResource, $toResource, $perm)
    {
        return (bool)count($this->permissions->getPermission($fromResource, $toResource, $perm));
    }

    /**
     * Check for lack of specified permission between two resources
     * @param  object $fromResource The object on which to check permission from
     * @param  object $toResource   The object on which to check permission to
     * @param  string $perm         The permission to check
     * @return bool   True if permission not set. Otherwise false.
     */
    public function cannot($fromResource, $toResource, $perm)
    {
        return !$this->can($fromResource, $toResource, $perm);
    }

    /**
     * Get permissions set for this object
     * @param object $fromResource The object on which to retrieve permissions from
     * @param object $toResource   The object on which to retrieve permissions to (optional)
     * @param string $toResource   The permission to retrieve (optional)
     */
    public function getPermissions($fromResource, $toResource = null, $perm = null)
    {
        return $this->permissions->getPermissions($fromResource, $toResource, $perm);
    }
}
