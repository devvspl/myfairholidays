<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddBannerImageSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // Add banner_image column to terms_of_service table
        $sql = "ALTER TABLE terms_of_service ADD COLUMN IF NOT EXISTS banner_image VARCHAR(255) NULL AFTER content";
        $db->query($sql);
        
        // Add banner_image column to privacy_policy table
        $sql = "ALTER TABLE privacy_policy ADD COLUMN IF NOT EXISTS banner_image VARCHAR(255) NULL AFTER content";
        $db->query($sql);
        
        // Set default banner image
        $defaultBanner = 'main/images/contactus.png';
        
        $db->table('terms_of_service')->update(['banner_image' => $defaultBanner]);
        $db->table('privacy_policy')->update(['banner_image' => $defaultBanner]);
        
        echo "Banner image column added successfully!\n";
    }
}
