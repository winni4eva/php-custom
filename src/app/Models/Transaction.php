<?php
namespace Winnipass\Wfx\App\Models;

use Exception;

class Transaction extends AbstractModel {

    public string $tableName = 'transactions';

    public function getTransactions() {}

    public function createTransaction(int $customerId, array $data) 
    {
        try {
            //$custumerId must be owner of debit account
            $connection = $this->connect();
            $connection->beginTransaction();
            $debitAccountId = $data['debit_account'];

            $query = <<<EOT
            SELECT * FROM customers c 
            LEFT JOIN accounts a ON c.id = a.customer_id
            WHERE c.id = :customerId AND a.id = :debitAccountId
            EOT;
            $statement = $connection->prepare($query);
            $statement->execute(['customerId' => $customerId, 'debitAccountId' => $debitAccountId]);
            
            $transferAccountFromAccount = $statement->fetch($connection::FETCH_ASSOC);
            if (! $transferAccountFromAccount) {
                throw new Exception(
                    "The customer with id {$customerId} does not own account {$debitAccountId}", 
                    400
                );
            }
            
            //debit $amount must be equal or greater than what is in debit account
            $debitAmount = $data['amount']*100;
            $amountInAccount = $transferAccountFromAccount['amount']/100;
            if ($amountInAccount < $debitAmount) {
                throw new Exception(
                    "The account {$debitAccountId} does not have sufficient funds for this transaction", 
                    400
                );
            }
            
            //find customer id of credit account
            $creditAccountId = $data['credit_account'];
            $query = "SELECT * FROM accounts a WHERE a.id = :creditAccount";
            $statement = $connection->prepare($query);
            $statement->execute(['creditAccount' => $creditAccountId]);
            $accountToCredit = $statement->fetch($connection::FETCH_ASSOC);
    
            if (! $accountToCredit) {
                throw new Exception(
                    "The account {$creditAccountId} does not exist", 
                    400
                );
            }
            
            // deduct amount from debit account
            $amountToDebit = $amountInAccount - $debitAmount;
            $query = "UPDATE accounts SET amount = :amountToDebit WHERE id = :debitAccountId";
            $statement = $connection->prepare($query);
            $statement->execute(['amountToDebit' => $amountToDebit, 'debitAccountId' => $debitAccountId]);
            
            //Log debit transaction
            $query = "INSERT INTO {$this->tableName} (account_id, amount) VALUES(:debitAccountId, :amount)";
            $statement = $connection->prepare($query);
            $statement->execute(['amount' => $amountToDebit, 'debitAccountId' => $debitAccountId]);

            // add add to credit account
            $amountToCredit = $accountToCredit['amount'] + $debitAmount;
            $query = "UPDATE accounts SET amount = :amountToCredit WHERE id = :creditAccountId";
            $statement = $connection->prepare($query);
            $statement->execute(['amountToCredit' => $amountToCredit, 'creditAccountId' => $creditAccountId]);
            
            //Log credit transaction
            $query = "INSERT INTO {$this->tableName} (account_id, amount) VALUES(:creditAccountId, :amount)";
            $statement = $connection->prepare($query);
            $statement->execute(['amount' => $amountToCredit, 'creditAccountId' => $creditAccountId]);

            $connection->commit();

            return true;
            
        } catch (\Throwable $th) {
            throw $th;
            $connection->rollBack();
        }
    }
}