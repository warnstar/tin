webpackJsonp([10],{"6M6k":function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var l=i("Nspb"),o={name:"baseform",data:function(){return{selectOptionHidden:!0,editVisible:!1,delVisible:!1,typeDisable:!1,form:{id:null,test_id:null,title:"",desc:"",type:"select",items:[]},optionForm:{id:null,name:null,option:null},optionIdx:-1,typeMaps:[{value:"select",label:"单选题"},{value:"select_multi",label:"多选题"},{value:"input",label:"填写文字"},{value:"date",label:"日期选择"},{value:"upload_img",label:"上传图片"}]}},mounted:function(){this.form.id=this.$route.query.id,this.form.id?this.getData():this.form={id:null,test_id:this.$route.query.test_id,title:"",desc:"",type:"select"}},methods:{onSubmit:function(){var t=this;Object(l.l)(this.form).then(function(e){200==e.data.status?(t.$message.success("提交成功！"),t.$router.replace("/question/index")):t.$message.error(e.data.message)})},cancel:function(){this.$router.replace("/question/index")},getData:function(){var t=this,e={id:this.form.id};Object(l.f)(e).then(function(e){200==e.data.status?(t.form=e.data.data,t.form.id&&(t.typeDisable=!0),"select"!=t.form.type&&"select_multi"!=t.form.type||(t.selectOptionHidden=!1),console.log(t.form)):t.$message.error(e.data.message)})},addOption:function(){this.optionForm={name:null,option:null,id:null},this.optionIdx=this.form.items.length,this.editVisible=!0},handleEdit:function(t,e){this.optionIdx=t;var i=this.form.items[t];this.optionForm={name:i.name,option:i.option,id:i.id},this.editVisible=!0},saveEdit:function(){this.$set(this.form.items,this.optionIdx,this.optionForm),this.editVisible=!1},handleDelete:function(t,e){this.optionIdx=t,this.delVisible=!0},deleteRow:function(){this.tableData.splice(this.optionIdx,1),this.delVisible=!1}}},s={render:function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",[i("div",{staticClass:"crumbs"},[i("el-breadcrumb",{attrs:{separator:"/"}},[i("el-breadcrumb-item",[i("i",{staticClass:"el-icon-lx-calendar"}),t._v(" 表单")]),t._v(" "),i("el-breadcrumb-item",[t._v("基本表单")])],1)],1),t._v(" "),i("div",{staticClass:"container"},[i("div",{staticClass:"form-box"},[i("el-form",{ref:"form",attrs:{model:t.form,"label-width":"80px"}},[i("el-form-item",{attrs:{label:"标题"}},[i("el-input",{model:{value:t.form.title,callback:function(e){t.$set(t.form,"title",e)},expression:"form.title"}})],1),t._v(" "),i("el-form-item",{attrs:{label:"说明"}},[i("el-input",{attrs:{type:"textarea",rows:"5"},model:{value:t.form.desc,callback:function(e){t.$set(t.form,"desc",e)},expression:"form.desc"}})],1),t._v(" "),i("el-form-item",{attrs:{label:"题目类型"}},[i("el-select",{attrs:{placeholder:"请选择",disabled:t.typeDisable},model:{value:t.form.type,callback:function(e){t.$set(t.form,"type",e)},expression:"form.type"}},t._l(t.typeMaps,function(t){return i("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})}))],1),t._v(" "),i("div",{attrs:{hidden:t.selectOptionHidden}},[i("el-form-item",{attrs:{label:"题目选项"}},[i("el-row",[i("el-button",{attrs:{type:"success"},on:{click:function(e){t.addOption()}}},[t._v("新建选项")])],1),t._v(" "),i("el-table",{ref:"multipleTable",staticClass:"table",attrs:{data:t.form.items,border:""}},[i("el-table-column",{attrs:{prop:"name",label:"标题"}}),t._v(" "),i("el-table-column",{attrs:{label:"操作",width:"180",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[i("el-button",{attrs:{type:"text",icon:"el-icon-edit"},on:{click:function(i){t.handleEdit(e.$index,e.row)}}},[t._v("编辑")]),t._v(" "),i("el-button",{staticClass:"red",attrs:{type:"text",icon:"el-icon-delete"},on:{click:function(i){t.handleDelete(e.$index,e.row)}}},[t._v("删除")])]}}])})],1)],1)],1),t._v(" "),i("el-form-item",[i("el-button",{attrs:{type:"primary"},on:{click:t.onSubmit}},[t._v("保存")]),t._v(" "),i("el-button",{attrs:{type:"info"},on:{click:t.cancel}},[t._v("取消")])],1)],1)],1)]),t._v(" "),i("el-dialog",{attrs:{title:"编辑",visible:t.editVisible,width:"30%"},on:{"update:visible":function(e){t.editVisible=e}}},[i("el-form",{ref:"form",attrs:{model:t.optionForm,"label-width":"50px"}},[i("el-form-item",{attrs:{label:"标题"}},[i("el-input",{model:{value:t.optionForm.name,callback:function(e){t.$set(t.optionForm,"name",e)},expression:"optionForm.name"}})],1)],1),t._v(" "),i("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[i("el-button",{on:{click:function(e){t.editVisible=!1}}},[t._v("取 消")]),t._v(" "),i("el-button",{attrs:{type:"primary"},on:{click:t.saveEdit}},[t._v("确 定")])],1)],1),t._v(" "),i("el-dialog",{attrs:{title:"提示",visible:t.delVisible,width:"300px",center:""},on:{"update:visible":function(e){t.delVisible=e}}},[i("div",{staticClass:"del-dialog-cnt"},[t._v("删除不可恢复，是否确定删除？")]),t._v(" "),i("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[i("el-button",{on:{click:function(e){t.delVisible=!1}}},[t._v("取 消")]),t._v(" "),i("el-button",{attrs:{type:"primary"},on:{click:t.deleteRow}},[t._v("确 定")])],1)])],1)},staticRenderFns:[]},a=i("C7Lr")(o,s,!1,null,null,null);e.default=a.exports}});