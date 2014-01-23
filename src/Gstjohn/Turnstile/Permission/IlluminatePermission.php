<?php namespace Gstjohn\Turnstile\Permission;

use Gstjohn\Turnstile\Permission\PermissionInterface;
use DB;

class IlluminatePermission implements PermissionInterface
{

    /**
     * Get permission between two resources
     * @param  object $fromResource The originating object
     * @param  object $toResource   The subject object
     * @param  string $perms        Permission value to check
     * @return array  Array containing: ['object_type', 'object_id', 'permission']
     */
    public function getPermission($fromResource, $toResource, $perm)
    {
        // Force to string
        $perm = (string)$perm;

        $result = DB::table('permissions')
            ->where('source_type', get_class($fromResource))
            ->where('source_id', $fromResource->id)
            ->where('object_type', get_class($toResource))
            ->where('object_id', $toResource->id)
            ->where('permission_type', $perm)
            ->first();

        if (count($result) > 0) {
            return [
                'objectType' => $result->object_type,
                'objectId'   => $result->object_id,
                'permission' => $result->permission_type
            ];
        }

        return [];
    }

    /**
     * Get all permissions for an object that meet criteria
     * @param  object $fromResource The originating object
     * @param  object $toResource   (optional) The subject object. If provided, list will only include permissions between the two objects.
     * @return array  Array of permissions, each containing: ['object_type', 'object_id', 'permission']
     */
    public function getPermissions($fromResource, $toResource = null)
    {
        $permissions = DB::table('permissions')
            ->where('source_type', get_class($fromResource))
            ->where('source_id', $fromResource->id);

        if (!is_null($toResource)) {
            $permissions->where('object_type', get_class($toResource))
                       ->where('object_id', $toResource->id);
        }

        $data = [];
        foreach ($permissions->get() as $result) {
            $data[] = [
                'objectType' => $result->object_type,
                'objectId'   => $result->object_id,
                'permission' => $result->permission_type
            ];
        }

        return $data;
    }

    /**
     * Revoke permission between two resources
     * @param  object      $fromResource The object gaining set permission
     * @param  object      $toResource   The object on which set permission is added
     * @param  string|null $perms        Permission value to revoke. If null, all permissions are revoked.
     */
    public function revokePermission($fromResource, $toResource, $perm = null)
    {
        $qy = DB::table('permissions')
            ->where('source_type', get_class($this))
            ->where('source_id', $this->id)
            ->where('object_type', get_class($resource))
            ->where('object_id', $resource->id);

        if (!is_null($perm)) {
            // Force to string
            $perm = (string)$perm;

            $qy->where('permission_type', $perm);
        }

        $qy->delete();
    }

    /**
     * Set permission between two resources
     * @param  object $fromResource The object gaining set permission
     * @param  object $toResource   The object on which set permission is added
     * @param  string $perms        Permission value to set
     * @return bool   True if permission was set. Otherwise false.
     */
    public function setPermission($fromResource, $toResource, $perm)
    {
        // Force to string
        $perm = (string)$perm;

        // Check for existing set permission
        $permission = $this->getPermission($fromResource, $toResource, $perm);

        if ($permission) {
            return true;
        }

        // Create permission
        DB::table('permissions')
            ->insert([
                'source_type'     => get_class($fromResource),
                'source_id'       => $fromResource->id,
                'object_type'     => get_class($toResource),
                'object_id'       => $toResource->id,
                'permission_type' => $perm
            ]);

        return true;
    }
}
