<?php


/**
 * this class is the default controller of our application,
 *
 */
class CmsApiController extends controller
{


    public function __construct()
    {

    }


    public function upload_files_for_third_section_img()
    {

        // print_r($_FILES);


        $directory = 'uploads/images/cms';
        $min_width = 400;
        $min_height = 400;

        $handle = new Upload($_FILES['files0']);
        $handle->file_safe_name = true;
        $handle->Process($directory);

        $path = $directory . '/' . $handle->file_dst_name;


        $home_page = CmsPages::where('page_unique_name', 'home_page')->first();
        $existing_content = json_decode($home_page->page_content, true);
        $old_file = new Upload($existing_content['third_section']['image']);

        $existing_content['third_section']['image'] = $path;

        $old_file->clean();

        echo " <pre>";
// print_r($existing_content);


        $new_update = json_encode($existing_content);
        // print_r($new_update);

        CmsPages::where('page_unique_name', 'home_page')->first()
            ->update(['page_content' => $new_update]);


    }


    public function upload_files_for_fourth_section_img()
    {

        print_r($_FILES);

        $directory = 'uploads/images/cms';
        $min_width = 400;
        $min_height = 400;

        $handle = new Upload($_FILES['files0']);
        $handle->file_safe_name = true;
        $handle->Process($directory);

        $path = $directory . '/' . $handle->file_dst_name;


        $home_page = CmsPages::where('page_unique_name', 'home_page')->first();
        $existing_content = json_decode($home_page->page_content, true);
        $old_file = new Upload($existing_content['fourth_section']['image']);

        $existing_content['fourth_section']['image'] = $path;

        $old_file->clean();

        echo " <pre>";
        print_r($existing_content);


        $new_update = json_encode($existing_content);
        // print_r($new_update);

        CmsPages::where('page_unique_name', 'home_page')->first()
            ->update(['page_content' => $new_update]);


    }

    public function upload_files_for_gallery()
    {


        echo "in here";
        // print_r($_POST);
        // print_r($_FILES);
        $directory = 'uploads/cms/gallery';
        $min_width = 400;
        $min_height = 400;

        foreach ($_FILES as $file) {
            $handle = new Upload($file);
            $handle->file_safe_name = true;
            $handle->Process($directory);


            $new_records[] = [
                'image_label' => 'New Label',
                'path' => $directory . '/' . $handle->file_dst_name
            ];

        }


        $galley_cms = CmsPages::where('page_unique_name', 'gallery_page')->first();
        $existing_content = json_decode($galley_cms->page_content, true);

        /*
                print_r($new_records);	
                print_r($existing_content);*/
        foreach ($new_records as $new_record) {
            array_unshift($existing_content, $new_record);
        }

        $new_update = json_encode($existing_content);
        print_r($new_update);
        CmsPages::where('page_unique_name', 'gallery_page')->first()
            ->update(['page_content' => $new_update]);
    }


    public function update_faqs($page_unique_name)
    {
        echo "<pre>";
// print_r($_POST['content']);
        $received = json_decode($_POST['content'], TRUE);

        foreach ($received as $key => $faq) {
            unset($received[$key]['$$hashKey']);
            if (($faq['question'] == '') && ($faq['answer'] == '')) {
                unset($received[$key]);
            }
        }
        print_r($received);
        $content = json_encode($received);

        $page_content = CmsPages::where('page_unique_name', $page_unique_name)->first();
        $page_content->update(['page_content' => $content]);
        // Session::putflash('','Faqs Updated Successfully');

    }


    public function update_terms($page_unique_name)
    {

        $content = $_POST['content'];

        $page_content = CmsPages::where('page_unique_name', $page_unique_name)->first();
        $page_content->update(['page_content' => $content]);
        // Session::putflash('','Terms Updated Successfully');
    }


    public function update_page_cms($page_unique_name)
    {
// print_r($_POST['content']);
        $received = json_decode($_POST['content'], TRUE);
        foreach ($received['fifth_section']['tiles'] as $key => $tile) {
            unset($received['fifth_section']['tiles'][$key]['$$hashKey']);
        }
        $content = json_encode($received);

        $page_content = CmsPages::where('page_unique_name', $page_unique_name)->first();
        $page_content->update(['page_content' => $content]);
        Session::putflash('', 'Updated Successfully');
    }


    public function fetch_page_content($page_unique_name)
    {
        header("content-type:application/json");
        $page_content = CmsPages::where('page_unique_name', $page_unique_name)->first();


        $test_specimen_is_array = is_array(json_decode($page_content->page_content, TRUE));
        if (!$test_specimen_is_array) {
            $content = (($page_content->default_page_content));
            return;
        }

        $content = (($page_content->page_content));

        $content_array = json_decode($content, true);

        // echo "<pre>";
        //to remove any haskey set bu angularjs
        foreach ($content_array as $key => $value) {

            // unset($content_array[$key]['$$hashKey']);


        }

        print_r(json_encode($content_array));

    }


    /**
     * this is the default landing point for all request to our application base domain
     * @return a view from the current active template use: Config::views_template()
     * to find out current template
     */
    public function index()
    {
        header("content-type:application/json");

        echo json_encode([

            ['main_text' => 'new arrivals',
                'sub_text' => 'Women collection',
                'slider_image' => 'uploads/cms/sliders/slider-01.jpg',
            ],

            ['main_text' => 'new trends',
                'sub_text' => 'men collection 2018',
                'slider_image' => 'uploads/cms/sliders/slider-02.jpg',
            ],

            ['main_text' => 'new season',
                'sub_text' => 'Bridal collection 2018',
                'slider_image' => 'uploads/cms/sliders/slider-03.jpg',
            ],

            ['main_text' => 'quality touch',
                'sub_text' => 'Fitted uniforms 2018',
                'slider_image' => 'uploads/cms/sliders/slider-04.jpg',
            ],


        ]);

    }


}


?>