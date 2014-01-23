<?php namespace Gstjohn\Turnstile\Tests;

use Gstjohn\Turnstile\Turnstile;
use Mockery as m;
use PHPUnit_Framework_TestCase;

class TurnstileTest extends PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        m::close();
    }

    public function testAllowWithString()
    {
        $permission = m::mock('Gstjohn\Turnstile\Permission\PermissionInterface');
        $permission->shouldReceive('setPermission')->once()->andReturn(true);

        $turnstile = new Turnstile($permission);

        $obj1 = m::mock('stdObj');
        $obj2 = m::mock('stdObj');
        $perms = 'read';

        $result = $turnstile->allow($obj1, $obj2, $perms);

        $this->assertTrue($result);
    }

    public function testAllowWithArray()
    {
        $permission = m::mock('Gstjohn\Turnstile\Permission\PermissionInterface');
        $permission->shouldReceive('setPermission')->times(2)->andReturn(true);

        $turnstile = new Turnstile($permission);

        $obj1 = m::mock('stdObj');
        $obj2 = m::mock('stdObj');
        $perms = ['read', 'write'];

        $result = $turnstile->allow($obj1, $obj2, $perms);

        $this->assertTrue($result);
    }

    public function testDisallowWithString()
    {
        $permission = m::mock('Gstjohn\Turnstile\Permission\PermissionInterface');
        $permission->shouldReceive('revokePermission')->once()->andReturn(true);

        $turnstile = new Turnstile($permission);

        $obj1 = m::mock('stdObj');
        $obj2 = m::mock('stdObj');
        $perms = 'read';

        $result = $turnstile->disallow($obj1, $obj2, $perms);

        $this->assertTrue($result);
    }

    public function testDisallowWithArray()
    {
        $permission = m::mock('Gstjohn\Turnstile\Permission\PermissionInterface');
        $permission->shouldReceive('revokePermission')->times(2)->andReturn(true);

        $turnstile = new Turnstile($permission);

        $obj1 = m::mock('stdObj');
        $obj2 = m::mock('stdObj');
        $perms = ['read', 'write'];

        $result = $turnstile->disallow($obj1, $obj2, $perms);

        $this->assertTrue($result);
    }

    public function testDisallowWithNull()
    {
        $permission = m::mock('Gstjohn\Turnstile\Permission\PermissionInterface');
        $permission->shouldReceive('revokePermission')->once()->andReturn(true);

        $turnstile = new Turnstile($permission);

        $obj1 = m::mock('stdObj');
        $obj2 = m::mock('stdObj');

        $result = $turnstile->disallow($obj1, $obj2);

        $this->assertTrue($result);
    }

    public function testCan()
    {
        $permission = m::mock('Gstjohn\Turnstile\Permission\PermissionInterface');
        $permission->shouldReceive('checkPermission')->once()->andReturn(true);

        $turnstile = new Turnstile($permission);

        $obj1 = m::mock('stdObj');
        $obj2 = m::mock('stdObj');
        $perms = 'read';

        $result = $turnstile->can($obj1, $obj2, $perms);

        $this->assertTrue($result);
    }

    public function testCannot()
    {
        $permission = m::mock('Gstjohn\Turnstile\Permission\PermissionInterface');
        $permission->shouldReceive('checkPermission')->once()->andReturn(false);

        $turnstile = new Turnstile($permission);

        $obj1 = m::mock('stdObj');
        $obj2 = m::mock('stdObj');
        $perms = 'read';

        $result = $turnstile->cannot($obj1, $obj2, $perms);

        $this->assertTrue($result);
    }

    public function testGetPermissions()
    {
        $data = $expected = ['read', 'write'];
        $permission = m::mock('Gstjohn\Turnstile\Permission\PermissionInterface');
        $permission->shouldReceive('getPermissions')->once()->andReturn($data);

        $turnstile = new Turnstile($permission);

        $obj1 = m::mock('stdObj');
        $obj2 = m::mock('stdObj');
        $perms = 'read';

        $result = $turnstile->getPermissions($obj1, $obj2, $perms);

        $this->assertEquals($expected, $result);
    }
}
