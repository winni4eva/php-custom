<?php
namespace Winnipass\Wfx\App\Models;

use Exception;
use PDO;
use Winnipass\Wfx\App\Helpers\Helper;

class Transaction extends AbstractModel {

    public string $tableName = 'transactions';

    public function getTransactions() {}

    public function createTransaction(int $customerId, array $data) 
    {
        try {
            
            $connection = $this->connect();
            $connection->beginTransaction();
            $debitAccountId = $data['debit_account'];

            /** 
             * Confirm that the customer owns the account
             * 
             */
            $transferFromAccount = $this->confirmDebitAccount($connection, $customerId, $debitAccountId);
            if (! $transferFromAccount) {
                throw new Exception(
                    "The customer with id {$customerId} does not own account {$debitAccountId}", 
                    400
                );
            }
            
            /** 
             * Confirm that the account sending money has enough funds
             * 
             */ 
            $debitAmount = $data['amount'] * Helper::AMOUNT_CONVERSION_VALUE;
            $amountInAccount = $transferFromAccount['amount'];
            if ($amountInAccount < $debitAmount) {
                throw new Exception(
                    "The account {$debitAccountId} does not have sufficient funds for this transaction", 
                    400
                );
            }
            
            /**
             * Confirm account receiving money exists
             * 
             */ 
            $creditAccountId = $data['credit_account'];
            $accountToCredit = $this->confirmCreditAccount($connection, $creditAccountId);
            if (! $accountToCredit) {
                throw new Exception(
                    "The account {$creditAccountId} does not exist", 
                    400
                );
            }
            
            /** 
             * Deduct amount from sending account and log transaction
             * 
             */ 
            $this->debitSendingAccount($connection, $amountInAccount, $debitAmount, $debitAccountId);

            /** 
             * Add amount from receiving account and log transaction
             * 
             */
            $this->creditReceivingAccount($connection, $accountToCredit, $debitAmount, $creditAccountId);

            $connection->commit();

            return true;

        } catch (\Throwable $th) {
            throw $th;
            $connection->rollBack();
        }
    }

    private function creditReceivingAccount(PDO $connection, $accountToCredit, $debitAmount, $creditAccountId) 
    {
        $amountToCredit = $accountToCredit['amount'] + $debitAmount;
        $query = "UPDATE accounts SET amount = :amountToCredit WHERE id = :creditAccountId";
        $statement = $connection->prepare($query);
        $statement->execute(['amountToCredit' => $amountToCredit, 'creditAccountId' => $creditAccountId]);
        
        $query = "INSERT INTO {$this->tableName} (account_id, amount) VALUES(:creditAccountId, :amount)";
        $statement = $connection->prepare($query);
        $statement->execute(['amount' => $amountToCredit, 'creditAccountId' => $creditAccountId]);
    }

    private function debitSendingAccount(PDO $connection, $amountInAccount, $debitAmount, $debitAccountId)
    {
        $amountToDebit = $amountInAccount - $debitAmount;
        $query = "UPDATE accounts SET amount = :amountToDebit WHERE id = :debitAccountId";
        $statement = $connection->prepare($query);
        $statement->execute(['amountToDebit' => $amountToDebit, 'debitAccountId' => $debitAccountId]);
        
        $query = "INSERT INTO {$this->tableName} (account_id, amount) VALUES(:debitAccountId, :amount)";
        $statement = $connection->prepare($query);
        $statement->execute(['amount' => $amountToDebit, 'debitAccountId' => $debitAccountId]);
    }

    private function confirmCreditAccount(PDO $connection, $creditAccountId)
    {
        $query = "SELECT * FROM accounts a WHERE a.id = :creditAccount";
        $statement = $connection->prepare($query);
        $statement->execute(['creditAccount' => $creditAccountId]);

        return $statement->fetch($connection::FETCH_ASSOC);
    }

    private function confirmDebitAccount(PDO $connection, int $customerId, int $debitAccountId)
    {
        $query = <<<EOT
        SELECT * FROM customers c 
        LEFT JOIN accounts a ON c.id = a.customer_id
        WHERE c.id = :customerId AND a.id = :debitAccountId
        EOT;
        $statement = $connection->prepare($query);
        $statement->execute(['customerId' => $customerId, 'debitAccountId' => $debitAccountId]);
        
        return $statement->fetch($connection::FETCH_ASSOC);
    }
}