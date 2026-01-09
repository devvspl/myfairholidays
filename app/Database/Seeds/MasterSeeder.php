<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterSeeder extends Seeder
{
    public function run()
    {
        // Run seeders in proper dependency order
        echo "Starting Master Seeder...\n";
        
        // Core system seeders
        $this->call('RoleSeeder');
        echo "- Roles created\n";
        
        $this->call('PermissionsSeeder');
        echo "- Permissions created\n";
        
        $this->call('DefaultRolePermissionsSeeder');
        echo "- Role permissions assigned\n";
        
        $this->call('UserSeeder');
        echo "- Users created\n";
        
        // Destination related seeders (foundation)
        $this->call('DestinationTypesSeeder');
        echo "- Destination types created\n";
        
        $this->call('DestinationsSeeder');
        echo "- Destinations created with proper categorization\n";
        
        // Travel CMS seeders (dependent on destinations)
        $this->call('HotelsSeeder');
        echo "- Hotels created and linked to destinations\n";
        
        $this->call('ItineraryCategoriesSeeder');
        echo "- Itinerary categories created\n";
        
        $this->call('ItinerariesSeeder');
        echo "- Itineraries created and linked to destinations & categories\n";
        
        // Content seeders
        $this->call('TestimonialCategoriesSeeder');
        echo "- Testimonial categories created\n";
        
        $this->call('TestimonialsSeeder');
        echo "- Testimonials created\n";
        
        $this->call('SamplePagesSeeder');
        echo "- Sample pages created\n";
        
        $this->call('ImageGallerySeeder');
        echo "- Image gallery populated\n";
        
        $this->call('VideoGallerySeeder');
        echo "- Video gallery populated\n";
        
        echo "\nMaster seeder completed successfully!\n";
        echo "Complete Travel CMS with interconnected modules:\n";
        echo "✓ Destination Types → Destinations → Hotels\n";
        echo "✓ Destination Types → Destinations → Itineraries\n";
        echo "✓ Itinerary Categories → Itineraries\n";
        echo "✓ All modules properly connected with foreign keys\n";
    }
}
