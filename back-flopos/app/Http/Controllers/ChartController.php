<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class ChartController extends Controller{
    public function dashboard(){
        $daily = Order::whereDay('created_at', Carbon::today())->sum('total_amount');
        $weekly = Order::whereBetween('created_at', [Carbon::now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d'),Carbon::now()->endOfWeek(Carbon::SATURDAY)->format('Y-m-d')])->sum('total_amount');
        $monthly = Order::whereMonth('created_at', Carbon::now()->format('m'))->sum('total_amount');
        $yearly = Order::whereYear('created_at', Carbon::now()->format('Y'))->sum('total_amount');
        $data = (object) [
            'daily' => (int)$daily,
            'weekly' => (int)$weekly,
            'monthly' => (int)$monthly,
            'yearly' => (int)$yearly,
        ];
        return response()->json($data, 200);
    }

    public function chart(Order $order){
        $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        $amount = [];
        $incomes = (int) Order::sum('total_amount');
        $expense = (int) Product::sum(\DB::raw('price * stock'));
        for($index=1; $index <= 12; $index++) { 
            $amount[] = (int) $order->whereMonth('created_at', $index)->sum('total_amount');
        }
        $charts = (object) [
            'months' => $months,
            'amount' => $amount,
            'incomes' => $incomes,
            'expense' => $expense
        ];
        return response()->json($charts, 200);
    }   
}
