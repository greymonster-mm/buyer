<template>
		<div>
			<Row>
			<Col span="24" >
		     <!--这里是路径导航-->
		     <div class="col-md-12" >
		         <ol class="breadcrumb">
		           <li><a @click="changeCategory(0)" href="#">Home</a></li>
		           <li v-for="pcat in parentCategory"><a @click="changeCategory(pcat.id)" href="#">{{ pcat.name }}</a></li>
		         </ol>
		     </div>
			</Col>


		   	<Col span="3" >
	            <Menu width="auto" theme="light" @on-select="changeCategory">
	            	<template v-for="cat in category">
			            <MenuItem :name="cat.id">
		                	{{ cat.name }}
		            	</MenuItem>
	            	 </template>
	            </Menu>
			</Col>

			<Col span="20" style="margin-left:2%">
				 <div v-show="ifSearch">
		     		 <Form ref="formValidate" :model="formValidate" inline >
				        <FormItem label="产品名" prop="product_name">
				            <Input v-model="formValidate.product_name" placeholder="请输入产品名搜索"></Input>
				        </FormItem>
				        <FormItem label="品牌" prop="brand">
				            <Input v-model="formValidate.brand" placeholder="请输入品牌搜索"></Input>
				        </FormItem>
				        <FormItem label="创建人" prop="creator">
				            <Input v-model="formValidate.creator" placeholder="请输入创建人搜索"></Input>
				        </FormItem>
				        <FormItem label="发送次数" prop="send_times">
				            <Input v-model="formValidate.send_times" type="number" placeholder="筛选出发布次数小于输入次数的商品"></Input>
				        </FormItem>
				        <FormItem label="价格不高于" prop="high">
				            <Input v-model="formValidate.high" type="number" placeholder="最高价"></Input>
				        </FormItem>
				        <FormItem label="价格不低于" prop="low">
				            <Input  v-model="formValidate.low" type="number" placeholder="最低价"></Input>
				        </FormItem>
				        <FormItem label="清除">
				        	<Button class="float-right" @click="handleReset('formValidate')">清除</Button>
				        </FormItem>
				        <FormItem label="搜索">
				        	<Button class="float-right" @click="handleSubmit('formValidate')">搜索</Button>
				        </FormItem>

			        </Form>
				</div>
				<div class="text-center">
					<Button  @click="changeSearch" v-show="!ifSearch">展开搜索项</Button>
					<Button  @click="changeSearch" v-show="ifSearch">隐藏搜索项</Button>
				</div>
				<hr>
				<Table :columns="columns11" :data="goodsInfos" border  ></Table>



				<div class="text-center">
					<el-pagination small layout="prev, pager, next" @current-change="handleCurrentChange" :total="total" :current-page.sync="currentPage" :page-size=size></el-pagination>
				</div>
			</Col>

				<Modal width="60%"
			        v-model="goodDetail">
			        <goods_detail :id="detailId"></goods_detail>
			        <div slot="footer">
			            <Button @click="goodDetail=false">关闭</Button>
			        </div>
			    </Modal>
		  </Row>
    </div>
</template>

