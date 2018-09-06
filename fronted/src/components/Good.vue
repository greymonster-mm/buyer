<template>
<div class="single">
		<div class="container">
			<div class="col-md-8">
				<div class="col-md-5 grid">
				<div class="flexslider">
					  <div class="slides">
                            <div class="thumb-image"> <img :src="showImg"  class="img-responsive"> </div>
                      </div>
                      <div class="slides">
                             <ol class="flex-control-nav flex-control-thumbs">
                                <li v-for="item in good.images"><img :src="item.img_path" @click="changeImg(item.img_path)" class="" draggable="false"></li>
                            </ol>
                      </div>
				</div>
				</div>
				<div class="col-md-7 single-top-in">
					<div class="simpleCart_shelfItem">
						<h1>{{ good.brand }}</h1>
						<hr>
						<h2>{{ good.product_name }}</h2>
						<hr>
						<p>{{ good.ad_copy }}</p>
					</div>
					<hr>
					<div >
						<label>Price: {{ good.price }}</label>
					</div>
				</div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
</template>

<script>
var Util =  require('../tools/util')

require("../../static/css/flexslider.css")


export default {
  name: 'Good',
  data: function() {
    return {
    	id: 0,
    	showImg : "",
    	good: {}
    }
  },
  filters: {

  },
  props: {
  	id:0
  },
  methods: {
  	  changeImg: function(img_path)
  	  {
  	  	this.showImg = img_path;
  	  },
	  getGood :function (){
	      var that = this;
	      if (that.id == 0) return
	      var params = {'id': that.id}
	      that._httpRequest({'url': 'getGood', 'params': params}).then(function (result) {
	        if (!result.code) {
	          return
	        }
	        if(result.data.description != "")
	        {
	        	result.data.ad_copy = result.data.description;
	        }
	        if(result.data.other_price != 0 && result.data.other_price != null)
	        {
	        	result.data.price = result.data.other_price;
	        }

	        that.good = result.data
			if(that.good.images)
			{
				that.showImg = that.good.images[0].img_path
			}
	      },function(error){})
     }

   },
   mounted : function(){
		//class="flex-active"


   },
   watch: {
    '$route':function (to, from) {},
    'id': function(to, from){
		this.getGood()
    }
   }


}
</script>


