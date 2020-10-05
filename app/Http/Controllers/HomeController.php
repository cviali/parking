<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\parked_car;

use App\Exports\ParkedCarExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $message = '';
        $request->user()->authorizeRoles(['admin']);
        $now = Carbon::now();
        $post = parked_car::all();
        return view('dashboard', compact('post','now', 'message'));
    }

    public function export_excel(Request $request){
        // dd($request->start);
        // return Excel::download(new ParkedCarExport($start, $end), 'parked_car.xlsx');
    }

    public function search(Request $request){
        $now = Carbon::now();
        $start = new Carbon($request->start);
        $end = new Carbon($request->end);
        $inputStart = $request->start;
        $inputEnd = $request->end;
        // $post = parked_car::whereDate('created_at', '<=', $end)->get();

        if($request->submit == "search"){
            if($request->start == null || $request->end == null){
                $post = parked_car::all();
                $message = "Input tanggal pencarian harus valid.";
                return view('dashboard', compact('post','now', 'message', 'inputStart', 'inputEnd'));
            } else if($start->gt($end)) {
                $post = parked_car::all();
                $message = "Input tanggal mulai pencarian tidak bisa lebih baru dari tanggal akhir pencarian.";
                return view('dashboard', compact('post','now', 'message', 'inputStart', 'inputEnd'));
            } else if($start == $end) {
                $post = parked_car::whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->get();
                $message = "Menampilkan mobil yang masuk pada tanggal $request->start.";
                return view('dashboard', compact('post','now', 'message', 'inputStart', 'inputEnd'));
            } else {
                $post = parked_car::whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->get();
                $message = "Menampilkan mobil yang masuk dari tanggal $request->start hingga $request->end.";
                return view('dashboard', compact('post','now', 'message', 'inputStart', 'inputEnd'));
            }
        } else {
            return Excel::download(new ParkedCarExport($start, $end), 'parked_car.xlsx');
        }
    }
}
