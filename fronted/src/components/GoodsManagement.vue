<template>
	   <div class="row">
	     <!--这里是路径导航-->
	     <div class="col-md-2 col-xs-1 text-center" >
			    <Menu theme="light" width="auto" :active-name="activeName" @on-select="changeSection">
			            <MenuItem name="goods_writing">
			                	添加商品
			            </MenuItem>
			            <MenuItem name="goods_edit"  v-show="this.section == 'goods_edit'">
			                	编辑商品
			            </MenuItem>
			            <MenuItem name="goods_manager" >
			                	商品管理
			            </MenuItem>
			        </MenuGroup>
			    </Menu>
	     </div>

	     <div class="col-md-10 col-xs-11">
	     	<section v-show="this.section == 'goods_writing'">
	     		<goods_writing></goods_writing>
	     	</section>
	     	<section v-show="this.section == 'goods_manager'">
	     	<goods_manager @edit_good="change2edit" :id="id"></goods_manager>
	     	</section>
	     	<section v-show="this.section == 'goods_edit'">
	     	<goods_edit  :id="id"></goods_edit>
	     	</section>
	     </div>
	   </div>
</template>

<script>
var Util =  require('../tools/util')
import goods_writing from './manager/goods_writing'
import goods_manager from './manager/goods_manager'
import goods_edit from './manager/goods_edit'

export default {
  name: 'Manager',
  data: function() {
    return {
    	section: 'goods_manager',
    	id: 0,
    	activeName: 'goods_manager',
    }
  },
  filters: {

  },
  methods: {
	  changeSection: function(name){
	  	this.section = name
	  	this.activeName = name
	  },
	  change2edit: function(id){
	  	this.section = 'goods_edit'
	  	this.activeName = 'goods_edit'
	  	this.id = id
	  }

   },
   mounted : function(){

   },
   watch: {
    '$route':function (to, from) {

    }
   },
   components:{
   	'goods_writing':goods_writing,
   	'goods_manager':goods_manager,
   	'goods_edit':goods_edit,
   }

}
</script>

