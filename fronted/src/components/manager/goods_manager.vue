<template>
<div class="col-md-12 col-xs-12">
<table id="goods" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
            	<th>图片</th>
                <th>id</th>
                <th>品牌</th>
                <th>产品名称</th>
                <th>分类</th>
                <th>复制的描述</th>
                <th>价格</th>
                <th>建议价格</th>
                <th>我的价格</th>
                <th>添加人</th>
                <th>添加时间</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            	<td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

        </tbody>
    </table>
</div>
</template>



<script>

require("../../../static/css/jquery.dataTables.min.css")
require("../../../static/css/dataTables.bootstrap.min.css")
import $ from 'jquery'
import datatables from '../../../static/js/jquery.dataTables.min.js'
//import category_manager from './manager/category_manager'


export default {
  name: 'goods_manager',
  data : function() {
    return {

    }
  },
  filters: {

  },
  methods: {

  },
  mounted : function(){
  	var that = this
  	$(document).ready(function() {
  		function plus_span ( d ) {
  			var imgs = d.images;
  			var i = 0;
  			var extra = "";
  			for(i = 0; i < imgs.length; i++)
  			{
  				extra +=  '<div><div class="col-xs-4 col-md-4"><a href="#" class="thumbnail"><img src="'+imgs[i].img_path+'" alt="..."></a></div></div>';
  			}

			return extra;


		    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
		        '</tr>'+
		            '<td> Intro : 13</td>'+
		        '</tr>'+
		    '</table>';
		}
   		var table = $('#goods').DataTable({
	    	//"searching": false,
	    	"lengthChange" :false,
	    	"process": true,
	    	"pagingType":   "full_numbers",
	    	"serverSide": true,
	    	"ordering": true,
	    	"ajax":{
	    		 "url": "/backend/index.php?m=index&c=good&a=getGoodsIntroDatatables",
            	 "type": "POST",
            	 "data": function ( d ) {
            	 	 if (localStorage.getItem("access_token"))
		             {
		            	d.access_token = JSON.parse(localStorage.getItem("access_token"))
		             }else
		             {
		             	that.$router.push({ name: 'Login'})
		             }

	              }
	    	 },
	         "columns": [
	         	{
	                "class":          'details-control',
	                "orderable":      false,
	                "data":           null,
	                "defaultContent": ''
	            },
	            { "data": "id" },
	            { "data": "brand" },
	            { "data": "product_name" },
	            { "data": "cname" },
	            { "data": "ad_copy" },
	            { "data": "price" },
	            { "data": "suggested_price" },
	            { "data": "other_price" },
	            { "data": "creator" ,"orderable": false},
	            { "data": "ctime" },
	            { "data": "" ,"orderable": false}
	        ],
	        "columnDefs": [ {
	            "targets": -1,
	            "data": null,
	            "defaultContent": '<button class="btn  btn-default edit_good">编辑</button>' +
	             				  '<button class="btn  btn-default delete_good">删除</button>'
	        } ],
	        "order": [[10, "desc" ]],
	        "language" : {
	        	"search":"按分类/商品名称搜索 : ",
	        },
	        initComplete: function(){
	        }
    	});


	    $('#goods tbody').on('click', 'td.details-control', function () {
	        var tr = $(this).closest('tr');
	        var row = table.row( tr );
	        if ( row.child.isShown() ) {
	            // This row is already open - close it
	            row.child.hide();
	            tr.removeClass('shown');
	        }
	        else {
	            // Open this row
	            row.child( plus_span(row.data()) ).show();
	            tr.addClass('shown');
	        }
	    });

	    table.on( 'draw', function () {
	        setTimeout(function(){
	    		$('.edit_good').click(function(){
	    			var id = ($(this).parent().parent().children().eq(1).text())
	    			that.$emit('edit_good',id)
	           	})
	            $('.delete_good').click(function(){
	                  var id = ($(this).parent().parent().children().eq(1).text())
	                  that._httpRequest({'url': 'deleteGood', 'params' :{'id': id}}).then(function (result)
	                  {
	                    if (!result.code)
	                    {
	                      return
	                    }
	                    that.$Message.success("删除成功！")
	                    table.draw();
	                  },function(error){})
	            })

	    	},500)
		});
	});

  },
  watch: {
   '$route' :function (to, from) {

   }
  }

}

//        initComplete: function () {
//            var api = this.api();
//            api.columns().indexes().flatten().each( function ( i ) {
//                var column = api.column( i );
//                var select = $('<select><option value=""></option></select>')
//                    .appendTo( $('#tsearch'+i).empty() )
//                    .on( 'change', function () {
//                        var val = $.fn.dataTable.util.escapeRegex(
//                            $(this).val()
//                        );
//                        column
//                            .search( val ? '^'+val+'$' : '', true, false )
//                            .draw();
//                    } );
//                column.data().unique().sort().each( function ( d, j ) {
//                    select.append( '<option value="'+d+'">'+d+'</option>' )
//                } );
//            } );
//        }


</script>
<style scope>
td.details-control {
    background: url('./../../../static/images/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('./../../../static/images/details_close.png') no-repeat center center;
}
</style>


