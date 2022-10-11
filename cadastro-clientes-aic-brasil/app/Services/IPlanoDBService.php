<?php

namespace App\Services;

interface IPlanoDBService {
    public function getPlans(array $filter);
    public function getPlanById(int $id);
    public function addPlan($plan);
    public function updatePlan($plan);
    public function deletePlan(int $id);
    public function activate(int $id);
    public function deactivate(int $id);
}
