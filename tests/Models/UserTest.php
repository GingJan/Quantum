<?php
use Illuminate\Support\Facades\Config;
class UserTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        //prepare mock object for the test first.
        $app = Mockery::mock('app')->shouldReceive('instance')->getMock();
        $config = Mockery::mock('config');
        Config::setFacadeApplication($app);
        Config::swap($config);

    }
    public function tearDown()
    {
        Mockery::close();
    }
    public function testRoles()
    {
        Config::shouldReceive('get')
            ->with('quantum.model.role')
            ->andReturn('RoleModel')
            ->once();
        Config::shouldReceive('get')
            ->with('quantum.database.tables.user_role_relation')
            ->andReturn('user_role_table')
            ->once();

        $belongsToMany = Mockery::mock('belongsToMany');

        $userModel = Mockery::mock('Zjien\Quantum\Models\User[belongsToMany]');
        $userModel->shouldReceive('belongsToMany')
            ->with('RoleModel', 'user_role_table', 'user_id', 'role_id')
            ->andReturn($belongsToMany)
            ->once();

        $this->assertSame($belongsToMany, $userModel->roles());
    }

    public function testAttachRole()
    {

    }
}