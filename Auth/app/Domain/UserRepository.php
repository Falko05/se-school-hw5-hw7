<?php

namespace App\Domain;

interface UserRepository
{
    /**
     * @param array $params - filter params
     * @return array|null
     */
    public function select(array $params): ?array;

    /**
     * @param array $data - entity_id and entity or id
     * @return bool
     */
    public function insert(array $data): bool;

    /**
     * @param array $data - entity_id and entity or id
     * @return bool
     */
    public function update(array $data): bool;

    /**
     * @param array $data - entity_id and entity or id
     * @return bool
     */
    public function delete(array $data): bool;
}
