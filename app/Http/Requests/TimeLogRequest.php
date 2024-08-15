<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Support\Requests\FormRequest;

class TimeLogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'taskId' => 'required',
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
            if ($this->request->manual) {
                $start = Carbon::parse($this->request->date);
                $stop = $start->copy()->addHours($this->request->hours)->addMinutes($this->request->minutes);
                $interval = $start->diffAsCarbonInterval($stop);

                return $this->model->create([
                    'user_id' => auth()->id(),
                    'task_id' => $this->request->taskId,
                    'project_id' => $this->request->projectId,
                    'is_manual' => true,
                    'started_at' => $start,
                    'stopped_at' => $stop,
                    'time' => $interval->format('%H:%I:%S'),
                    'time_human' => $interval,
                    'time_decimal' => $start->floatDiffInSeconds($stop),
                    'description' => $this->request->description,
                ]);
            }

            if ($this->request->start) {
                return $this->model->create([
                    'user_id' => auth()->id(),
                    'project_id' => $this->request->projectId,
                    'task_id' => $this->request->taskId,
                    'started_at' => now(),
                ]);
            } elseif ($this->request->stop) {
                $time = $this->model
                            ->whereUserId(auth()->id())
                            ->whereProjectId($this->request->projectId)
                            ->whereTaskId($this->request->taskId)
                            ->whereNull('stopped_at')
                            ->first();
                $start = $time->started_at;
                $stop = now();
                $interval = $start->diffAsCarbonInterval($stop);

                $time->update([
                    'stopped_at' => $stop,
                    'time' => $interval->format('%H:%I:%S'),
                    'time_human' => $interval,
                    'time_decimal' => $start->floatDiffInSeconds($stop),
                ]);

                return $time;
            }
        });
    }
}