<script>
var Util =  require('../tools/util')
import goods_detail from './Good'
export default {
  name: 'GoodsList',
  data :function()  {
    return {
    		ifSearch : false,
    		columns11:[
    				{
                        title: 'Id',
                        key: 'id',
                        fixed: 'left',
                        minWidth: 60
                    },
                    {
                        title: '品牌',
                        key: 'brand',
                        minWidth: 100
                    },
                    {
                        title: '产品名称',
                        key: 'product_name',
                        minWidth: 100
                    },
                    {
                        title: '分类',
                        key: 'cname',
                        minWidth: 100
                    },
                    {
                        title: '复制描述',
                        key: 'ad_copy',
                        minWidth: 280
                    },
                    {
                        title: '价格',
                        key: 'price',
                        minWidth: 100
                    },
                    {
                        title: '建议价格',
                        key: 'suggested_price',
                        minWidth: 100
                    },
                    {
                        title: '我的价格',
                        minWidth: 100,
                        key: 'other_price',
                    },
                    {
                        title: '添加人',
                        key: 'creator',
                        minWidth: 100
                    },
                    {
                        title: '添加时间',
                        key: 'ctime',
                        sortable: true,
                        minWidth: 140
                    },
                    {
                        title: '已发送次数',
                        key: 'send_times',
                        minWidth: 80
                    },
                    {
                        title: '操作',
                        key: 'action',
                        fixed: 'right',
                        minWidth: 80,
                        render: (h, params) => {
                            return h('div', [
                                h('Button', {
                                    props: {
                                        type: 'button',
                                        size: 'small'
                                    },on: {
                                        click: () => {
                                            this.view_detail(params.row.id)
                                        }
                                    }
                                }, '查看'),
                                h('Button', {
                                    props: {
                                        type: 'button',
                                        size: 'small'
                                    },on: {
                                        click: () => {
                                            this.addSendTimes(params.row.id)
                                        }
                                    }
                                }, '发送+1')
                            ]);
                        }
                    }
                ],

    goodDetail: false,
    detailId: 0,
     formValidate: {
            low: '',
            brand:'',
            product_name: '',
            high: "",
            creator: '',
            send_times: '',
            range:''
        },
      goodsInfos: [],
      total: 0,
      size:10,
      currentPage:1,
      category: '',
      parentCategory: '',
      cid:0,

    }
  },
  filters: {
  },
  methods: {
  	changeSearch: function()
  	{
  		this.ifSearch = !this.ifSearch;
  	},

  	view_detail: function(id)
  	{
  		this.goodDetail=true
  		this.detailId = id
  	},
    addSendTimes: function(id){
  	  var that = this
  	  that._httpRequest({'url': 'addSendTimes', 'params' :{'gid': id}}).then(function (result) {
        if (!result.code) {
          	that.$Message.error("失败！");
        }
        that.getGoodsIntro()
      },function(error){})
    },
  	handleReset: function (name)
    {
        this.$refs[name].resetFields();
 		this.cid = 0
 		this.getCategoryList(0)
 		this.getGoodsIntro()
    },

  	handleSubmit (name) {
  	console.log(this.formValidate.range);
		this.getGoodsIntro()
    },
    getCategoryList: function(pid){
  	  var that = this
  	  that._httpRequest({'url': 'getCategoryList', 'params' :{'pid': pid}}).then(function (result) {
        if (!result.code) {
          return
        }
        that.category = result.data
        that.getParentCategoryList(pid);
      },function(error){})
     },
     getParentCategoryList: function(cid){
  	  var that = this
  	  that._httpRequest({'url': 'getCategoryParents', 'params' :{'cid': cid}}).then(function (result) {
        if (!result.code) {
          return
        }
        that.parentCategory = result.data
      },function(error){})
     },
     changeCategory: function(pid){
        this.cid = pid
        this.getCategoryList(this.cid)
        this.getGoodsIntro()
     },
    getGoodsIntro :function(){
      var params = {
      		"category": this.cid,
      		"low": this.formValidate.low,
            "product_name": this.formValidate.product_name,
            "high": this.formValidate.high,
            "creator": this.formValidate.creator,
            "send_times": this.formValidate.send_times,
            "brand": this.formValidate.brand,
            "limit" : this.size,
            "page": this.currentPage
      }
      var that = this;
      that._httpRequest({'url': 'getGoodsIntro', 'params': params}).then(function (result) {
        if (!result.code) {
          return
        }
        that.goodsInfos = result.data.data
        that.total = result.data.total
      },function(error){})
     },
     handleCurrentChange : function()
     {
     	this.getGoodsIntro()
     }
   },
   mounted : function(){
   	  var params = {}
      this.getGoodsIntro({})
      this.getCategoryList(this.cid)
      this.getParentCategoryList(this.cid)
   },
   watch: {
    '$route':function (to, from) {
    }
   },
   components:{
   	'goods_detail':goods_detail,
   }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
