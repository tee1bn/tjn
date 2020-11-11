<?php


/**
 */
class ProductsController extends controller
{


    public function __construct()
    {
        // $this->middleware('administrator')->mustbe_loggedin();

    }


    public function mark_as_complete($order_id = '')
    {
        $order = Orders::find($order_id);
        $order->mark_paid();
        Session::putFlash("success", "Marked Paid Successfully.");
        Redirect::back();

    }

    public function deleteProduct($product_id)
    {


        echo "delete()$product_id";

        $product = Products::find($product_id);

        if ($product !== null) {

            try {
                //delete file from server
                $handle = new Upload($product->front_image);
                $handle->clean();

                $product->delete();

                echo "deleted";
                Session::putFlash('success', 'succesfully deleted!');


            } catch (Exception $e) {

                print_r($e->getMessage());
                Session::putFlash('info', 'This product cannot be deleted');


            }
        }

        Redirect::to('admin/products');


    }

    public function pausePlayProduct($product_id)
    {

        $product = Products::find($product_id);
        if ($product->on_sale == 0) {

            $product->update(['on_sale' => 1]);
            Session::putFlash('success', 'Item put on sale successfully');

        } else {
            $product->update(['on_sale' => 0]);
            Session::putFlash('success', 'Item removed from sale successfully');

        }


        Redirect::to('admin/products');


    }


    public function viewProduct($product_id)
    {

        echo $product = Products::find($product_id);

        Redirect::to('admin-products');


    }

    public function add_product()
    {


        $product = Products::create([]);


        Redirect::to("admin-products/edit_item/{$product->id}");


    }

    public function fetch($product_id)
    {
        $product = Products::find($product_id);

        $product->cover = $product->CoverArray['file'] ?? [];
        $product->content = $product->FilesArray['file'] ?? [];
        $product->extra_details = $product->ExtraDetailsArray ?? [];

        // json_encode($pro)
        header("Content-Type:application/json");
        echo json_encode([
            'product'=> $product
        ]);


    }

    public function update_product($publish=0)
    {
        echo "<pre>";
        print_r($_REQUEST);

        // return;

        // print_r($_FILES);

        $product_form = json_decode($_POST['product_form'], true);
        $product = $product_form['$product'];

        $db_product = Products::find($product['id']);
        $domain = Config::domain();


        $cover = MIS::refine_multiple_files($_FILES['cover']);
        $content = MIS::refine_multiple_files($_FILES['content']);

        $cover_array = $product['cover'];

        $cover_path_map = [];
        foreach ($cover_array as $key => $map) {
            if (isset($map['delete'])) {
                //delete this file


            }elseif (isset($cover[$key]) && ($map['src'] == 'local') ) {
                //upload
                $file = $cover[$key];
                $upload = Products::upload_file([$file], true, $db_product)['file'][0];


                $cover_path_map[] =  [
                    'file_path' => $upload['file_path'],
                    'file_type' => $upload['type']
                ]; 


            }elseif (isset($map['file']) && ($map['src'] == 'external') ) {

                $get_content = file_get_contents($map['file_path']);
                $headers = array_map(function($header){
                    $explode = explode(":", $header);

                    return [
                        'key' => $explode[0],
                        'value' => $explode[1],
                    ];
                }, $http_response_header);

                $headers_obj = collect($headers);

                $mime = $headers_obj->keyBy('key')['Content-Type']['value'];
                $type =  explode("/", $mime)[0];


                $cover_path_map[] =  [
                    'file_path' => $map['file_path'],
                    'file_type' => $map['file_type']
                ]; 
            }else{

                $path = explode("$domain/", $map['file_path'])[1];


                $cover_path_map[] =  [
                    'file_path' => $path,
                    'file_type' => $map['file_type']
                ]; 

            }

        }

        $content_array = $product['content'];
        print_r($product);
        print_r($content);

        $content_path_map = [];
        $after_purchase_link = $product['extra_details']['after_purchase_link'];
        foreach ($content_array as $key => $map) {
            if (isset($map['delete'])) {
                //delete this file


            }elseif (isset($content[$key]) ) {
                if ($after_purchase_link) {
                    continue;
                }

                //upload
                $file = $content[$key];
                $upload = Products::upload_file([$file], true, $db_product)['file'][0];


                $content_path_map[] =  [
                    'file_path' => $upload['file_path'],
                    'file_type' => $upload['type'],
                    'file' => $file,
                    'name' => $content_array['name'],
                    'description' => $content_array['description'],
                ]; 


            }else{

                $path = explode("$domain/", $map['file_path'])[1];

                $content_path_map[] =  [
                    'file_path' => $path,
                    'file' => $map['file'],
                    // 'file_type' => $map['file_type'],
                    'name' => $map['name'],
                    'description' => $map['description'],
                ]; 

            }

            echo "here";
        }


        print_r($content_path_map);   

        // return;
        $db_product->update([
            'extra_details' => json_encode($product['extra_details']),
            'cover' => json_encode(['file' => $cover_path_map]),
            'downloadable_files' => json_encode(['file' => $content_path_map]),
            'extra_details' => json_encode($product['extra_details']),
            'name' => $product['name'],
            'description' => $product['description'],
            'price' => $product['price'],
        ]);



    }


