<?php


/**
 */
class AdminProductsController extends controller
{


    public function __construct()
    {
        $this->middleware('administrator')->mustbe_loggedin();

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


    public function update_item()
    {
        echo "<pre>";


        $product = Products::find(Input::get('item_id'));


        print_r($product->toArray());
        print_r($_POST);
        print_r($_FILES);

        // return;

        $update = $product->update_product(
            $_POST,
            $_FILES['front_image'],
            $_FILES['downloadable_files']);

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