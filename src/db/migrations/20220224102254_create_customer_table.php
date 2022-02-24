<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCustomerTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('customers');
            $table->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
