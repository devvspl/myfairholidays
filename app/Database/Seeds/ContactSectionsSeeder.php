<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ContactSectionsSeeder extends Seeder
{
    public function run()
    {
        // First, create the table if it doesn't exist
        $forge = \Config\Database::forge();
        
        if (!$this->db->tableExists('contact_sections')) {
            $forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'section_type' => [
                    'type' => 'ENUM',
                    'constraint' => ['hero', 'contact_info', 'form_settings'],
                    'default' => 'contact_info',
                ],
                'title' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ],
                'subtitle' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'content' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'icon' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'contact_type' => [
                    'type' => 'ENUM',
                    'constraint' => ['email', 'phone', 'address', 'website', 'social'],
                    'null' => true,
                ],
                'contact_value' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'contact_link' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'background_image' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'map_embed_code' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'sort_order' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'default' => 0,
                ],
                'status' => [
                    'type' => 'ENUM',
                    'constraint' => ['active', 'inactive'],
                    'default' => 'active',
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);

            $forge->addKey('id', true);
            $forge->addKey('section_type');
            $forge->addKey('status');
            $forge->addKey('sort_order');
            $forge->createTable('contact_sections');
        }

        // Clear existing data
        $this->db->table('contact_sections')->truncate();

        // Insert default data
        $data = [
            // Hero Section
            [
                'section_type' => 'hero',
                'title' => 'Get-in Touch',
                'subtitle' => null,
                'content' => null,
                'icon' => null,
                'contact_type' => null,
                'contact_value' => null,
                'contact_link' => null,
                'background_image' => 'main/images/contactus.png',
                'map_embed_code' => null,
                'sort_order' => 1,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Contact Info Cards
            [
                'section_type' => 'contact_info',
                'title' => 'Drop a Mail',
                'subtitle' => null,
                'content' => null,
                'icon' => 'fa-solid fa-briefcase',
                'contact_type' => 'email',
                'contact_value' => 'info@myfairholidays.com',
                'contact_link' => 'mailto:info@myfairholidays.com',
                'background_image' => null,
                'map_embed_code' => null,
                'sort_order' => 1,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section_type' => 'contact_info',
                'title' => 'Website',
                'subtitle' => null,
                'content' => null,
                'icon' => 'fa-solid fa-globe',
                'contact_type' => 'website',
                'contact_value' => 'www.myfairholidays.com',
                'contact_link' => 'https://www.myfairholidays.com',
                'background_image' => null,
                'map_embed_code' => null,
                'sort_order' => 2,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section_type' => 'contact_info',
                'title' => 'Call Us',
                'subtitle' => null,
                'content' => '+91-9971124567<br>+91-9582560106',
                'icon' => 'fa-solid fa-headset',
                'contact_type' => 'phone',
                'contact_value' => '+91-9971124567',
                'contact_link' => 'tel:+919971124567',
                'background_image' => null,
                'map_embed_code' => null,
                'sort_order' => 3,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section_type' => 'contact_info',
                'title' => 'Head Office',
                'subtitle' => null,
                'content' => 'Office No O-445, (4th Floor)Gaur City Center, Greater Noida Uttar Pradesh 201307',
                'icon' => 'fa-solid fa-location-dot',
                'contact_type' => 'address',
                'contact_value' => 'Office No O-445, (4th Floor)Gaur City Center, Greater Noida Uttar Pradesh 201307',
                'contact_link' => null,
                'background_image' => null,
                'map_embed_code' => null,
                'sort_order' => 4,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section_type' => 'contact_info',
                'title' => 'Branch Office',
                'subtitle' => null,
                'content' => 'Broadway Shivpora,B.B.Cant Srinagar Airport Distance. 6km,Dal Lake Distance. 3km Pincode : 190004',
                'icon' => 'fa-solid fa-location-dot',
                'contact_type' => 'address',
                'contact_value' => 'Broadway Shivpora,B.B.Cant Srinagar Airport Distance. 6km,Dal Lake Distance. 3km Pincode : 190004',
                'contact_link' => null,
                'background_image' => null,
                'map_embed_code' => null,
                'sort_order' => 5,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Form Settings
            [
                'section_type' => 'form_settings',
                'title' => 'Drop Us a Line',
                'subtitle' => 'Get in touch via form below and we will reply as soon as we can.',
                'content' => null,
                'icon' => null,
                'contact_type' => null,
                'contact_value' => null,
                'contact_link' => null,
                'background_image' => null,
                'map_embed_code' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.823934128228!2d77.42434187409307!3d28.60505828533036!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce15bb128924b%3A0xdb0ad8999d11a006!2sMy%20Fair%20Holidays%20-%20Best%20Travel%20Agency%20in%20Greater%20Noida%20%7C%20Top%20Travel%20Company%20for%20Domestic%20%26%20International%20Packages!5e0!3m2!1sen!2sin!4v1767627511358!5m2!1sen!2sin',
                'sort_order' => 1,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('contact_sections')->insertBatch($data);
    }
}