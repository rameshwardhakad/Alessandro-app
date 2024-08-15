<?php

namespace Admin\Http\Requests;

use AhsanDev\Support\Requests\FormRequest;
use Illuminate\Support\Facades\DB;

class PlanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
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
     */
    public function transaction(): void
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
