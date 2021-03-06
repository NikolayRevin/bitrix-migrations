<?php

namespace Arrilot\BitrixMigrations\Commands;

use Arrilot\BitrixMigrations\Interfaces\DatabaseStorageInterface;

class InstallCommand extends AbstractCommand
{
    /**
     * Interface that gives us access to the database.
     *
     * @var DatabaseStorageInterface
     */
    protected $database;

    /**
     * Table in DB to store migrations that have been already run.
     *
     * @var string
     */
    protected $table;

    /**
     * Constructor.
     *
     * @param string                   $table
     * @param DatabaseStorageInterface $database
     */
    public function __construct($table, DatabaseStorageInterface $database)
    {
        $this->table = $table;
        $this->database = $database;

        parent::__construct();
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('install')->setDescription('Create the migration database table');
    }

    /**
     * Execute the console command.
     *
     * @return null|int
     */
    protected function fire()
    {
        if ($this->database->checkMigrationTableExistence()) {
            $this->abort("Table \"{$this->table}\" already exists");
        }

        $this->database->createMigrationTable();

        $this->info('Migration table has been successfully created!');
    }
}