    public function update_item($publish = 0)
    {
        echo "<pre>";
        $product = Products::find(Input::get('item_id'));
        // print_r($product->toArray());
        print_r($_POST);
        print_r($_FILES);

        $update = $product->update_product(
            $_POST,
            $_FILES['cover'],
            $_FILES['content']);
        // Redirect::back();
    }


    public function createProduct()
    {

        if (Input::exists('add_products') || true) {

            // print_r($_FILES['front_image']);


            $this->validator()->check(Input::all(), array(

                'name' => [

                    'required' => true,
                    'min' => 2,
                    'unique' => 'Products',
                ],
                'price' => [

                    'required' => true,
                    'min' => 1,
                    'max' => 20,
                    'numeric' => true,
                ],

                'description' => [

                    'required' => true,
                    'min' => 4,
                ]
            ));

            if ($this->validator->passed()) {

                echo "paseed";
                print_r($_FILES);

                $product_images = (Products::upload_product_images($_FILES['front_image']));

                //upload the feaured_img;
                if (count($product_images['images']) != 0) {

                    $product = Products::create([
                        'name' => Input::get('name'),
                        'description' => Input::get('description'),
                        'old_price' => Input::get('old_price'),
                        'price' => Input::get('price'),
                        'category_id' => Input::get('category'),
                        'front_image' => json_encode($product_images)
                    ]);

                    Session::putFlash('success', "Item created successfully!");

                } else {

                    Session::putFlash('info', "Please check the images and try again!");
                    Redirect::back();
                }


            } else {

                print_r($this->validator->errors());


            }

        }

        Redirect::to('admin-products');
    }


    public function upload_item_image($item)
    {


        $handle = new Upload($item);
        $dir = 'uploads/images/products';

        $min_height = 335;
        $min_width = 270;

        echo $handle->image_src_x;

        if (($handle->image_src_x < $min_width) || ($handle->image_src_y < $min_height)) {

            Session::putFlash('Info', "Item image must be or atleast {$min_width}px min width x {$min_height}px min height for best fit!");

            Redirect::to('admin-products');
        }

        $handle->file_safe_name = true;

        $handle->process($dir);

        $front_image_path = $dir . '/' . $handle->file_src_name;

        if ($handle->processed) {
            return $front_image_path;

        } else {
        }
    }


    public function edit_item($item_id)
    {

        $products = Products::find($item_id);
        $this->view('admin/edit-item', ['item' => $products]);
    }


    public function index()
    {

        $products = Products::all();
        $this->view('admin/product', ['products' => $products]);
    }


}


?>