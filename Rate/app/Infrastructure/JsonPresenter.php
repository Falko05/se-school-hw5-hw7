<?php

namespace App\Infrastructure;

class JsonPresenter implements Presenter
{

    public function present(array $params): string
    {
        return json_encode($params);
    }
}