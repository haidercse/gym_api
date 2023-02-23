<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MemberCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                return [
                    'member_id' => $data->member_id,
                    'name' => $data->name,
                    'gender' => $data->gender,
                    'mobile_number' => $data->mobile_number,
                    'blood' => $data->blood,
                    'address' => $data->address,
                    'image' => asset($data->image),
                    'start_date' => $data->start_date,
                    'end_date' => $data->end_date,
                    'lock' => $data->lock,
                    'create_by' => $data->user->name,
                    'card_no' => $data->card_no,
                    'status' => $data->status
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}