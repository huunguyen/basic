var Lock = function () {

    return {
        //main function to initiate the module
        init: function () {

             $.backstretch([
		        assetsBase+"/admin/pages/media/bg/1.jpg",
    		        assetsBase+"/admin/pages/media/bg/2.jpg",
                        assetsBase+"/admin/pages/media/bg/3.jpg",
                        assetsBase+"/admin/pages/media/bg/4.jpg"
		        ], {
		          fade: 1000,
		          duration: 8000
		      });
        }

    };

}();