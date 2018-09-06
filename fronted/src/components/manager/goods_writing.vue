<template>

<Row>
	<Col span="16" offset="4" >
	    <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="120">
	        <FormItem label="品牌" prop="brand">
	            <Input v-model="formValidate.brand" placeholder="请输入产品的品牌 比如 雅诗兰黛"></Input>
	        </FormItem>
	        <FormItem label="产品名称" prop="product_name">
	            <Input v-model="formValidate.product_name" placeholder="请输入产品名称 比如 爽肤水"></Input>
	        </FormItem>
	        <FormItem required label="产品分类" prop="category" >
	        	<Tree :data=categorys accordion ref="tree" :multiple=tree_multi  @on-select-change="select_category"></Tree>
	        </FormItem>
	        <FormItem label="个人描述" prop="description">
	            <Input v-model="formValidate.description" placeholder="请输入个人对产品的描述"></Input>
	        </FormItem>

		    <FormItem label="复制来的描述" prop="ad_copy">
	            <Input v-model="formValidate.ad_copy" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="复制广告中的描述"></Input>
	        </FormItem>
		    <FormItem label="价格" prop="price">
		    	<Input type="number" v-model="formValidate.price"  placeholder="请输入价格"></Input>
	        </FormItem>
	        <FormItem label="自己售价" prop="other_price">
	       		<Input type="number" v-model="formValidate.suggested_price"  placeholder="请输入自己对该商品的售价（不输入默认为价格）"></Input>
	        </FormItem>
	        <FormItem label="参考价" prop="suggested_price">
	        	<Input type="number" v-model="formValidate.other_price"  placeholder="请输入淘宝／京东 等其他平台售价（参考）"></Input>
	        </FormItem>

	       <FormItem label="图片" prop="image1">

			    <div class="demo-upload-list" v-for="item in uploadList">
			        <template v-if="item.status === 'finished'">
			            <img :src="item.url">
			            <div class="demo-upload-list-cover">
			                <Icon type="ios-eye-outline" @click.native="handleView(item.url)"></Icon>
			                <Icon type="ios-trash-outline" @click.native="handleRemove(item)"></Icon>
			            </div>
			        </template>
			        <template v-else>
			            <Progress v-if="item.showProgress" :percent="item.percentage" hide-info></Progress>
			        </template>
			    </div>
			    <Upload
			        ref="upload"
			        :show-upload-list="false"
			        :on-success="handleSuccess"
			        :format="['jpg','jpeg','png']"
			        :max-size="2048"
			        :on-format-error="handleFormatError"
			        :on-exceeded-size="handleMaxSize"
			        :before-upload="handleBeforeUpload"
			        multiple
			        type="drag"
			        v-bind:action="action"
			        style="display: inline-block;width:58px;">
			        <div style="width: 58px;height:58px;line-height: 58px;">
			            <Icon type="camera" size="20"></Icon>
			        </div>
			    </Upload>

			    <Modal title="View Image" v-model="visible">
			        <img :src="view_url" v-if="visible" style="width: 100%">
			    </Modal>
			 </FormItem>

	        <FormItem label="该商品是否有效" prop="if_valid">
		        <i-switch v-model="formValidate.if_valid" size="large">
			        <span slot="open">开</span>
			        <span slot="close">关</span>
			    </i-switch>
	        </FormItem>
	        <div style="margin-left: 30%;">
	            <Button  @click="handleSubmit('formValidate')">提交</Button> &nbsp; &nbsp
	            <Button  @click="handleReset('formValidate')">清除</Button>
	        </div>
	    </Form>
	</Col>
</Row>

</template>



