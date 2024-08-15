<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;
use App\Support\Requests\FormRequest;

class PlanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:190',
            'short_description' => 'required|string|min:3|max:190',
            'monthly_price' => 'required|numeric',
            'stripe_plan_id' => 'required|string',
            'projects' => 'nullable|integer',
            'users' => 'nullable|integer',
            'features' => 'required',
        ];
    }

    /**
     * Database Transaction.
     *
     * @return void
     */
    public function transaction()
    {
        DB::transaction(function () {
            $this->model->forceFill([
                'name' => $this->request->name,
                'meta' => [
                    'name' => $this->request->name,
                    'short_description' => $this->request->short_description,
                    'monthly_price' => $this->request->monthly_price,
                    'stripe_plan_id' => $this->request->stripe_plan_id,
                    'projects' => $this->request->projects,
                    'users' => $this->request->users,
                    'features' => explode("\n", $this->request->features),
                ]
            ]);

            $this->model->save();
        });
    }
}
