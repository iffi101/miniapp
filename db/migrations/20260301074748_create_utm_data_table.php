<?php

use Phinx\Migration\AbstractMigration;

class CreateUtmDataTable extends AbstractMigration
{
    public function change()
    {
         $this->table('utm_data')
            ->addColumn('source', 'string', [
                'limit' => 255,
                'null' => false
            ])
            ->addColumn('medium', 'string', [
                'limit' => 255,
                'null' => false
            ])
            ->addColumn('campaign', 'string', [
                'limit' => 255,
                'null' => false
            ])
            ->addColumn('content', 'string', [
                'limit' => 255,
                'null' => true,
                'default' => null
            ])
            ->addColumn('term', 'string', [
                'limit' => 255,
                'null' => true,
                'default' => null
            ])
            ->addColumn('created', 'datetime', [
                'null' => false,
                'default' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('modified', 'datetime', [
                'null' => true,
                'default' => null
            ])
            ->addIndex(['source'])
            ->addIndex(['medium'])
            ->addIndex(['campaign'])
            ->create();
    }
}