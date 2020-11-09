function FilePreviewer($files, $index) {
  this.$files = $files;
  this.$index = $index;
  this.$current_file = $files[$index];


  this.next = function() {

    if ((this.$index + 1) == this.$files.length) {
      this.$index = -1;
      return;
    }

    this.$index++;
    this.update_current_file();
  };

  this.back = function() {

    if ((this.$index) == 0) {
      this.$index = this.$files.length;
      return;
    }

    this.$index--;
    this.update_current_file();
  };

  this.update_current_file = function() {
    this.$current_file = this.$files[this.$index];
    // console.log(this);
  };

}



class Product {

  name = 'how to laff';
  description = 'description is here';
  cover = [
    {
      'file_path': "https://images.unsplash.com/photo-1527342726932-1d392fcdd316?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max",
      'type': "image",
      'src': "local",
    },
    {
      'file_path': "https://resources.finalsite.net/images/f_auto,q_auto,t_image_size_2/v1548086771/holychildacademy/wdqethkyrdmodyvzzqui/finearts.png",
      'type': "image",
      'src': "external",
    },
  ];
  content = [
    {
      'file': {},
      'file_path': "",
      'name': "first",
      'detail_pad': true,
      'description': "first decription image",
    },

    {
      'file': {},
      'file_path': "",
      'name': "second",
      'detail_pad': true,
      'description': "second decription image",
    },

  ];

  price = 200;

  thank_you_note = "Well thank you for buying";
}


class ProductForm {

  $product;

  $scope = angular.element($('#content')).scope();

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

  loadEmbedLink() {
    let $link = this.cover_pad.embed_link;



    let $src = this.cover_pad.src;
    let $cover = {
      'file_path': $link,
      'type': 'video',
      'src': $src,
      'file': {},
    }

    this.$product.cover.push($cover);
    this.$scope.$apply();
  }

  processCoverPad($input) {
    if (!$input.files) { return; }

    for (var i = 0; i < $input.files.length; i++) {
      let $file = $input.files[i];
      let $src = this.cover_pad.src;

      let $type = $file.type.split('/')[0];

      let $cover = {
        'file_path': URL.createObjectURL($file),
        'type': $type,
        'src': $src,
        'file': $file,
      }

      this.$product.cover.push($cover);
      this.$scope.$apply();

    }
  }

  processFilePad($input) {
    if (!$input.files) { return; }

    for (var i = 0; i < $input.files.length; i++) {
      let $file = $input.files[i];
      let $src = this.cover_pad.src;

      let $type = $file.type.split('/')[0];

      let $cover = {
        'file_path': URL.createObjectURL($file),
        'type': $type,
        'src': $src,
        'file': $file,
      }

      this.$product.cover.push($cover);
      this.$scope.$apply();

    }
  }


  setCoverPadSrc($src) {
    this.cover_pad.src = $src;
  }

  setFilePadSrc($src) {
    this.file_pad.src = $src;
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


  $scope.$product_form = new ProductForm;
  $scope.$product_form.setProduct(new Product);


  $scope.fetch_payment_gateway_settings = function() {
    $http.get($base_url + "/settings/fetch_payment_gateway_settings/")
      .then(function(response) {
        $scope.$payment_gateway_settings = response.data;
      });
  };


  $scope.fetch_payment_gateway_settings();



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
    }


  };
});




app.directive("w3TestDirective", function() {

  return {
    template: "<h1>Made by a directive! {{user}}f {{ui}}</h1>",
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