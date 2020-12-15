<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use App\Jobs\SalesCSVProcess;

class SalesController extends Controller
{
    public function index(){
        
        return view('Sales.index');
    }

    public function upload(){
        if (request()->has('csv')) {
            $data   =   file(request()->csv);
            $chunks = array_chunk($data, 1000);
            $path = resource_path('temp');
            if(!is_dir($path)){
                mkdir($path,0777,true);
            }
            foreach($chunks as $key => $chunk){
                $file_name = $path."/temp-".$key.".csv";
                file_put_contents($file_name,$chunk);
            }

            $header = [];
            $batch  = Bus::batch([])->dispatch();
            $files = glob("$path/*.csv");
            //dd($files);
            foreach ($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);

                if ($key === 0) {
                    $header = $data[0];
                    unset($data[0]);
                }
                /*foreach ($data as $sale) {
                    $saleData = array_combine($header, $sale);
                    dd($saleData);
                }*/
                
                $batch->add(new SalesCSVProcess($data, $header));
            }
            return $batch;
        }
        
    }

    public function batch()
    {
        $batchId = request('id');
        return Bus::findBatch($batchId);
    }

    public function batchInProgress()
    {
        $batches = DB::table('job_batches')->where('pending_jobs', '>', 0)->get();
        if (count($batches) > 0) {
            return Bus::findBatch($batches[0]->id);
        }

        return [];
    }
}
