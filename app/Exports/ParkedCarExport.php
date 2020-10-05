<?php

namespace App\Exports;

use App\parked_car;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class ParkedCarExport implements FromView
{
    use Exportable;
    public function __construct($start, $end){
    	// dd($start);
    	if($start != null || $end != null){
	    	$this->start = $start;
	    	$this->end = $end;
	    }
    }

    public function view(): View{
    	if($this->start != null || $this->end != null){
	        return view('excel.result', [
	            'results' => parked_car::whereDate('created_at', '>=', $this->start)->whereDate('created_at', '<=', $this->end)->get()
	        ]);
    	} else {
	        return view('excel.result', [
	            'results' => parked_car::all()
	        ]);
	    }
    }
}
