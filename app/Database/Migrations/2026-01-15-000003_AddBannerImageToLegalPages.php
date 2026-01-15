<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBannerImageToLegalPages extends Migration
{
    public function up()
    {
        // Add banner_image column to terms_of_service table
        $fields = [
            'banner_image' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'content'
            ]
        ];
        $this->forge->addColumn('terms_of_service', $fields);

        // Add banner_image column to privacy_policy table
        $this->forge->addColumn('privacy_policy', $fields);

        // Set default banner image
        $defaultBanner = 'main/images/contactus.png';
        
        $this->db->table('terms_of_service')->update(['banner_image' => $defaultBanner]);
        $this->db->table('privacy_policy')->update(['banner_image' => $defaultBanner]);
    }

    public function down()
    {
        // Remove banner_image column from terms_of_service table
        $this->forge->dropColumn('terms_of_service', 'banner_image');
        
        // Remove banner_image column from privacy_policy table
        $this->forge->dropColumn('privacy_policy', 'banner_image');
    }
}
