<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTransactionTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('transactions');
        $table->addColumn('account_id', 'integer', ['null' => false])
            ->addColumn('amount', 'biginteger', ['signed' => false, 'null' => false])
            ->addColumn('created_at', 'datetime', ['timestamp' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', ['timestamp' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('account_id', 'accounts', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
            ->create();
    }
}
