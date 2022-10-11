<?php

namespace App\Services;

use App\Plano;
use App\Services\IPlanoDBService;

class PlanoDBService implements IPlanoDBService{
    public function getPlans(array $filter){
        return Plano::where($filter);
    }
    public function getPlanById(int $id){
        return Plano::find($id);
    }
    public function addPlan($plan){
        $existingPlan = Plano::where(['id_galaxpay' => $plan['galaxPayId']])->first();
        if(!$existingPlan){
            $newPlan = new Plano();

            $newPlan['nome']          = $plan['name'];
            $newPlan['ativo']         = false;
            $newPlan['id_galaxpay']   = $plan['galaxPayId'];

            $newPlan->save();
        }
    }
    public function updatePlan($plan){

    }
    public function deletePlan(int $id){
        $plan = Plano::find($id);

        $plan->delete();
    }
    public function activate(int $id){
        $plan = Plano::where(['id_galaxpay' => $id])->first();

        $plan['ativo'] = true;

        $plan->save();
    }
    public function deactivate(int $id){
        $plan = Plano::where(['id_galaxpay' => $id])->first();

        $plan['ativo'] = false;

        $plan->save();
    }
}
