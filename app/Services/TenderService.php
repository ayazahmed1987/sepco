<?php

namespace App\Services;

use App\Repositories\TenderRepository;
use App\Models\Tender;

class TenderService
{
    public function __construct(
        protected TenderRepository $repo
    ) {}

    public function getAllPaginated($filters, $records){
        return $this->repo->allPaginated($filters, $records);
    }

    public function create($data){
        return $this->repo->create($data);
    }

    public function update(Tender $tender, array $data)
    {
        return $tender->update($data);
    }
}