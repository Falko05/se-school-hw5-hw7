<?php

namespace App\Infrastructure;

interface Presenter
{

    public function present(array $params): string;
}