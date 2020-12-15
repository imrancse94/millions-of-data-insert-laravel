<?php

namespace App\Jobs;

use App\Models\Sales;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Batchable;

class SalesCSVProcess implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $header;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $header)
    {
        $this->data   = $data;
        $this->header = $header;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->data as $sale) {

            $saleData = array_combine($this->header, $sale);
            
            $processData['region'] = $saleData['Region'];
            $processData['country'] = $saleData['Country'];
            $processData['item_type'] = $saleData['Item Type'];
            $processData['sales_channel'] = $saleData['Sales Channel'];
            $processData['order_priority'] = $saleData['Order Priority'];
            $processData['order_date'] = date('Y-m-d',strtotime($saleData['Order Date']));
            $processData['order_id'] = $saleData['Order ID'];
            $processData['ship_date'] = date('Y-m-d',strtotime($saleData['Ship Date']));
            $processData['unit_price'] = $saleData['Unit Price'];
            $processData['unit_sold'] = $saleData['Units Sold'];
            $processData['unit_cost'] = $saleData['Unit Cost'];
            $processData['total_revenue'] = $saleData['Total Revenue'];
            $processData['total_cost'] = $saleData['Total Cost'];
            $processData['total_profit'] = $saleData['Total Profit'];

            Sales::create($processData);
        }
    }
}
