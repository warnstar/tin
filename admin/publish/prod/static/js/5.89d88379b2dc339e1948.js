webpackJsonp([5],{LuNB:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=a("Nspb"),s={name:"basetable",data:function(){return{tableData:[],cur_page:0,select_cate:"",select_word:"",is_search:!1,editVisible:!1,delVisible:!1,form:{title:""},pagination:{total:0,pageSize:15},idx:-1}},mounted:function(){this.getData()},computed:{data:function(){var t=this;return this.tableData.filter(function(e){for(var a=!1,i=0;i<t.del_list.length;i++)if(e.name===t.del_list[i].name){a=!0;break}if(!a&&e.address.indexOf(t.select_cate)>-1&&(e.name.indexOf(t.select_word)>-1||e.address.indexOf(t.select_word)>-1))return e})}},methods:{handleCurrentChange:function(t){this.cur_page=t-1,this.getData()},getData:function(){var t=this,e={page:this.cur_page};Object(i.c)(e).then(function(e){200==e.data.status?(t.tableData=e.data.data.data,t.pagination.total=e.data.data.page.total,t.pagination.pageSize=e.data.data.page.per_page):t.$message.error(e.data.message)})},search:function(){this.is_search=!0},filterTag:function(t,e){return e.tag===t},handleCreate:function(){this.form={title:"",id:null},this.editVisible=!0},handleEdit:function(t,e){this.idx=t;var a=this.tableData[t];this.form={title:a.title,id:a.id},this.editVisible=!0},handleDelete:function(t,e){this.idx=t,this.delVisible=!0},saveEdit:function(){var t=this;Object(i.k)(this.form).then(function(e){200==e.data.status?(t.$message.success("提交成功！"),t.form.id?t.$set(t.tableData,t.idx,t.form):t.tableData.push(e.data.data),t.editVisible=!1):t.$message.error(e.data.message)})},deleteRow:function(){var t=this,e={id:this.tableData[this.idx].id};Object(i.b)(e).then(function(e){200==e.data.status?(t.$message.success("删除成功"),t.tableData.splice(t.idx,1),t.delVisible=!1,t.$router.push("/test/index")):t.$message.error(e.data.message)})}}},l={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"table"},[a("div",{staticClass:"crumbs"},[a("el-breadcrumb",{attrs:{separator:"/"}},[a("el-breadcrumb-item",[a("i",{staticClass:"el-icon-lx-cascades"}),t._v(" 测评列表")])],1)],1),t._v(" "),a("div",{staticClass:"container"},[a("el-row",[a("el-button",{attrs:{type:"success"},on:{click:function(e){t.handleCreate()}}},[t._v("新增测试愿望")])],1),t._v(" "),a("el-table",{ref:"multipleTable",staticClass:"table",attrs:{data:t.tableData,border:""}},[a("el-table-column",{attrs:{prop:"title",label:"标题"}}),t._v(" "),a("el-table-column",{attrs:{label:"操作",width:"180",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-button",{attrs:{type:"text",icon:"el-icon-edit"},on:{click:function(a){t.handleEdit(e.$index,e.row)}}},[t._v("编辑")]),t._v(" "),a("el-button",{staticClass:"red",attrs:{type:"text",icon:"el-icon-delete"},on:{click:function(a){t.handleDelete(e.$index,e.row)}}},[t._v("删除")])]}}])})],1),t._v(" "),a("div",{staticClass:"pagination"},[a("el-pagination",{attrs:{background:"",layout:"prev, pager, next","page-size":t.pagination.pageSize,total:t.pagination.total},on:{"current-change":t.handleCurrentChange}})],1)],1),t._v(" "),a("el-dialog",{attrs:{title:"编辑",visible:t.editVisible,width:"30%"},on:{"update:visible":function(e){t.editVisible=e}}},[a("el-form",{ref:"form",attrs:{model:t.form,"label-width":"50px"}},[a("el-form-item",{attrs:{label:"标题"}},[a("el-input",{model:{value:t.form.title,callback:function(e){t.$set(t.form,"title",e)},expression:"form.title"}})],1)],1),t._v(" "),a("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:function(e){t.editVisible=!1}}},[t._v("取 消")]),t._v(" "),a("el-button",{attrs:{type:"primary"},on:{click:t.saveEdit}},[t._v("确 定")])],1)],1),t._v(" "),a("el-dialog",{attrs:{title:"提示",visible:t.delVisible,width:"300px",center:""},on:{"update:visible":function(e){t.delVisible=e}}},[a("div",{staticClass:"del-dialog-cnt"},[t._v("删除不可恢复，是否确定删除？")]),t._v(" "),a("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:function(e){t.delVisible=!1}}},[t._v("取 消")]),t._v(" "),a("el-button",{attrs:{type:"primary"},on:{click:t.deleteRow}},[t._v("确 定")])],1)])],1)},staticRenderFns:[]};var n=a("C7Lr")(s,l,!1,function(t){a("W58s")},"data-v-92dc4f5c",null);e.default=n.exports},W58s:function(t,e){}});