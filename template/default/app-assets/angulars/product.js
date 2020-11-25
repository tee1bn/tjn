
class Content {
    file = {};
    file_path = "";
    name = "first";
    detail_pad = false;
    description = "first decription image";

    constructor($object) {
        for (let x in $object) {
            this[x] = $object[x];
        }
    }

    setUp($data){
       this.file = $data.file;
       this.file_path = $data.file_path;
       this.name = $data.name;
       this.detail_pad = false;
       this.description = $data.description;
       return this;
    }

    get extension() {
        if (typeof this.file.name === 'undefined') {
            return '';
        }
        let name = this.file.name;
        let ext = name.split('.').pop();
        return ext;
    }


    toggleDetailPad() {
        if (this.detail_pad == false) {
            this.detail_pad = true;
        } else {
            this.detail_pad = false;
        }
    }

    get filesize() {
        if (typeof this.file.size === 'undefined') {
            return '';
        }

        let $fileSize = this.file.size;
        let $sizes = ["TB", "GB", "MB", "KB", "B"];


        let $total = ($sizes).length;
        while ($total-- && $fileSize > 1024) {
            $fileSize /= 1024;
        }

        return $fileSize.toFixed(2) + " " + $sizes[$total];
    }

}

class Product {


    id  ;
    name = 'how to laff';
    description = 'description is here';
    cover = [{
            'file_path': "https://images.unsplash.com/photo-1527342726932-1d392fcdd316?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max",
            'file_type': "image",
            'src': "local",
        }
        /*,
            {
              'file_path': "https://resources.finalsite.net/images/f_auto,q_auto,t_image_size_2/v1548086771/holychildacademy/wdqethkyrdmodyvzzqui/finearts.png",
              'file_type': "image",
              'src': "external",
            },*/
    ];
    content = [
        /*
            new Content,

            new Content({
              'file': {},
              'file_path': "",
              'name': "second",
              'detail_pad': true,
              'description': "second decription image",
            }),*/

    ];



    price = 200;



    setUp($data) {
        this.name = $data.name;
        this.category_id = $data.category_id;
        this.description = $data.description;
        this.price = parseInt($data.price);
        this.cover = $data.cover;
        this.extra_details =  $data.extra_details;
        this.id = $data.id;

        this.content = $data.content.map(function(content) {
            let active_content = new Content;
            active_content.setUp(content);
            return active_content;
        });



    }

}




class ProductForm {


    $product;


    cover_pad = {
        'show': '',
        'src': 'local',
        'file': {},
        'embed_link': ""
    };

    file_pad = {
        'show': '',
        'src': 'local',
        'file': {},
        'embed_link': ""
    };



    constructor() {

    }

    hideContentPad(){
        return this.$product.content.length == 1;
    }


    save($publish = 0) {

        var $form = new FormData();
        $form.append('product_form', angular.toJson(this));

        for (var i = 0; i < this.$product.cover.length; i++) {
            let $cover = this.$product.cover[i];
            $form.append(`cover[${i}]`, $cover.file);
        }

        for (var i = 0; i < this.$product.content.length; i++) {
            let $content = this.$product.content[i];
            $form.append(`content[${i}]`, $content.file);
        }


        $form.append('publish', $publish);
        $("#page_preloader").css('display', 'block');

        $.ajax({
            type: "POST",
            url: $base_url + "/product/update_product",
            cache: false,
            contentType: false,
            processData: false,
            data: $form,
            async: true,
            headers: {
                "cache-control": "no-cache"
            },
            success: function(data) {
                $("#page_preloader").css('display', 'none');
                // $scope.fetch_page_content();
                window.notify();
            },
            error: function(data) {
                $("#page_preloader").css('display', 'none');
            }

        });
    }

    submit() {}



    afterPurchaseLink() {
        this.$product.extra_details.after_purchase_link_validity = false;
    }

    deleteCover($file) {

        for (var i = 0; i < this.$product.cover.length; i++) {
            let $cover = this.$product.cover[i];
            if ($file == $cover) {
                this.$product.cover.splice(i, 1);
                break;
            }
        }
    }

    deleteFile($file) {

        for (var i = 0; i < this.$product.content.length; i++) {
            let $content = this.$product.content[i];
            if ($file == $content) {
                this.$product.content.splice(i, 1);
                break;
            }
        }
    }

