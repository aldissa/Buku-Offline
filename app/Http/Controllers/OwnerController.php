<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OwnerController extends Controller
{
    function index()
    {
        $transaksi = Transaksi::where('status', 'dibayar')->get();

        $tanggal = $transaksi->pluck('updated_at')->map(function ($date) {
            return \Carbon\Carbon::parse($date)->format('d-m-Y');
        })->toArray();

        $profit = $transaksi->pluck('totalharga')->toArray();

        $totalPendapatan = array_sum($profit);

        $chart = (new LarapexChart)->setType('area')
            ->setTitle('Penjualan buku')
            ->setSubtitle('Dari transaksi hari ini')
            ->setXAxis($tanggal)
            ->setDataset([
                [
                    'name' => 'Pendapatan',
                    'data' => $profit
                ]
            ])->setColors(['#073B4C']);
        return view('owner.index', compact('chart','totalPendapatan'));
    }

    function filteredChart(Request $request) {
        if($request){
            $valid = Validator::make($request->all(), [
                'dateFrom' => 'required|date',
                'dateTo' => 'required|date|after_or_equal:dateFrom'
            ]);

            if($valid->fails()){
                return redirect()->back()->with('err', $valid->errors());
            }
        }

        if(!$request->dateFrom && !$request->dateTo) {
            $transaksi = Transaksi::where('status', 'dibayar')->get();
        }

        if($request->dateFrom && $request->dateTo) {
            $transaksi = Transaksi::where('status', 'dibayar')
                ->whereDate('updated_at', '>=', Carbon::parse($request->dateFrom)->startOfDay())
                ->whereDate('updated_at', '<=', Carbon::parse($request->dateTo)->endOfDay())
                ->get();
        }

        $tanggal = $transaksi->pluck('updated_at')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d-m-Y');
        })->toArray();

        $profit = $transaksi->pluck('totalharga')->toArray();
        $totalPendapatan = $transaksi->sum('totalharga');
        $chart = (new LarapexChart)->setType('area')
            ->setTitle('Penjualan buku')
            ->setSubtitle('Dari transaksi hari ini')
            ->setXAxis($tanggal)
            ->setDataset([
                [
                    'name' => 'Pendapatan',
                    'data' => $profit
                ]
            ])->setColors(['#073B4C']);
        return view('owner.index', compact('chart', 'totalPendapatan'));
    }
}
