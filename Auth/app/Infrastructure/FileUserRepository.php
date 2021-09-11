<?php

namespace App\Infrastructure;

use App\Domain\UserRepository;

class FileUserRepository implements UserRepository
{

    public $dbPath;
    public $db;
    public $dbData;

    public function __construct($fileName)
    {
        $this->dbPath = __DIR__ . '/../../' . $fileName;
        if (is_file($this->dbPath))
        {
            $this->db = file_get_contents($this->dbPath);
        }

        $this->dbData = (array) json_decode($this->db);
    }

    public function select(array $params): ?array
    {
        if (isset($params['key'])) {
            if (isset($this->dbData[$params['key']])) {
                return (array) $this->dbData[$params['key']];
            }
            return null;
        }
        return $this->dbData;
    }

    public function insert(array $data): bool
    {
        if (isset($data['key']) && isset($this->dbData[$data['key']])) {
            $this->dbData[$data['key']] = $data;
        } else {
            $this->dbData[] = $data;
        }

        return (bool) file_put_contents($this->dbPath, json_encode($this->dbData));
    }

    public function update(array $data): bool
    {
        if (isset($data['key']) && isset($this->dbData[$data['key']])) {

            $this->dbData[$data['key']] = $data;

            return (bool) file_put_contents($this->dbPath, json_encode($this->dbData));
        }

        return false;
    }

    public function delete(array $data): bool
    {
        if (isset($data['key']) && isset($this->dbData[$data['key']])) {
            unset($this->dbData[$data['key']]);

            return (bool) file_put_contents($this->dbPath, json_encode($this->dbData));
        }

        return false;
    }
}
