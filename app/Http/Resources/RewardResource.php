<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RewardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // สามารถออกแบบได้เลยว่าจะแสดงข้อมูลอะไรบ้าง
        // แต่ไม่แนะนำ ควรเก็บเป็น field ไปเลยจะดีกว่าสำหรับ expired_at
        // แต่ถ้ามีจริง ๆ ก็ทำที่ Model ดีกว่า แล้วเรียก function เอา
        return [
            'id' => $this->id,
            'name' => $this->name,
            'detail' => $this->detail,
            'total_amount' => $this->total_amount,
            'balance' => $this->balance,
//            'expired_at' => $this->created_at->addMonth(1),
            'expired_at' => $this->expired_at,
//            'codes' => $this->rewardCodes, // ตรงนี้เกิดการ join table กัน
//            'codes' => $this->whenLoaded('rewardCodes') // whenLoaded ช่วยให้ถ้าไม่มี code ก็จะไม่แสดง key code
            'point' => $this->point,
            'code' => RewardCodeResource::collection($this->whenLoaded('rewardCodes')) // wrapper ให้เหลือแค่ข้อมูลที่อยากแสดง
        ];
    }
}
