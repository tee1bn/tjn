<?php
#//to implement sellable

use Illuminate\Database\Eloquent\Model as Eloquent;
use  v2\Models\Market;
use  v2\Models\Offer;

use v2\Tax\Tax;


class Course extends Eloquent 
{
	
        	protected $fillable = [
                                    'instructor_id',
                                    'status',
                                    'goal',
                                    'curriculum',
                                    'title',
                                    'price',
                                    'offers',
                                    'old_price',
                                    'subtitle',
                                    'description',
                                    'primarily_taught',
                                    'level',
                                    'image',
                                    'category_id'
                                ];
	
	protected $table = 'courses';

    public static $category_in_market = 'course';


    public function getOffersArrayAttribute()
    {
        if ($this->offers == null) {
            
            return [];
        }
            
        return  json_decode($this->offers ,true);
        
    }


    public function getIncludedOffersAvailableAttribute()
    {

        $included_offers = $this->OffersArray ?? [];

        $offers = Offer::Available()->Context('course')->get();

        $offers = $offers->filter(function($offer) use ($included_offers){
                if (in_array($offer->id, $included_offers)) {
                    return true;
                }
                    return false;
        });

        return $offers;
    }


    public function getOffersAvailableAttribute()
    {

        $offers = Offer::Available()->Context('course')->get();

        return $offers;
    }


    public function getCampaignsAttribute()
    {

    }


    public function getAdminPreviewLinkAttribute()
    {   
            $href =  Config::domain()."/admin/courses/$this->id/access";
            return $href ;
    
    }

    public function getNextCourseAttribute()
    {
        $domain = Config::domain();
        $course_id = self::find($this->id)->GoalJson['next_course'];

    

        $link = "$domain/courses/$course_id/access";

        return $link;  
    }

    public function is_free()
    {
        return $this->price == 0;
    }


    public static function star_rating($rate,  $scale)
    {
        $stars = '';
        for ($i=1; $i <= $scale ; $i++) { 
                if ($i <= $rate) {
                    $stars .= "<i class='fa fa-star'></i>";
                }else{
                    $stars .= "<i class='fa fa-star-o'></i>";
                }
        }

        $point = number_format(($rate), 1);
        $stars .= " (<b>$point</b>)";
        $star_rating = compact('rate', 'scale', 'stars', 'point');

        return $star_rating;
    }



    public function quickview()
    {

        $currency = Config::currency();
        $price = MIS::money_format($this->price);
        $by = ($this->instructor == null)? '' : "By {$this->instructor->fullname} ";

        $aim = '';

            foreach ($this->GoalJson['aims'] as $key => $value) {
                $aim .= "<li>$value</li>";
            }

        $last_updated = date("M j, Y h:iA" , strtotime($this->updated_at));
        $quickview = "
            <small>Last updated -{$last_updated}</small>
            <h5><b>{$this->title}</b></h5>
            <p> $this->primarily_taught | $this->category | $this->level</p>
            <p>$by <span style='margin-left: 30px;    font-weight: bold;    font-size: 25px;'> $currency$price</span>
            </p> 
            <hr>

            <p>$this->description</p>
            <ul>
                $aim
            </ul>
         
          ";

          return $quickview;
    }

    public function scopeFree($query)
    {
        return $query->where('price', 0);
    }

    


    public function getViewLinkAttribute()
    {
        $domain = Config::domain();

        $url_friendly = MIS::encode_for_url($this->title);
        $singlelink = "$domain/shop/full-view/$this->id/course/$url_friendly";

        return $singlelink;  
    }


    public function tax_breakdown()
    {
        $tax = new Tax;
        $tax_payable  = $tax->setTaxSystem('general_tax');
         return $tax->setProduct($this)->setTaxStyleOnPrice('tax_exclusive')
         ->calculateApplicableTax()->amount_taxable
         ;

    }

    public function market_details()
    {

        $domain = Config::domain();
        $thumbnail = "$domain/$this->imageJson";

        $offers_available = ($this->OffersAvailable->isEmpty()) ? [] : $this->OffersAvailable->keyBy('id');

        foreach ($offers_available as $key => $offer) {
            $offer->details_array = $offer->DetailsArray;
        }


        $market_details = [
            'id' => $this->id,
            'model' => self::class,
            'name' => $this->title,
            'short_name' => substr($this->title, 0, 34),
            'description' => $this->description,
            'short_description' => substr($this->description, 0, 50).'...',
            'quick_description' => substr($this->description, 0, 250).'...',
            'price' => $this->price,
            'old_price' => $this->old_price,
            'by' => ($this->instructor == null)? '' : "By {$this->instructor->fullname}",
            'star_rating' => self::star_rating(4, 5),
            'quickview' =>  $this->quickview(),
            'single_link' =>  $this->ViewLink,
            'thumbnail' =>  $thumbnail,
            'unique_name' =>  'course',  // this name is used to identify this item in cart and at delivery
            'offers_available' =>  $offers_available,
            'pricing_style' =>  'tax_exclusive',
        ];

        return $market_details;
    }   


    public function is_editable()
    {
        $editable  = ['Draft', 'Denied' ];

        if (in_array($this->status, $editable)) {
            return true;
        }
            return false;

    }


    //market approval status
    public function getApprovalStatusAttribute()
    {

          $last_submission =  Market::where('category', $this::$category_in_market)
                            ->where('item_id', $this->id)
                            ->latest()
                            ->first();

            if ($last_submission == null) {
                return "<span class='badge badge-sm badge-dark'>Drafting</span>";
            }

            switch ($last_submission->approval_status) {
            case 2:
                $status = "<span class='badge badge-sm badge-success'>Approved</span>";
                break;
            
            case 1:
                $status = "<span class='badge badge-sm badge-warning'>In review</span>";
                break;
        
            case 0:
                $status = "<span class='badge badge-sm badge-danger'>Declined</span>";
                break;

            case null:
            $status = "<span class='badge badge-sm badge-info'>unknown</span>";
            break;
        
            
            default:
                # code...
                break;
        }

        return $status;

    }


    public static function approved()
    {
        return self::where('status', 'Approved');
    }

    public static function in_review()
    {
        return self::where('status', 'In review');
    }


    public  static function draft()
    {
        return self::where('status', 'Draft');
    }


    public  static function denied()
    {
        return self::where('status', 'Denied');
    }







    //to be worked on
    public function is_ready_for_review()
    {
       $required =  [                   'goal',
                                        'curriculum',
                                        'title',
                                        'price',
                                        'description',
                                        'primarily_taught',
                                        'level',
                                        // 'image',
                                    ];

        foreach ($required as $field) {
            if ($this->$field == null) {

                if ($field== 'price') {
                    return true;
                }
                return false;
            }
        }


        return true ;
    }



    public function enrolments()
    {
        return    Enrolment::where('course_id', $this->id);
    }


    public function instructor()
    {
        return $this->belongsTo('User', 'instructor_id');
    }


    public function category()
    {
        return $this->belongsTo('Category', 'category_id');

    }

    public function getCurriculumJsonAttribute()
    {
        $value = $this->curriculum;
        if (is_iterable($value)) {
            return $value;
        }

        return json_decode($value, true);
    }

    public function getGoalJsonAttribute()
    {
        $value = $this->goal;
        if (is_iterable($value)) {
            return $value;
        }

        return json_decode($value, true);
    }


    public function getimageJsonAttribute()
    {   
        $value = $this->image;


        if ((!is_dir($value))  && (file_exists($value))) {

            return ($value);
        }

        return 'uploads/images/courses/course_image.jpeg';
    }





}


















?>