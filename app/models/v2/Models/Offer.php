<?php


namespace v2\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;
use  Filters\Traits\Filterable;
use  v2\Models\Withdrawal;
use  v2\Models\DepositOrder;
use Config;
use Illuminate\Database\Capsule\Manager as DB;


class Offer extends Eloquent 
{	

	use Filterable;
	
	protected $fillable = [
		'name',
		'details',
		'benefits',
		'availability',
		'description',
		'lists',
		'context'
	];


	protected $table = 'offers';

	
	public static $perks = [
		'course' =>[
				'properties' => [
					'price' => '',
					'bonus_price' => '',
					'amount_funded_in_usd' => '',
					'amount_in_usd' => '',
					'price_currency' => '',
				],

				'benefits'=> [/*
							   'basis_online_workshop' => [
							   		'title'=> 'Basis online Workshop',
							   ],
							   'media_center_small' => [
							   		'title'=> 'Media Center Small',
							   ],

							   'nsw_online_office_small' => [
							   		'title'=> 'NSW Online Office Small',
							   ],
							   'finance_schulung' => [
							   		'title'=> 'Finance Schulung ',
							   ],
							   'invitepro_tool' => [
							   		'title'=> "InvitePro Tool",
							   ],
							   'basis_online_v_material' => [
							   		'title'=> 'Basis online Vertriebsmaterial',
							   ],
							   'erw_marketing_pack' => [
							   		'title'=> 'Erweitertes Marketing-Pack',
							   ],
							   'nsw_online_shop' => [
							   		'title'=> 'NSW Online Shop',
							   ],
							   'isp' => [
							   		'title'=> 'Incentive Silber Taler: ISP',
							   ],
							   'incentive_ebene_3' => [
							   		'title'=> 'Incentive:Ebene 3',
							   ],
*/
							]

		],
		'market' =>[
				'properties' => [
					'bs' => '',
				],

				'benefits'=>[
					'basis_online_workshop' => [
							'title'=> 'Basis online Workshop',
					],

				]
		],

	];



	public static function create_offer()
	{
		$domain = Config::domain();
		$link = "$domain/admin/create_offer";
		return $link;
	}


	public function getEditUrlAttribute()
	{

		$domain = Config::domain();
		$link = "$domain/admin/edit_offer/$this->id";
		return $link;
	}

	
	public function scopeAvailable($query)
	{
		return $this->where('availability',1);
	}

	
	public function scopeContext($query, $context)
	{
		return $this->where('context', $context);
	}


	public function getDetailsArrayAttribute()
    {

		if ($this->details == null) {
			
			return [];
		}
			
        $details =  json_decode($this->details ,true);

        $perks = self::$perks[$this->context]['properties'] ?? end(self::$perks)['properties'] ;

        $response = $details + $perks;

        return  $response;
    }

    public function getAvailableStatusAttribute()
    {

             $status = (($this->availability == 1) )
              ? "<span type='span' class='badge badge-xs badge-success'>Active</span>":
               "<span type='span' class='badge badge-xs badge-danger'>Blocked</span>";

               return $status;
    }



	public function getBenefitsArrayAttribute()
    {

		if ($this->benefits == null) {
			
			return [];
		}
			
        return  json_decode($this->benefits ,true);
    }


	public function getListsArrayAttribute()
    {

    	$list = explode(",", $this->lists);

    	return $list;
    }


}


















?>