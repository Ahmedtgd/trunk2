<?php

namespace App\Console\Commands;
use TeamTNT\TNTSearch\TNTSearch;
use App\Http\Controllers\TNTSearchController;
use Illuminate\Console\Command;

class SearchIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a index to be used for TNT search';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       try {
            $tnts=new TNTSearchController();
            $config=$tnts->getConfig();

            $tnt=new TNTSearch();
            $tnt->loadConfig($config);
            $indexer = $tnt->createIndex('products');
            $indexer->query('SELECT 
                product.id,
                product.name,
                product.description,
                nproductid.nproduct_id,
                nsellerid.nseller_id
                FROM product
                LEFT JOIN nproductid on product.id = nproductid.product_id
                LEFT JOIN merchantproduct as mp on mp.product_id=product.id
                LEFT JOIN merchant on merchant.id = mp.merchant_id
                LEFT JOIN users on users.id = merchant.user_id
                LEFT JOIN nsellerid on nsellerid.user_id = users.id
                LEFT JOIN oshopproduct on oshopproduct.product_id=product.parent_id
                LEFT JOIN oshop on oshopproduct.oshop_id=oshop.id
                WHERE product.oshop_selected = true AND
                 product.available>0 
                 AND product.segment="b2c" 
                 AND product.status ="active" 
                 AND product.retail_price>0 
                 AND mp.deleted_at IS NULL
                 AND merchant.status="active"
                 AND oshop.status="active"
                 AND product.deleted_at IS NULL;');
            $indexer->run();
       } catch (\Exception $e) {
           return $e->getMessage();
       }
    }
}