<script>
export default {
  name: 'goods_writing',
  data : function()  {
  	var validatePrice = (rule, value, callback) => {
        if (value < 1) {
          callback(new Error('请输入大于1的价格!'));
        }else {
          callback();
        }
      };
    var validateNameUnique = (rule, value, callback) => {
    	var params = {
		            'name': value,
		     	}
    	this._httpRequest({'url': 'checkProductName', 'params' : params}).then(function (result)
		  	    {
		          if (!result.data.exist)
		          {
		            callback(new Error('已经存在一个相同名称的产品！请另输入一个名字！或者修改已存在的产品！'));
		          }else
		          {
		          	callback();
		          }

		        },function(error){})
    };
    var validateCategory = (rule, value, callback) => {
        if (value == "") {
          callback(new Error('分类必须选一个!'));
        }else {
          callback();
        }
      };
    return {
    	 categorys: [],
    	 tree_multi:false,
    	 view_url:"",
    	 cid:0,
    	 formValidate: {
            brand: '',
            product_name: '',
            category: "",
            description: '',
            ad_copy: '',
            price: '',
            suggested_price: '',
            other_price: '',
            if_valid: true
        },
        ruleValidate: {
            brand: [
                { required: true, message: '品牌名必须填写！', trigger: 'blur' }
            ],
            product_name: [
                { required: true, message: '产品名称必须填写！', trigger: 'blur' },
                { validator: validateNameUnique, trigger: 'blur' },


            ],
            price: [
                { required: true, message: '产品价格必须填写！', trigger: 'blur' },
                { validator: validatePrice, trigger: 'blur' }
            ],
            category: [
            	{ validator: validateCategory, trigger: 'change' }
            ],
            ad_copy: [
                { required: true, message: '请一定输入一个产品描述！', trigger: 'blur' }
            ]

        },
	    imgName: '',
	    visible: false,
	    uploadList: []
    }
  },
  filters: {

  },
  methods: {
    handleReset: function (name)
    {
        this.$refs[name].resetFields();
        if(this.cid != 0)
     	{
     		this.cid = 0
     		this.$refs.tree.getSelectedNodes()[0].selected = false
     		this.formValidate['category'] = ""
     	}
     	this.$refs.upload.clearFiles();
    },
    handleSubmit (name) {
    	var check_img = this.$refs.upload.fileList;
    	var tmp = [];
    	var i = 0;
    	for(i = 0; i < check_img.length; i++)
    	{
    		if(check_img[i].status != 'finished')
    		{
    			alert('图片尚未上传完毕!请上传完毕后再添加!');
    			return false;
    		}
    	}
        this.$refs[name].validate((valid) => {
            if (valid) {
	            var that = this
		     	var params = {
		     		'brand': that.formValidate['brand'],
		            'product_name': that.formValidate['product_name'],
		            'category': that.formValidate['category'],
		            'description': that.formValidate['description'],
		            'ad_copy': that.formValidate['ad_copy'],
		            'price': that.formValidate['price'],
		            'suggested_price': that.formValidate['suggested_price'],
		            'other_price': that.formValidate['other_price'],
		            'if_valid': that.formValidate['if_valid'],
		            'images': that.$refs.upload.fileList
		     	}
		     	that._httpRequest({'url': 'addGood', 'params' : params}).then(function (result)
		  	    {
		          if (!result.code)
		          {
		            that.$Message.error(result.data)
		            //that.writing_clear()
		            return
		          }
		          that.$Message.success(result.data)
		          that.$router.push("GoodsList");

		        },function(error){})
            } else {
            	return false;
            }
        })
    },
	getCategoryTree: function(pid)
	{
  	  var that = this
  	  that._httpRequest({'url': 'getCategoryTree', 'params' :{'pid': pid, 'expand': false}}).then(function (result)
  	  {
        if (!result.code)
        {
          return
        }
        that.categorys = result.data
      },function(error){})
     },
     select_category: function()
     {
     	var nodes = this.$refs.tree.getSelectedNodes()
     	this.formValidate['category'] = nodes[0].cid
     	this.cid = (nodes[0].cid)
     },
     handleView (url) {
        this.view_url = url;
        this.visible = true;
    },
    handleRemove (file) {
        const fileList = this.$refs.upload.fileList;
        this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
    },
    handleSuccess (res, file) {
    	if(!res.code)
    	{
    		file.url = 'http://120.25.106.202/backend/' + res.data;
        	file.name = '7eb99afb9d5f317c912f08b5212fd69a';
    	}else
    	{
    		alert('失败！')
    	}

    },
    handleFormatError (file) {
        this.$Notice.warning({
            title: 'The file format is incorrect',
            desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
        });
    },
    handleMaxSize (file) {
        this.$Notice.warning({
            title: 'Exceeding file size limit',
            desc: 'File  ' + file.name + ' is too large, no more than 2M.'
        });
    },
    handleBeforeUpload (file) {
        const check = this.uploadList.length < 3;
        if (!check) {
            this.$Notice.warning({
                title: '最多能上传3张照片！多余照片将会被删掉！.'
            });
        }
        return check;
    }
   },
   mounted : function(){
		this.getCategoryTree(0)
		this.uploadList = this.$refs.upload.fileList;
		this.access_token = JSON.parse(localStorage.getItem("access_token"))
		this.action = "//120.25.106.202/backend/index.php?m=index&c=good&a=upload&access_token="+this.access_token
   },
   watch: {
    '$route':function (to, from) {

    }
   },
   components:{
   },

}
</script>

<style>
    .demo-upload-list{
        display: inline-block;
        width: 60px;
        height: 60px;
        text-align: center;
        line-height: 60px;
        border: 1px solid transparent;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
        position: relative;
        box-shadow: 0 1px 1px rgba(0,0,0,.2);
        margin-right: 4px;
    }
    .demo-upload-list img{
        width: 100%;
        height: 100%;
    }
    .demo-upload-list-cover{
        display: none;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,.6);
    }
    .demo-upload-list:hover .demo-upload-list-cover{
        display: block;
    }
    .demo-upload-list-cover i{
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        margin: 0 2px;
    }
</style>