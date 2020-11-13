export function FilePreviewer($files, $index, $sce=null) {
    this.$files = $files;
    this.$index = $index;
    this.$current_file = $files[$index];

    if ($sce != null) {
        this.$files.map(function($file){
             $file.file_path  = $sce.trustAsResourceUrl($file.file_path);
             return $file;
        });
    }

    this.next = function() {

        if ((this.$index + 1) == this.$files.length) {
            // this.$index = -1;
            return;
        }

        this.$index++;
        this.update_current_file();
    };

    this.back = function() {

        if ((this.$index) == 0) {
            // this.$index = this.$files.length;
            return;
        }

        this.$index--;
        this.update_current_file();
    };

    this.update_current_file = function() {
        this.$current_file = this.$files[this.$index];
        // console.log(this);
    };

    this.setCurrentIndex =function($index){
        this.$current_file = this.$files[$index];
    }
}