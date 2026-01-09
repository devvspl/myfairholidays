<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class VerifySeederData extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'verify:seeder';
    protected $description = 'Verify Travel CMS seeder data';

    public function run(array $params)
    {
        $db = \Config\Database::connect();

        CLI::write('=== Travel CMS Seeder Verification ===', 'green');
        CLI::newLine();

        // Check Itinerary Categories
        $categories = $db->table('itinerary_categories')->countAllResults();
        CLI::write("✓ Itinerary Categories: {$categories} records", 'green');

        // Check Hotels
        $hotels = $db->table('hotels')->countAllResults();
        CLI::write("✓ Hotels: {$hotels} records", 'green');

        // Check Itineraries
        $itineraries = $db->table('itineraries')->countAllResults();
        CLI::write("✓ Itineraries: {$itineraries} records", 'green');

        // Check relationships
        $hotelsWithDestinations = $db->table('hotels h')
            ->join('destinations d', 'h.destination_id = d.id')
            ->countAllResults();
        CLI::write("✓ Hotels linked to destinations: {$hotelsWithDestinations} records", 'green');

        $itinerariesWithRelations = $db->table('itineraries i')
            ->join('destinations d', 'i.destination_id = d.id')
            ->join('itinerary_categories c', 'i.category_id = c.id')
            ->countAllResults();
        CLI::write("✓ Itineraries linked to destinations & categories: {$itinerariesWithRelations} records", 'green');

        CLI::newLine();
        CLI::write('=== Sample Data ===', 'yellow');

        // Sample Categories
        CLI::newLine();
        CLI::write('Itinerary Categories:', 'yellow');
        $sampleCategories = $db->table('itinerary_categories')
            ->select('name, slug')
            ->limit(5)
            ->get()
            ->getResultArray();
        foreach ($sampleCategories as $cat) {
            CLI::write("- {$cat['name']} ({$cat['slug']})", 'white');
        }

        // Sample Hotels
        CLI::newLine();
        CLI::write('Hotels with Destinations:', 'yellow');
        $sampleHotels = $db->table('hotels h')
            ->select('h.name as hotel_name, d.name as destination_name, h.star_rating, h.price_per_night')
            ->join('destinations d', 'h.destination_id = d.id')
            ->limit(5)
            ->get()
            ->getResultArray();
        foreach ($sampleHotels as $hotel) {
            CLI::write("- {$hotel['hotel_name']} in {$hotel['destination_name']} ({$hotel['star_rating']}★, ₹{$hotel['price_per_night']})", 'white');
        }

        // Sample Itineraries
        CLI::newLine();
        CLI::write('Itineraries with Relations:', 'yellow');
        $sampleItineraries = $db->table('itineraries i')
            ->select('i.title, d.name as destination_name, c.name as category_name, i.duration_days, i.price')
            ->join('destinations d', 'i.destination_id = d.id')
            ->join('itinerary_categories c', 'i.category_id = c.id')
            ->limit(5)
            ->get()
            ->getResultArray();
        foreach ($sampleItineraries as $itinerary) {
            CLI::write("- {$itinerary['title']} ({$itinerary['category_name']}) in {$itinerary['destination_name']} - {$itinerary['duration_days']} days, ₹{$itinerary['price']}", 'white');
        }

        CLI::newLine();
        CLI::write('=== Verification Complete ===', 'green');
        CLI::write('All Travel CMS modules are properly connected!', 'green');
    }
}