<?php

use  v2\Models\Market;

/**
 */
class SalesController extends controller
{


    public function __construct()
    {
    }

    //landing page for all sales
    public function s($product_ref)
    {
        $product_references = explode("-", $product_ref);

        $item_id = $product_references[0];
        $register = Market::$register;


        $model = $register['product']['model'];
        $item =  new $model;



        $item_on_sale = Market::where('category', $item::$category_in_market)
        ->where('item_id', $item_id)
        ->latest()
        ->OnSale()
        ->first();


        if ($item_on_sale == null) {

            Session::putFlash("danger","Item not found");
            Redirect::back();
        }


        $product = $item_on_sale->preview();

        $this->view('guest/single-product', compact('product'));
        // $this->view('composed/view_product', compact('product'));

    }

    public function index($referral_username = null)
    {

    }


}


?>