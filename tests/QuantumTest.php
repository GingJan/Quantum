<?php

class QuantumTest extends PHPUnit_Framework_TestCase
{
    protected $app;

    public function setUp()
    {
        $this->app = Mockery::namedMock('Illuminate\Foundation\Application', 'app');
    }


    public function testCheck()
    {

        $permForTrue = Mockery::namedMock('Zjien\Quantum\Models\Permission', 'perm');
        $permForTrue->name = 'create-admin';
        $permForTrue->display_name = 'Create-admin';
        $permForTrue->verb = 'POST';
        $permForTrue->uri = '/admins';
        $permForTrue->status = 1;

        $permForStaffRole = Mockery::namedMock('Zjien\Quantum\Models\Permission', 'perm');
        $permForStaffRole->name = 'create-job';
        $permForStaffRole->display_name = 'Create-job';
        $permForStaffRole->verb = 'PUT';
        $permForStaffRole->uri = '/jobs/{id}';
        $permForStaffRole->status = 1;

        $permForException = Mockery::namedMock('Zjien\Quantum\Models\Permission', 'perm');
        $permForException->name = 'create-staff';
        $permForException->display_name = 'Create-staff';
        $permForException->verb = 'POST';
        $permForException->uri = '/staffs';
        $permForException->status = 0;

        $role1 = Mockery::mock('role');
        $role1->name = 'admins';
        $role1->display_name = 'Admins';
        $role1->permissions = [$permForTrue, $permForException];

        $role2 = Mockery::mock('role');
        $role2->name = 'staff';
        $role2->display_name = 'Staff';
        $role2->permissions = [$permForStaffRole];

        $quantum = Mockery::mock('Zjien\Quantum\Quantum[user]', [$this->app]);
        $user = Mockery::mock('user');

        $quantum->shouldReceive('user')
            ->andReturn($user)
            ->times(5);
        $quantum->shouldReceive('user')
            ->andReturn(false)
            ->once();

        $user->roles = [$role1, $role2];

        $this->assertTrue($quantum->check('/admins', 'POST'));
        $this->assertTrue($quantum->check('/jobs/{id}', 'PUT'));
        $this->assertFalse($quantum->check('/jobs/{id}', 'POST'));
        $this->assertFalse($quantum->check('/corporations', 'POST'));

        try {
            $quantum->check('/staffs', 'POST');
            $this->fail('fail in Exception');
        } catch (Exception $e) {
            $this->assertInstanceOf('Symfony\Component\HttpKernel\Exception\NotFoundHttpException', $e);
        }

        try {
            $this->assertFalse($quantum->check('/whatever', 'POST'));
        } catch (Exception $e) {
            $this->assertInstanceOf('Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException', $e);
        }

    }

    public function testUser()
    {
        $app = $this->app;

        $app->auth = Mockery::mock('auth');
        $user = Mockery::mock('user');
        $app->auth->shouldReceive('user')
            ->andReturn($user)
            ->once();
        $quantum = new \Zjien\Quantum\Quantum($app);

        $this->assertSame($user, $quantum->user());
    }

    public function tearDown()
    {
        Mockery::close();
    }
}

class perm
{
    const STATUS_CLOSING = 0;
    const STATUS_OPENING = 1;
}
