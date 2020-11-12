export function FilePreviewer($files, $index) {
    this.$files = $files;
    this.$index = $index;
    this.$current_file = $files[$index];


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