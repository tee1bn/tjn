<?php


namespace v2\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Config;

class Signals extends Eloquent 
{
	
	protected $fillable = [
							'admin_id',
							'detail',
							'published_at',
							'starts_at', 
							'closes_at'
						];
	

	protected $table = 'signals';
	


	/*[
		'symbol' => 'USD/JPY',
		'entry_price' => '1.0023',
		'stop_loss' => '1.0023',
		'take_profit' => '1.0023',
		'trailing_stop' => 'buy',
		'order' => 'buy',
		'comment' => 'buy',
		'starts_at' => 'buy',
		'closes_at' => 'buy',
	]
*/




	public function geteditLinkAttribute()
	{
		$domain = Config::domain();

		$link2 = Config::domain()."/admin/edit_signal/{$this->id}";
		return $link2;
	}

	public function getdeleteLinkAttribute()
	{
		$domain = Config::domain();

		$link2 = Config::domain()."/signals/delete/{$this->id}";
		return $link2;
	}


	public function getPreviewLinkAttribute()
	{
		$domain = Config::domain();

		$link = "$domain/admin/signals_preview/{$this->id}";
		return $link;
	}



	public static function createLink()
	{
		$domain = Config::domain();

		$link2 = Config::domain()."/signals/create";
		return $link2;

	}





	public function scopeRunning($query)
	{
		$date = date("Y-m-d H:i:s");

		$query->where('starts_at', '<', $date)->where('closes_at', '>', $date);
	}


	public function scopePublished($query)
	{
		return $query->where('published_at', '!=', null);
	}



	public function is_published()
	{	
		return $this->published_at != null;
	}


	public function admin()
	{
		return $this->belongsTo('Admin', 'admin_id');
	}


	public function getFormattedStartsAtAttribute()
	{
		 $format = date("Y-m-d\TH:s", strtotime($this->starts_at));

		 return $format;
	}

	public function getFormattedClosesAtAttribute()
	{
		 $format = date("Y-m-d\TH:s", strtotime($this->closes_at));

		 return $format;
	}


	public function getDetailArrayAttribute()
	{
		if ($this->detail == null) {
			return [];
		}
		$detail = json_decode($this->detail, true);

		$format = ['starts_at', 'closes_at'];

		foreach ($detail as $key => $value) {
			if (in_array($key, $format)) {
				$detail["format_$key"] = date("Y-m-dTH:s", strtotime($value));
			}
		}



		return $detail;
	}



}


















?>