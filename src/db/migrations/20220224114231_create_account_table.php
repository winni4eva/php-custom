<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateAccountTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('accounts');
        $table->addColumn('customer_id', 'integer', ['null' => false])
            ->addColumn('amount', 'biginteger', ['signed' => false, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('customer_id', 'customers', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
            ->create();
    }
}
