<template>
    <div>
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item><i class="el-icon-lx-calendar"></i> 表单</el-breadcrumb-item>
                <el-breadcrumb-item>基本表单</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div class="container">
            <div class="form-box">
                <el-form ref="form" :model="form" label-width="80px">
                    <el-form-item label="标题">
                        <el-input v-model="form.title"></el-input>
                    </el-form-item>
                    <el-form-item label="说明">
                        <el-input type="textarea" rows="5" v-model="form.desc"></el-input>
                    </el-form-item>

                    <el-form-item label="题目类型">
                        <el-select v-model="form.type" placeholder="请选择" :disabled="typeDisable">
                            <el-option
                                    v-for="item in typeMaps"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
                    </el-form-item>

                    <div  :hidden="selectOptionHidden" >
                        <el-form-item label="题目选项">
                            <el-row>
                                <el-button type="success" @click="addOption()">新建选项</el-button>
                            </el-row>

                            <el-table :data="form.items" border class="table" ref="multipleTable">
                                <el-table-column prop="name" label="标题">
                                </el-table-column>

                                <el-table-column label="操作" width="180" align="center">
                                    <template slot-scope="scope">
                                        <el-button type="text" icon="el-icon-edit" @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                                        <el-button type="text" icon="el-icon-delete" class="red" @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                                    </template>
                                </el-table-column>
                            </el-table>
                        </el-form-item>
                    </div>

                    <el-form-item>
                        <el-button type="primary" @click="onSubmit">保存</el-button>
                        <el-button  type="info" @click="cancel">取消</el-button>
                    </el-form-item>

                </el-form>
            </div>
        </div>


        <!-- 编辑弹出框 -->
        <el-dialog title="编辑" :visible.sync="editVisible" width="30%">
            <el-form ref="form" :model="optionForm" label-width="50px">
                <el-form-item label="标题">
                    <el-input v-model="optionForm.name"></el-input>
                </el-form-item>

            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="editVisible = false">取 消</el-button>
                <el-button type="primary" @click="saveEdit">确 定</el-button>
            </span>
        </el-dialog>

        <!-- 删除提示框 -->
        <el-dialog title="提示" :visible.sync="delVisible" width="300px" center>
            <div class="del-dialog-cnt">删除不可恢复，是否确定删除？</div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="delVisible = false">取 消</el-button>
                <el-button type="primary" @click="deleteRow">确 定</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
    import { postQuestionSave, getQuestionDetail } from '../../apis/api';

    export default {
        name: 'baseform',
        data: function(){
            return {
                selectOptionHidden : true,
                editVisible: false,
                delVisible: false,
                typeDisable : false,
                form: {
                    id : null,
                    test_id : null,
                    title: '',
                    desc: '',
                    type : 'select',
                    items : []
                },
                optionForm: {
                    id : null,
                    name : null,
                    option : null
                },
                optionIdx : -1,
                typeMaps : [{
                    value: 'select',
                    label: '单选题'
                }, {
                    value: 'select_multi',
                    label: '多选题'
                }, {
                    value: 'input',
                    label: '填写文字'
                }, {
                    value: 'date',
                    label: '日期选择'
                }, {
                    value: 'upload_img',
                    label: '上传图片'
                }]
            }
        },
        mounted() {
            this.form.id = this.$route.query.id;
            if (this.form.id) {
                this.getData();
            } else {
                this.form = {
                    id : null,
                    test_id : this.$route.query.test_id,
                    title: '',
                    desc: '',
                    type : 'select'
                }
            }
        },
        methods: {
            resetForm() {
                this.form = {
                    id : null,
                    test_id : this.$route.query.test_id,
                    title: '',
                    desc: '',
                    type : 'select'
                }
            },
            onSubmit() {
                postQuestionSave(this.form).then(res => {
                    if (res.data.status == 200) {
                        this.resetForm();
                        this.$message.success('提交成功！');
                        this.$router.replace('/question/index?id=' + this.$route.query.test_id);
                    } else {
                        this.$message.error(res.data.message);
                    }
                });
            },
            cancel() {
                this.$router.replace('/question/index?id=' + this.$route.query.test_id);
            },
            getData() {
                var query = {
                     id : this.form.id
                };

                getQuestionDetail(query).then(res => {
                    if (res.data.status == 200) {
                        this.form = res.data.data;
                        if (this.form.id) {
                            this.typeDisable = true;
                        }

                        if (this.form.type == 'select' || this.form.type == 'select_multi') {
                            this.selectOptionHidden = false;
                        }
                    } else {
                        this.$message.error(res.data.message);
                    }
                });
            },
            addOption() {
                this.optionForm = {
                    name : null,
                    option : null,
                    id : null
                };

                this.optionIdx = this.form.items.length;
                this.editVisible = true;
            },
            handleEdit(index, row) {
                this.optionIdx = index;
                const item = this.form.items[index];

                this.optionForm = {
                    name : item.name,
                    option : item.option,
                    id : item.id
                };

                this.editVisible = true;
            },
            saveEdit() {
                this.$set(this.form.items, this.optionIdx, this.optionForm);
                this.editVisible = false;

            },
            handleDelete(index, row) {
                this.optionIdx = index;
                this.delVisible = true;
            },
            // 确定删除
            deleteRow(){
                this.tableData.splice(this.optionIdx, 1);
                this.delVisible = false;
            },
        }
    }
</script>
