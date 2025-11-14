<?php

namespace App\Repositories;

use App\Models\Tender;
use Illuminate\Database\Eloquent\Builder;

class TenderRepository
{
    public function __construct(
        protected Tender $model
    ) {}

    public function allPaginated($filters, $perComponent){
        $query = $this->model->query();
        if (!empty($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->where(function (Builder $q) use ($searchTerm) {
                $q->where('ref_no', 'like', "%{$searchTerm}%");
                $q->orWhere('title', 'like', "%{$searchTerm}%");
                $q->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }
        return $query->paginate($perComponent);
    }

    public function create($data){
        return $this->model->create($data);
    }
}