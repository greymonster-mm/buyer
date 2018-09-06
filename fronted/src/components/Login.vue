<template>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
	<Card>
	    <div style="text-align:center">
	        <Form class="form-horizontal"  ref="formInline" :lable-width="100" :model="formInline" :rules="ruleInline">
		        <div class="form-group">
		        	<div class="col-md-6 col-md-offset-3">
						<FormItem prop="user">
				            <Input  type="text" v-model="formInline.user" placeholder="Username">
				                <Icon type="ios-person-outline" slot="prepend"></Icon>
				            </Input>
			        	</FormItem>
		        	</div>
					<div class="col-md-3"></div>
				</div>

		        <div class="form-group">
			        <div class="col-md-6 col-md-offset-3">
						 <FormItem prop="password">
				            <Input  type="password" v-model="formInline.password" placeholder="Password">
				                <Icon type="ios-locked-outline" slot="prepend"></Icon>
				            </Input>
			        	</FormItem>
			        </div>
					<div class="col-md-3"></div>
				</div>

		       <div class="form-group">
			        <div class="col-md-12">
						 <FormItem>
			            	<Button class="btn btn-default" type="primary" @click="handleSubmit('formInline')">登陆</Button>
			       	 	</FormItem>
		       	    </div>
				</div>
		    </Form>
	    </div>
	</Card>
	</div>
</div>
</template>

<script scoped>

export default {
  name: 'Frame',
  data :function()  {
    return {
    	false: false,
    	lableWidth: 100,
    	formInline: {
                    user: '',
                    password: ''
                },
        ruleInline: {
            user: [
                { required: true, message: '用户名必填！', trigger: 'blur' }
            ],
            password: [
                { required: true, message: '密码必填！', trigger: 'blur' },
                { type: 'string', min: 1, message: 'The password length cannot be less than 1 bits', trigger: 'blur' }
            ]
        }
    }
  },
  filters: {

  },
  methods: {
    handleSubmit(name) {
        var that = this
        that.$refs[name].validate((valid) => {
            if (valid) {
            	var username = that.formInline.user
            	var password = that.formInline.password
            	that._httpRequest({'url': 'auth', 'params' :{'username': username, 'password': password}}).then(function (result)
			  	{
			        if (!result.data)
			        {
			        	that.$Message.error('用户名或者密码错误！')
			            return
			        }
			        that.$Message.success('登陆成功！')
			        localStorage.setItem("access_token",JSON.stringify(result.data.access_token))
			        that.$router.push({ name: 'GoodsList'})
			        //that.$router.go(0)
			    },function(error){})
            } else {
                that.$Message.error('用户名密码必填!')
            }
        })
    }
  },
  mounted : function(){
  },
  watch: {
   }
}
</script>

<style>

</style>
