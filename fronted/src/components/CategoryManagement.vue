<template>
<div class="row">
	<div class="col-md-8 col-md-offset-2 .col-xs-8 col-xs-offset-2">
	<form class="form-horizontal">
		<div class="form-group">
			<div>
				<label for="cat_tree">请点击编辑商品分类</label>
    				<Tree :data="category" :render="renderContent"></Tree>
	    	</div>
		</div>
		<div class="form-group">
			<div class="col-md-5 col-md-offset-5 col-xs-offset-3" >
				<input class="btn btn-default" type="submit" @click.self.prevent="writing_clear" value="清除">
				<input class="btn btn-default" type="submit" @click.self.prevent="writing_submit" value="提交">
			</div>
		</div>

	</form>
	</div>
</div>
</template>

<script>
export default {
  name: 'CategoryManager',
  data : function()  {
    return {
    	 category: [],
    	 tree_multi:false,
    	 cid:0,
    	 buttonProps: {
                    type: 'ghost',
                    size: 'small',
                },
         newCatName: ''
    }
  },
  filters: {

  },
  methods: {
	getCategoryTree: function(pid)
	{
  	  var that = this
  	  that._httpRequest({'url': 'getCategoryTree', 'params' :{'pid': pid, 'render': true}}).then(function (result)
  	  {
        if (!result.code)
        {
          return
        }

        var i = 0
        for(i; i<result.data.length; i++)
        {

        	result.data[i].render = (h, { root, node, data }) => {
                            return h('span', {
                                style: {
                                    display: 'inline-block',
                                    width: '100%'
                                }
                            }, [
                                h('span', [
                                    h('Icon', {
                                        props: {
                                            type: 'ios-folder-outline'
                                        },
                                        style: {
                                            marginRight: '8px'
                                        }
                                    }),
                                    h('span', data.title)
                                ]),
                                h('span', {
                                    style: {
                                        display: 'inline-block',
                                        float: 'right',
                                        marginRight: '32px'
                                    }
                                }, [
                                    h('Button', {
                                        props: Object.assign({}, that.buttonProps, {
                                            icon: 'ios-plus-empty',
                                            type: 'primary'
                                        }),
                                        style: {
			                                marginRight: '52px'
			                            },
                                        on: {
                                            click: () => { that.append(data) }
                                        }
                                    })
                                ])
                            ]);
                        }
        }
        that.category = result.data
      },function(error){})
     },
     renderContent (h, { root, node, data }) {
                return h('span', {
                    style: {
                        display: 'inline-block',
                        width: '100%'
                    }
                }, [
                    h('span', [
                        h('Icon', {
                            props: {
                                type: 'ios-paper-outline'
                            },
                            style: {
                                marginRight: '8px'
                            }
                        }),
                        h('span', data.title)
                    ]),
                    h('span', {
                        style: {
                            display: 'inline-block',
                            float: 'right',
                            marginRight: '32px'
                        }
                    }, [
                        h('Button', {
                            props: Object.assign({}, this.buttonProps, {
                                icon: 'ios-plus-empty'
                            }),
                            style: {
                                marginRight: '8px'
                            },
                            on: {
                                click: () => { this.append(data) }
                            }
                        }),
                        h('Button', {
                            props: Object.assign({}, this.buttonProps, {
                                icon: 'ios-minus-empty'
                            }),
                            on: {
                                click: () => { this.remove(root, node, data) }
                            }
                        })
                    ])
                ]);
            },
            append (data) {
            	var that = this
            	that.$Modal.confirm({
            		onOk: () => {
            		   that._httpRequest({'url': 'addCategoryTree', 'params' :{'pid': data.cid, 'name': that.newCatName}}).then(function (result)
					   {
					      if (!result.code)
					      {
					      	 that.newCatName = ""
					      	 that.$Message.error(result.data)
					         return
			              }
					      var new_id = result.data
						  const children = data.children || [];
		                  children.push({
		                    title: that.newCatName,
		                    expand: true,
		                    cid: new_id
		                  });
		                  that.$set(data, 'children', children);
		                  that.newCatName = ""
		                  that.$Message.success(result.data)

					    },function(error){})


            		},
            		onCancel: () => {

            		},
                    render: (h) => {
                        return h('Input', {
                            props: {
                                value: this.newCatName,
                                autofocus: true,
                                placeholder: '填写新分类的名称'
                            },
                            on: {
                                input: (val) => {
                                    that.newCatName = val;
                                },
                            }

                        })
                    }
                })


            },
            remove  (root, node, data) {
            	var that = this
            	that._httpRequest({'url': 'deleteCategoryTree', 'params' :{'cid': node.node.cid}}).then(function (result)
			  	{
			       if (!result.code)
			       {
			       	 that.$Message.error(result.data)
			         return
	               }
			       that.$Message.success(result.data)
				   const parentKey = root.find(el => el === node).parent;
                  	 const parent = root.find(el => el.nodeKey === parentKey).node;
                   	 const index = parent.children.indexOf(data);
                   	 parent.children.splice(index, 1);
			     },function(error){})

            },
   },
   mounted : function(){
		this.getCategoryTree(0)
   },
   watch: {
    '$route':function (to, from) {

    }
   }
}
</script>
