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

    protected function generatePermissionsMigration()
    {
        $this->targetFile = database_path('/migrations') . '/' . date('Y_m_d_His') . '_create_quantum_permissions_table.php';
        $this->type = 'Permissions Migration';
        $this->stub = $this->stubPath .'/permission-migration.stub';
        return parent::fire();
    }

    protected function generateRolesMigration()
    {
        $this->targetFile = database_path('/migrations') . '/' . date('Y_m_d_His') . '_create_quantum_roles_table.php';
        $this->type = 'Roles Migration';
        $this->stub = $this->stubPath . '/role-migration.stub';
        return parent::fire();
    }

    protected function generateRolesPermissionsMigration()
    {
        $this->targetFile = database_path('/migrations') . '/' . date('Y_m_d_His') . '_create_quantum_roles_permissions_table.php';
        $this->type = 'Roles_Permissions Migration';
        $this->stub = $this->stubPath .'/role-permission-migration.stub';
        return parent::fire();
    }

    protected function generateUsersRolesMigration()
    {
        $this->targetFile = database_path('/migrations') . '/' . date('Y_m_d_His') . '_create_quantum_users_roles_table.php';
        $this->type = 'Users_Roles Migration';
        $this->stub = $this->stubPath .'/user-role-migration.stub';
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

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return '';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

}