<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SeedDestinations extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'seed:destinations';
    protected $description = 'Seeds destination types and destinations data';

    public function run(array $params)
    {
        CLI::write('Starting destination seeding...', 'yellow');
        
        try {
            // Clear existing data
            $db = \Config\Database::connect();
            
            CLI::write('Clearing existing destinations...', 'yellow');
            $db->table('destinations')->truncate();
            
            CLI::write('Clearing existing destination types...', 'yellow');
            $db->table('destination_types')->truncate();
            
            // Run seeders
            CLI::write('Seeding destination types...', 'yellow');
            $seeder = \Config\Services::seeder();
            $seeder->call('DestinationTypesSeeder');
            
            CLI::write('Seeding destinations...', 'yellow');
            $seeder->call('DestinationsSeeder');
            
            CLI::write('Destination seeding completed successfully!', 'green');
            CLI::write('- 6 destination types created', 'green');
            CLI::write('- 24 destinations created', 'green');
            
        } catch (\Exception $e) {
            CLI::write('Error during seeding: ' . $e->getMessage(), 'red');
            return EXIT_ERROR;
        }
        
        return EXIT_SUCCESS;
    }
}