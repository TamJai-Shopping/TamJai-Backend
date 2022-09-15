<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RewardResource;
use App\Models\Reward;
use App\Models\RewardCode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RewardController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $rewards = Reward::active()->get();
        $rewards = Reward::with('rewardCodes')->active()->get(); // เพื่อให้แสดง rewardCodes ด้วย
        // active คือกรองเฉพาะที่ active เขียนไว้ใน Model
//        return $rewards;
//        $user = auth()->user();
        return RewardResource::collection($rewards);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reward = new Reward();
        $reward->name = $request->get('name');
        if ($request->has('detail')) {
            $reward->detail = $request->get('detail');
        }
        // หรือใช้ one line if else ได้
        // $reward->detail = $request->get('detail') ?? null; // ถ้าไม่มีอยู่ให้ใช้ค่า null
        $reward->point = $request->get('point');
        $reward->total_amount = $request->get('total_amount');
        $reward->balance = $request->get('balance');
        $reward->is_active = $request->get('is_active');

        if ($reward->save()) {
            $codes = [];
            for ($i = 0; $i < $reward->total_amount; $i++) {
                $rewardCode = new RewardCode();
                $rewardCode->code = fake()->lexify('??????');
                $codes[] = $rewardCode;
            }
            $reward->rewardCodes()->saveMany($codes);

            return response()->json([
                'success' => true,
                'message' => 'Reward created with id '.$reward->id,
                'reward_id' => $reward->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'Reward creation failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reward  $reward
     * @return \Illuminate\Http\Response
     */
    public function show(Reward $reward)
    {
        $rewardCode = $reward->rewardCodes;
//        return $reward; // แสดงทุกข้อมูลไม่ว่าจะเป็นวันที่ลบ วันที่สร้าง ซึ่งอาจจะไม่จำเป็นต้องให้เห็นหมดขนาดนั้น
        return new RewardResource($reward); // ใช้ transform ข้อมูลให้แค่ที่จำเป็นต้องเห็นเท่านั้น
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reward  $reward
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reward $reward)
    {
        if ($request->has('name')) $reward->name = $request->get('name');
        if ($request->has('detail')) $reward->detail = $request->get('detail');
        if ($request->has('point')) $reward->point = $request->get('point');
        if ($request->has('total_amount')) $reward->total_amount = $request->get('total_amount');
        if ($request->has('balance')) $reward->balance = $request->get('balance');
        if ($request->has('is_active')) $reward->is_active = $request->get('is_active');

        if ($reward->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Reward updated with id '.$reward->id,
                'reward_id' => $reward->id
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => 'Reward update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reward  $reward
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reward $reward)
    {
        $name = $reward->name;
        if ($reward->delete()) {
            return response()->json([
                'success' => true,
                'message' => "Reward {$name} has deleted",
                'reward_id' => $reward->id
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "Reward {$name} delete failed",
            'reward_id' => $reward->id
        ], Response::HTTP_BAD_REQUEST);
    }

    public function search(Request $request) {
        $q = $request->query('q'); // เป็นตัวบอกตัวแปลที่ส่งเข้ามา ซึ่งจะต้องมี ? ก่อนแล้วค่อยชื่อตัวแปล ขั้นด้วย & เช่น
        // ?q=word&sort=DESC
        // $sort_variable = $request->query('sort') ?? 'asc';
        $rewards = Reward::where('name', 'LIKE', "%{$q}%")
                         ->orWhere('detail', 'LIKE', "%{$q}%")
            //           ->orderBy('name', $sort_variable')
                         ->get();
        return $rewards;
    }
}
