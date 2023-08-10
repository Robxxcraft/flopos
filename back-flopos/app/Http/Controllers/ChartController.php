<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderRecentResource;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller{
    public function dashboard(){
        $daily = Order::whereDay('created_at', Carbon::today())->sum('total_amount');
        $weekly = Order::whereBetween('created_at', [Carbon::now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d'),Carbon::now()->endOfWeek(Carbon::SATURDAY)->format('Y-m-d')])->sum('total_amount');
        $monthly = Order::whereMonth('created_at', Carbon::now()->format('m'))->sum('total_amount');
        $yearly = Order::whereYear('created_at', Carbon::now()->format('Y'))->sum('total_amount');

        $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        $amount = [];
        $incomes = (int) Order::sum('total_amount');
        $expense = (int) Product::sum(DB::raw('price * stock'));
        
        $orders = Order::latest()->with('user')->take(3)->get();

        for($index=1; $index <= 12; $index++) { 
            $amount[] = (int) Order::whereMonth('created_at', $index)->sum('total_amount');
        }
        $charts = (object) [
            'months' => $months,
            'amount' => $amount,
            'incomes' => $incomes,
            'expense' => $expense
        ];

        $data = (object) [
            'incomes' => (object)[
                'daily' => (int)$daily,
                'weekly' => (int)$weekly,
                'monthly' => (int)$monthly,
                'yearly' => (int)$yearly,
            ],
            'charts' => $charts,
            'orders' => OrderRecentResource::collection($orders)
        ];
        return response()->json($data, 200);
    }
}
