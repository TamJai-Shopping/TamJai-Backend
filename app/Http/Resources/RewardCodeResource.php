<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RewardCodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
//            'reward' => new RewardResource($this->reward), // แสดงทุกครั้งไม่ว่าจะเรียกผ่าน rewards หรือ reward_codes มันจะซ้ำซ้อนเวลาเรียนผ่าน reward
            'reward' => new RewardResource($this->whenLoaded('reward')),
            'user' => $this->whenNotNull($this->user), // ถ้าไม่ว่างถึงจะส่ง key นี้ไปด้วย
            'redeemed_at' => $this->whenNotNull($this->redeemed_at)
        ];
    }
}
