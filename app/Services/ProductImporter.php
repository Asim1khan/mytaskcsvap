<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use App\Events\ProductCreated;

class ProductImporter
{
    public function importProductsFromUploadedCSV($uploadedFile)
    {
        $batchSize = 100;
        $csvData = $this->readCSV($uploadedFile);

        $products = [];

        foreach ($csvData as $rowData) {
            $products[] = [
                'title' => $rowData['Title'],
                'description' => $rowData['Description'],
                'sku' => $rowData['SKU'],
                'type' => $rowData['Type'],
                'cost_price' => $rowData['CostPrice'],
                'status' => $rowData['Status'],
            ];

            if (count($products) >= $batchSize) {
                $this->insertProductsInBatch($products);
                $products = [];
            }
        }

        if (!empty($products)) {
            $this->insertProductsInBatch($products);
        }
    }

    protected function readCSV($uploadedFile)
    {
        $csvData = [];
        $file = fopen($uploadedFile, 'r');

        // Read the CSV file and process data


        while (($rowData = fgetcsv($file)) !== false) {
            $csvData[] = [
                'Title' => $rowData[0],
                'Description' => $rowData[1],
                'SKU' => $rowData[2],
                'Type' => $rowData[3],
                'CostPrice' => $this->parseDecimal($rowData[4]),
                'Status' => $rowData[5],
            ];
        }

        fclose($file);
        return $csvData;
    }
    protected function insertProductsInBatch($products)
    {
        $existingSKUs = DB::table('products')
            ->whereIn('sku', array_column($products, 'sku'))
            ->pluck('sku')
            ->toArray();
    
        $batches = array_chunk($products, 100);
    
        foreach ($batches as $batch) {
            $batchToInsert = [];
            foreach ($batch as $product) {
                if (!in_array($product['sku'], $existingSKUs)) {
                    $batchToInsert[] = $product;
                    $existingSKUs[] = $product['sku']; // Add to existing SKUs to prevent duplicate checks
                }
            }





            
            
            if (!empty($batchToInsert)) {
                DB::table('products')->insert($batchToInsert);
                foreach ($batchToInsert as $product) {
                    event(new ProductCreated($product['sku']));
                }
            }
        }
    }
    
    
    
    protected function parseDecimal($value)
{
    if (is_numeric($value)) {
        return (float) $value;
    }
    return 0.0; // Default value if not numeric
}
}

