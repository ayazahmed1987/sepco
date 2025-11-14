<?php

namespace App\Repositories;

use App\Models\TenderPerson;
use Illuminate\Database\Eloquent\Builder;

class TenderPersonRepository
{
    public function __construct(
        protected TenderPerson $model
    ) {}

    public function allPaginated($filters, $perComponent){
        $query = $this->model->query();
        if (!empty($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->where(function (Builder $q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%");
                $q->orWhere('email', 'like', "%{$searchTerm}%");
                $q->orWhere('phone', 'like', "%{$searchTerm}%");
            });
        }
        return $query->paginate($perComponent);
    }

    public function create($data){
        return $this->model->create($data);
    }

    public function update($data, TenderPerson $tender_person){
        return $tenderPerson->update($data);
    }
}