<?php

namespace App\Domain;

use Exception;

class AuthService implements AuthInterface
{

    private $repository;
    public $customer;
    public $tokenLib;

    public function __construct(UserRepository $repository, Customer $customer, TokenLib $tokenLib)
    {
        $this->repository = $repository;
        $this->customer = $customer;
        $this->tokenLib = $tokenLib;
    }

    /**
     * @throws Exception
     */
    public function login(): Customer
    {
        $this->validate(['email']);
        $this->checkData();

        $tokenData = $this->tokenLib->createToken($this->customer->email);
        $this->customer->token = $tokenData;

        return $this->customer;
    }

    /**
     * @throws Exception
     */
    public function register(): Customer
    {
        $this->validate(['email']);
        $this->checkEmailExists();

        $customerData = [
            'email' => $this->customer->email,
            'password' => password_hash($this->customer->password, PASSWORD_BCRYPT)
        ];
        $this->repository->insert($customerData);

        return $this->customer;
    }

    /**
     * @throws Exception
     */
    public function validate(array $input): bool
    {
        $rules = [
            'email' => [
                'pattern' => '#^([a-z0-9_.-]{1,20}+)@([a-z0-9_.-]+)\.([a-z\.]{2,10})$#',
                'message' => 'E-mail is incorrect',
            ]
        ];

        $customerData = (array) $this->customer;

        foreach ($input as $val) {
            if (!isset($customerData[$val]) || !preg_match($rules[$val]['pattern'], $customerData[$val])) {
                $error = $rules[$val]['message'];
                throw new Exception($error);
            }
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public function checkEmailExists(): bool
    {
        if (isset($this->repository->dbData[$this->customer->email])) {
            throw new \Exception("User with the same email exist.");
        }

        return false;
    }

    /**
     * @throws Exception
     */
    public function checkData(): bool
    {
        if (isset($this->repository->dbData[$this->customer->email])) {
            $hash = $this->repository->dbData[$this->customer->email]->password;
            if (!$hash || !password_verify($this->customer->password, $hash)) {
                throw new \Exception("Password incorrect.");
            }
        } else {
            throw new \Exception("Email not found.");
        }
        return true;
    }

}