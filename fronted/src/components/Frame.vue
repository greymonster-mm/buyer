<template>
<div>
	<header>
		<div class="float-right pull-right">
			<button type="button" class="btn btn-default btn-sm" @click="logout()">
			  <span class="glyphicon glyphicon-log-out" aria-hidden="true" ></span> 退出
			</button>
		</div>
	<!--这里是顶部导航栏-->
	     <div class="my-nav">
	     	<span><a href="#/GoodsList">商品列表</a></span>
	     	<span><a href="#/GoodsManagement">商品管理</a></span>
	     	<span><a href="#/CategoryManagement">分类管理</a></span>
	     	<span><a href="#/About">关于</a></span>

	     </div>

     </header>

     <hr>
     <content>
     	<router-view></router-view>
     </content>

   <footer class="footer">
	     <hr>
         <p>© Greymonster • 2018</p>
   </footer>

</div>
</template>

<script scoped>
 var Util =  require('../tools/util')

export default {
  name: 'Frame',
  data :function()  {
  },
  filters: {
  	formatDate: function(time) {
  		var date = new Date()
  		date.setTime(time * 1000)
  		return Util.formatDate(date, 'YYYY年MM月')
  	},
  },
  methods: {
	logout: function()
	{
		localStorage.removeItem("access_token");
		this.$router.push({ name: 'Login'})
		return false;
	}
  },
  mounted : function(){
  },
  watch: {
   }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
.top{
        padding: 10px;
        background: rgba(0, 153, 229, .7);
        color: #fff;
        text-align: center;
        border-radius: 2px;
    }
</style>
