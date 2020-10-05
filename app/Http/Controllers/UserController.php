<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\parked_car;

class UserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $detail = '';
        return view('welcome', compact('detail'));
    }

    public function checkout(Request $checkout){
        parked_car::where('kode', $checkout->kode)->update(['checkout' => '1', 'cost' => (int)$checkout->cost]);

        $message_nopol = Str::upper($checkout->nopol);
        return redirect('/')->with('message', "Checkout $message_nopol success");
    }

    public function kode(Request $request){
        if(parked_car::where('kode', '=', $request->kode)->exists()){
            if(parked_car::where('kode', '=', $request->kode)->get()->last()->checkout == '1'){
                return redirect('/')->with('message', "Mobil dengan kode $request->kode sudah checkout.");
            } else {
                $now = Carbon::now();
                $detail = parked_car::where('kode', $request->kode)->get()->last();
                $cost = $now->diffInHours($detail->updated_at, true);
                $cost++;
                $cost = $cost * 3000;
                return view('welcome', compact('detail', 'cost'));
            }
        } else {
            return redirect('/')->with('message', "Kode $request->kode tidak ditemukan.");
        }
        // if(parked_car::where('nopol', '=', $request->nopol)->exists()){
        //     $now = Carbon::now();
        //     $detail = parked_car::where('nopol', '=', $request->nopol)->get()->last();
        //     if(parked_car::where('nopol', '=', $request->nopol)->get()->last()->nopol)
        // }else{
        //     self::startParking($request);
        // }
        $message_nopol = Str::upper($request->nopol);
        return redirect('/')->with('message', "Add $message_nopol success, Kode: $kode.");
    }

    public function startParking(Request $request, String $kode){
        $this->validate($request, [
            'nopol' => 'required|max:9|string|regex:/^[A-Za-z]{1,2}[0-9]{1,4}[A-Za-z]{1,3}$/'
        ]);

        $post = parked_car::create([
            'nopol' => Str::upper($request->nopol),
            'pegawai' => Auth::user()->name,
            'kode' => $kode,
            'updated_at' => NULL
        ]);
    }

    public function save(Request $request){
        $message_nopol = Str::upper($request->nopol);
        if(parked_car::where('nopol', '=', $request->nopol)->exists()){
            if(parked_car::where('nopol', '=', $request->nopol)->get()->last()->checkout == '1'){
                do{
                    $kode = Str::upper(Str::random(6));
                }while(parked_car::where('kode', '=', $kode)->exists());
                if(!parked_car::where('kode', '=', $kode)->exists()){
                    self::startParking($request, $kode);
                }
            } else {
                $nopol_kode = parked_car::where('nopol', '=', $request->nopol)->get()->last()->kode;
                return redirect('/')->with('message', "Mobil $message_nopol sudah parkir, Kode: $nopol_kode.");
            }
        } else {
            do{
                $kode = Str::upper(Str::random(6));
            }while(parked_car::where('kode', '=', $kode)->exists());
            
            if(!parked_car::where('kode', '=', $kode)->exists()){
                self::startParking($request, $kode);
            }
        }
        // if(parked_car::where('nopol', '=', $request->nopol)->exists()){
        //     $now = Carbon::now();
        //     $detail = parked_car::where('nopol', '=', $request->nopol)->get()->last();
        //     if(parked_car::where('nopol', '=', $request->nopol)->get()->last()->nopol)
        // }else{
        //     self::startParking($request);
        // }
        return redirect('/')->with('message', "Add $message_nopol success, Kode: $kode.");
    }
}
