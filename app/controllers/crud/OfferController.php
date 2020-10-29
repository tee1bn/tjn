<?php

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Str;
use v2\Models\Offer;



/**
 * 
 */
class OfferController extends controller
{
	
	function __construct()
	{

		$this->middleware('administrator')->mustbe_loggedin();

	}




	public function update_offer()
	{

		$offer = Offer::find($_POST['id']);

		DB::beginTransaction();

		try {

			$offer->update([

				'name' => $_POST['name'],
				'details' => json_encode($_POST['details'] ?? []),
				'benefits' => json_encode($_POST['benefits'] ?? []),
				'availability' => $_POST['availability'] ?? 0,
				'description' => $_POST['description'],
				'lists' => $_POST['lists'],
				'context' => $_POST['context']
			]);

			DB::commit();
			Session::putFlash('success', 'Saved succesfully.');

		} catch (Exception $e) {
			DB::rollback();
			Session::putFlash('danger', 'Something went wrong');
			
		}

	}




	public function fetch_offers($id)
	{

		$offers = Offer::all()->keyBy('id');
		$offer = Offer::find($id);

		$offer->details = ($offer->DetailsArray == []) ? end(Offer::$perks)['properties'] : $offer->DetailsArray;
		$offer->benefits = ($offer->BenefitsArray == []) ? end(Offer::$perks)['benefits'] : $offer->BenefitsArray;

		$offer_class = get_class_vars(Offer::class);


		$response = compact('offers', 'offer_class','offer');

		header("content-type:application/json");

		echo json_encode($response);


	}


}