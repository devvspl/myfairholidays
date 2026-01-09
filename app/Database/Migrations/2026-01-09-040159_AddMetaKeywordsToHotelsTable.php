<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMetaKeywordsToHotelsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('hotels', [
            'meta_keywords' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'meta_description'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('hotels', 'meta_keywords');
    }
}