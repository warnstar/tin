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
                                <el-button type="success" >新建选项</el-button>
                            </el-row>

                            <el-table :data="options.tableData" border class="table" ref="multipleTable">
                                <el-table-column prop="title" label="标题">
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

    </div>
</template>

<script>
    import { postQuestionSave, getQuestionDetail } from '../../apis/api';

    export default {
        name: 'baseform',
        data: function(){
            return {
                selectOptionHidden : true,
                typeDisable : false,
                form: {
                    id : null,
                    test_id : null,
                    title: '',
                    desc: '',
                    type : 'select'
                },
                typeMaps : [{
                    value: 'select',
                    label: '选择题'
                }, {
                    value: 'upload_img',
                    label: '上传图片'
                }],
                options : {
                    tableData : []
                }
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
            onSubmit() {
                postQuestionSave(this.form).then(res => {
                    if (res.data.status == 200) {
                        this.$message.success('提交成功！');
                        this.$router.replace('/question/index');
                    } else {
                        this.$message.error(res.data.message);
                    }
                });
            },
            cancel() {
                this.$router.replace('/question/index');
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

                        if (this.form.type == 'select') {
                            this.selectOptionHidden = false;
                        }
                    } else {
                        this.$message.error(res.data.message);
                    }
                });
            }
        }
    }
</script>