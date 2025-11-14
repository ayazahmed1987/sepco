<?php

namespace App\Services;

use App\Repositories\TenderPersonRepository;
use App\Models\TenderPerson;

class TenderPersonService
{
    public function __construct(
        protected TenderPersonRepository $repo
    ) {}

    public function getAllPaginated($filters, $records){
        return $this->repo->allPaginated($filters, $records);
    }

    public function create($data){
        return $this->repo->create($data);
    }

    public function update(TenderPerson $tender_person, array $data)
    {
        return $tender_person->update($data);
    }
}