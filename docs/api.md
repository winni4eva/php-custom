# BANK API DOCS

## Create Customer

Creates a customer.

**URL** : `/api/customers`

**Method** : `POST`

Provide name of customer to be created.

**Data example** All fields must be sent.

```json
{
    "name": "Floyd Morrison"
}
```

### Success Response

**Code** : `201 CREATED`

**Content**

```json
{
    "success": "Customer created successfully"
}
```

### Error Responses

**Code** : `400 BAD REQUEST`

**Content** : 
```json
{
    "error": "Error creating customer"
}
```

## Get Customers

Gets a single customer or gets all customers.

**URL** : `/api/customers/{id}`

**Method** : `GET`

Provide a customer id to get a single customer or leave out to get all customers.

**Data example**

`@param id integer NOT REQUIRED`

### Success Response

**Code** : `200 OK`

**Content**

```json
{
    "data": {
        "id": "25",
        "name": "Neo More",
        "created_at": "2022-02-26 11:07:37",
        "updated_at": "2022-02-26 11:07:37"
    }
}
```
OR

```json
{
    "data": [
        {
            "id": "1",
            "name": "Arisha Barron",
            "created_at": "2022-02-24 12:48:05",
            "updated_at": "2022-02-24 12:48:05"
        },
        {
            "id": "2",
            "name": "Branden Gibson",
            "created_at": "2022-02-24 12:48:05",
            "updated_at": "2022-02-24 12:48:05"
        }
    ]
}
```

### Error Responses

**Code** : `400 BAD REQUEST`

**Content** : 
```json
{
    "error": "Error fetching customer data"
}
```

## Create Account

Creates a single or multiple account(s) for a customer.

**URL** : `/api/accounts/{customerId}`

**Method** : `POST`

Provide name of customer to be created.

**Data example** All fields must be sent.

`@param customerId integer REQUIRED`

```json
[
    {
        "amount": 5000.50
    },
    {
        "amount": 1800.99
    }
]
```

### Success Response

**Code** : `201 CREATED`

**Content**

```json
{
    "success": "Account created successfully"
}
```

### Error Responses

**Code** : `400 BAD REQUEST`

**Content** : 
```json
{
    "error": "Error creating account"
}
```

## Get Account

Gets a single account or gets all accounts.

**URL** : `/api/customers/{id}`

**Method** : `GET`

Provide an account id to get a single account or leave out to get all accounts.

**Data example**

`@param id integer NOT REQUIRED`

### Success Response

**Code** : `200 OK`

**Content**

```json
{
    "data": {
        "id": "10",
        "customer_id": "2",
        "amount": 500.5,
        "created_at": "2022-02-24 23:35:10",
        "updated_at": "2022-02-24 23:35:10"
    }
}
```
OR

```json
{
    "data": [
        {
            "id": "8",
            "customer_id": "1",
            "amount": 100,
            "created_at": "2022-02-24 23:15:50",
            "updated_at": "2022-02-24 23:15:50"
        },
        {
            "id": "9",
            "customer_id": "1",
            "amount": 18,
            "created_at": "2022-02-24 23:15:50",
            "updated_at": "2022-02-24 23:15:50"
        }
    ]
}
```

### Error Responses

**Code** : `400 BAD REQUEST`

**Content** : 
```json
{
    "error": "Error fetching account data"
}
```

## Create Transaction

Creates a transaction or records a transfer from one account to another.

**URL** : `/api/transactions/{customerId}`

**Method** : `POST`

Provide name of customer to be created.

**Data example** All fields must be sent.

`@param customerId integer REQUIRED`

```json
{
    "debit_account": 11,
    "credit_account": 8,
    "amount": 50
}
```

### Success Response

**Code** : `201 CREATED`

**Content**

```json
{
    "success": "Transaction was successful"
}
```

### Error Responses

**Code** : `400 BAD REQUEST`

**Content** : 
```json
{
    "error": "Error creating transaction"
}
```

## Get Transaction

Gets a single account or gets all accounts.

**URL** : `/api/transactions/{accountId}`

**Method** : `GET`

Provide an account id to get a single accounts transactions or leave out to get all trannsactions.

**Data example**

`@param id integer NOT REQUIRED`

### Success Response

**Code** : `200 OK`

**Content**

```json
{
    "data": [
        {
            "id": "1",
            "account_id": "8",
            "amount": "10000",
            "created_at": "2022-02-25 07:51:34",
            "updated_at": "2022-02-25 07:51:34"
        },
        {
            "id": "3",
            "account_id": "8",
            "amount": "5000",
            "created_at": "2022-02-25 09:57:44",
            "updated_at": "2022-02-25 09:57:44"
        }
    ]
}
```
OR

```json
{
    "data": [
        {
            "id": "1",
            "account_id": "8",
            "amount": "10000",
            "created_at": "2022-02-25 07:51:34",
            "updated_at": "2022-02-25 07:51:34"
        },
        {
            "id": "2",
            "account_id": "10",
            "amount": "50050",
            "created_at": "2022-02-25 07:51:34",
            "updated_at": "2022-02-25 07:51:34"
        }
    ]
}
```

### Error Responses

**Code** : `400 BAD REQUEST`

**Content** : 
```json
{
    "error": "Error fetching transaction data"
}
```