    loadDeliveryLink() {
        let $link = this.$product.extra_details.after_purchase_link;
        let $test = true;
        if ($test) {
            this.$product.extra_details.after_purchase_link_validity = true;
        } else {

            this.$product.extra_details.after_purchase_link_validity = false;
        }
    }


    determineLinkType($link){
        let embeddable_links = ['youtube', 'youtu.be', 'vimeo'];
        let $type = 'image';

        for (var i = 0; i < embeddable_links.length; i++) {
           let substr =  embeddable_links[i];

           if ($link.includes(substr)) {
             $type = 'video';
             break;
           }
        }

        return $type;
    }


    loadEmbedLink() {
        let $link = this.cover_pad.embed_link;

        let $type = this.determineLinkType($link);

        let $src = this.cover_pad.src;
        let $cover = {
            'file_path': $link,
            'file_type': $type,
            'src': $src,
            'file': {},
        }

        this.cover_pad.embed_link = '';
        this.$product.cover.push($cover);
        angular.element($('#content')).scope().$apply();

        this.cover_pad.embed_link='';        
    }



    processCoverPad($input) {
        if (!$input.files) { return; }

        for (var i = 0; i < $input.files.length; i++) {
            let $file = $input.files[i];
            let $src = this.cover_pad.src;

            let $type = $file.type.split('/')[0];

            let $cover = {
                'file_path': URL.createObjectURL($file),
                'file_type': $type,
                'src': $src,
                'file': $file,
            }

            this.$product.cover.push($cover);
            angular.element($('#content')).scope().$apply();

        }
    }

    processFilePad($input) {
        if (!$input.files) { return; }

        for (var i = 0; i < $input.files.length; i++) {
            let $file = $input.files[i];
            let $src = this.cover_pad.src;

            let $type = $file.type.split('/')[0];

            let $content = new Content({
                'file': $file,
                'file_path': URL.createObjectURL($file),
                'name': $file.name,
                'detail_pad': false,
                'description': "first decription image"
            });

            this.$product.content.push($content);
            angular.element($('#content')).scope().$apply();

        }
    }


    setCoverPadSrc($src) {
        this.cover_pad.src = $src;
    }

    setFilePadSrc($src) {
        this.file_pad.src = $src;
        this.$product.extra_details.delivery_method = $src;
    }



    toggleCoverPad() {
        if (this.cover_pad.show == 'show') {
            this.cover_pad.show = '';
        } else {
            this.cover_pad.show = 'show';
        }
    }


    setProduct($product) {
        this.$product = $product;
    }

}




app.controller('ProductController', function($scope, $http) {



    $scope.load = function() {
        $http.get(`${$base_url}/product/fetch/${$product_id}`)
            .then(function(response) {
                var $product_data = response.data.product;
                $scope.categories = response.data.categories;

                var $product = new Product;
                $product.setUp($product_data);

                $scope.$product_form = new ProductForm;
                $scope.$product_form.setProduct($product);


                // angular.element($('#content')).scope().$apply();
                // console.log(response);

            });
    };


    $scope.load();



});




app.directive('ckEditor', function() {
    return {
        require: '?ngModel',
        link: function(scope, elm, attr, ngModel) {


            var ck = CKEDITOR.replace(elm[0], {

                filebrowserBrowseUrl: `${$base_url}/uploads/media`,
                filebrowserImageBrowseUrl: `${$base_url}/uploads/media?type=Images`,
                filebrowserUploadUrl: `${$base_url}/media/upload/files`,
                filebrowserImageUploadUrl: `${$base_url}/media/upload/image`
            });

            if (!ngModel) return;

            ck.on('pasteState', function() {
                scope.$apply(function() {
                    ngModel.$setViewValue(ck.getData());
                });
            });

            ngModel.$render = function(value) {
                ck.setData(ngModel.$viewValue);

            };
                   scope.$apply();
        }


    };
});







app.filter('replace', [function() {

    return function(input, from, to) {

        if (input === undefined) {
            return;
        }

        var regex = new RegExp(from, 'g');
        return input.replace(regex, to);

    };


}]);




app.directive("contenteditable", function() {
    return {
        restrict: "A",
        require: "ngModel",
        link: function(scope, element, attrs, ngModel) {

            function read() {
                ngModel.$setViewValue(element.html());
            }

            ngModel.$render = function() {
                element.html(ngModel.$viewValue || "");
            };

            element.bind("blur keyup change", function() {
                scope.$apply(read);
            });
        }
    };
});