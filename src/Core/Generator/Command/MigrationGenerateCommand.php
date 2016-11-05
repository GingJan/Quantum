<?php
namespace Zjien\Quantum\Generator\Command;

use Illuminate\Console\GeneratorCommand;

class MigrationGenerateCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'quantum:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create migration files.';

    /**
     * @var string
     */
    protected $type = 'Quantum Migration';

    protected $targetFile;

    protected $stubPath;

    protected $stub;

    public function fire()
    {
        $this->stubPath = __DIR__ . '/../Stubs';

        $this->generatePermissionsMigration();
        $this->generateRolesMigration();
        $this->generateRolesPermissionsMigration();
        $this->generateUsersRolesMigration();
    }

    protected function generateRolesMigration()
    {
        $this->targetFile = database_path('/migrations') . '/' . date('Y_m_d_His') . '_create_quantum_roles_tables.php';
        $this->type = 'Roles Migration';
        $this->stub = '/role-migration.stub';
        return parent::fire();
    }

    protected function generatePermissionsMigration()
    {
        $this->targetFile = database_path('/migrations') . '/' . date('Y_m_d_His') . '_create_quantum_permissions_tables.php';
        $this->type = 'Permissions Migration';
        $this->stub = '/permission-migration.stub';
        return parent::fire();
    }

    protected function generateRolesPermissionsMigration()
    {
        $this->targetFile = database_path('/migrations') . '/' . date('Y_m_d_His') . '_create_quantum_roles_permissions_tables.php';
        $this->type = 'Roles_Permissions Migration';
        $this->stub = '/role-permission-migration.stub';
        return parent::fire();
    }

    protected function generateUsersRolesMigration()
    {
        $this->targetFile = database_path('/migrations') . '/' . date('Y_m_d_His') . '_create_quantum_users_roles_tables.php';
        $this->type = 'Users_Roles Migration';
        $this->stub = '/user-role-migration.stub';
        return parent::fire();
    }

    /**
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->stub;
    }

    protected function getPath($name)
    {
        return $this->targetFile;
    }

}