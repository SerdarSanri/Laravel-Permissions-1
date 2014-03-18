<?php namespace ConnorVG\Permissions;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MigrationCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'permissions:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a migration following the Permissions specifications.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $app = app();
        $app['view']->addNamespace('permissions',substr(__DIR__,0,-12).'views');
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $auth = lcfirst($this->option('auth'));
        $table = lcfirst($this->option('table'));
        $pivot = lcfirst($this->option('pivot'));

        $this->line('');
        $this->info( "Table name: $table" );
        $message = "A migration that creates the $table table will".
        " be created in app/database/migrations directory";

        $this->comment( $message );
        $this->line('');

        if ( $this->confirm("Proceed with the migration creation? [Yes|no]") )
        {
            $this->line('');

            $this->info( "Creating migration..." );
            if( $this->createMigration( $auth, $table, $pivot ) )
            {
                $this->info( "Migration successfully created!" );
            }
            else{
                $this->error( 
                    "Coudn't create migration.\n Check the write permissions".
                    " within the app/database/migrations directory."
                );
            }

            $this->line('');

        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        $app = app();

        return array(
            array('table', null, InputOption::VALUE_OPTIONAL, 'Table name.', $app['config']->get('permissions::permissions.table')),
            array('pivot', null, InputOption::VALUE_OPTIONAL, 'Pivot name.', $app['config']->get('permissions::permissions.pivot')),
            array('auth', null, InputOption::VALUE_OPTIONAL, 'Linked table (E.G: users).', $app['config']->get('auth.table')),
        );
    }

    /**
     * Create the migration
     *
     * @param  string $auth
     * @param  string $table
     * @param  string $pivot
     * @return bool
     */
    protected function createMigration( $auth, $table = 'permissions', $pivot = 'permissions_user' )
    {
        $app = app();
        $migration_file = $this->laravel->path."/database/migrations/".date('Y_m_d_His')."_permissions_setup_permissions_tables.php";
        $output = $app['view']->make('permissions::generators.permissions')->with([
            'auth' => $auth,
            'table' => $table,
            'pivot' => $pivot
        ])->render();

        if( ! file_exists( $migration_file ) )
        {
            $fs = fopen($migration_file, 'x');
            if ( $fs )
            {
                fwrite($fs, $output);
                fclose($fs);
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

}
