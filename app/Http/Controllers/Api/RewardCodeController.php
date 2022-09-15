<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RewardCodeResource;
use App\Models\Reward;
use App\Models\RewardCode;
use Illuminate\Http\Request;

class RewardCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $rewardCodes = RewardCode::with(['reward', 'user'])->get();
        $rewardCodes = RewardCode::with(['reward', 'user'])->paginate(10); // แสดงเป็นหน้าแทน ไม่ใช่ทั้งหมด
        return RewardCodeResource::collection($rewardCodes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RewardCode  $rewardCode
     * @return \Illuminate\Http\Response
     */
    public function show(RewardCode $rewardCode)
    {
        return new RewardCodeResource($rewardCode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RewardCode  $rewardCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RewardCode $rewardCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RewardCode  $rewardCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(RewardCode $rewardCode)
    {
        //
    }

    public function search(Request $request) {
        $q = $request->query('q'); // เป็นตัวบอกตัวแปลที่ส่งเข้ามา ซึ่งจะต้องมี ? ก่อนแล้วค่อยชื่อตัวแปล ขั้นด้วย & เช่น
        // ?q=word&sort=DESC
        $sort_variable = $request->query('sort') ?? 'asc';
        $rewardCodes = RewardCode::where('code', 'LIKE', "%{$q}%")
                       ->orderBy('code', $sort_variable)
                       ->paginate(10) // เปลี่ยนจาก get
                       ->withQueryString(); // ช่วยทำให้ link มี ?q=... ไปด้วย
        return RewardCodeResource::collection($rewardCodes); // ถ้า return แค่ rewardCodes จะไม่มีให้ไปหน้าอื่น
    }
}
