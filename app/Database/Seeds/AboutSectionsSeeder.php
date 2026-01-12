<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AboutSectionsSeeder extends Seeder
{
    public function run()
    {
        // First, create the table if it doesn't exist
        $forge = \Config\Database::forge();
        
        if (!$this->db->tableExists('about_sections')) {
            $forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'section_type' => [
                    'type' => 'ENUM',
                    'constraint' => ['hero', 'mission', 'stats', 'features'],
                    'default' => 'hero',
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
                'image_path' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'background_image' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'icon' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true,
                ],
                'stat_value' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true,
                ],
                'stat_label' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
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
            $forge->createTable('about_sections');
        }

        // Clear existing data
        $this->db->table('about_sections')->truncate();

        // Insert default data
        $data = [
            [
                'section_type' => 'hero',
                'title' => 'About Us',
                'subtitle' => null,
                'content' => null,
                'image_path' => null,
                'background_image' => 'assets/images/home-img/bg.webp',
                'icon' => null,
                'stat_value' => null,
                'stat_label' => null,
                'sort_order' => 1,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section_type' => 'mission',
                'title' => 'Who We\'re & Mission?',
                'subtitle' => null,
                'content' => 'My Fair Holidays is one of the leading e-travel services company based in New Delhi. My Fair Holidays has excelled in providing travel related services to domestic & Inbound tourists and corporate. Travel businesses such as hotels, tour operators and other industry giants find our travel portal "myfairholidays.com "an important medium to promote their offerings. We operate in multiple domains in assisting companies arrange MICE and leisure related trips, organizing vacations for Indian customers traveling within the country and overseas and also the inbound guests, traveling to India.',
                'image_path' => 'assets/images/side-3.webp',
                'background_image' => null,
                'icon' => null,
                'stat_value' => null,
                'stat_label' => null,
                'sort_order' => 2,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section_type' => 'stats',
                'title' => 'Overall Booking',
                'subtitle' => null,
                'content' => null,
                'image_path' => null,
                'background_image' => null,
                'icon' => null,
                'stat_value' => '32K',
                'stat_label' => 'Overall<br>Booking',
                'sort_order' => 1,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section_type' => 'stats',
                'title' => 'Years Successfully',
                'subtitle' => null,
                'content' => null,
                'image_path' => null,
                'background_image' => null,
                'icon' => null,
                'stat_value' => '25+',
                'stat_label' => 'Years<br>Successfully',
                'sort_order' => 2,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section_type' => 'stats',
                'title' => 'Happy Users',
                'subtitle' => null,
                'content' => null,
                'image_path' => null,
                'background_image' => null,
                'icon' => null,
                'stat_value' => '45K',
                'stat_label' => 'Happy<br>Users',
                'sort_order' => 3,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section_type' => 'stats',
                'title' => 'Countries We Work',
                'subtitle' => null,
                'content' => null,
                'image_path' => null,
                'background_image' => null,
                'icon' => null,
                'stat_value' => '22',
                'stat_label' => 'Countries<br>We Work',
                'sort_order' => 4,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section_type' => 'features',
                'title' => 'What We Do – Your Choice',
                'subtitle' => null,
                'content' => 'From accommodation bookings and private transfers to multi-centre trips and customized itineraries, we tailor every journey to your needs.',
                'image_path' => null,
                'background_image' => null,
                'icon' => '🧭',
                'stat_value' => null,
                'stat_label' => null,
                'sort_order' => 1,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section_type' => 'features',
                'title' => 'Wide Accommodation Choices',
                'subtitle' => null,
                'content' => 'We offer a broad range of hotels and resorts across India — from budget-friendly stays to premium 5-star luxury options.',
                'image_path' => null,
                'background_image' => null,
                'icon' => '🏨',
                'stat_value' => null,
                'stat_label' => null,
                'sort_order' => 2,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'section_type' => 'features',
                'title' => 'End-to-End Holiday Planning',
                'subtitle' => null,
                'content' => 'Leisure trips, LTC holidays, and special tours are backed by our strong partnerships with leading airlines and hotel chains for the best deals.',
                'image_path' => null,
                'background_image' => null,
                'icon' => '✈️',
                'stat_value' => null,
                'stat_label' => null,
                'sort_order' => 3,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('about_sections')->insertBatch($data);
    }
}