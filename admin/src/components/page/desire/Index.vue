<template>
    <div class="table">
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item><i class="el-icon-lx-cascades"></i> 测评列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <div class="container">
            <el-row>
                <el-button @click="handleCreate()" type="success">新增测试愿望</el-button>
            </el-row>

            <el-table :data="tableData" border class="table" ref="multipleTable">
                <el-table-column prop="title" label="标题">
                </el-table-column>
                <el-table-column label="操作" width="180" align="center">
                    <template slot-scope="scope">
                        <el-button type="text" icon="el-icon-edit" @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                        <el-button type="text" icon="el-icon-delete" class="red" @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                    </template>
                </el-table-column>
            </el-table>
            <div class="pagination">
                <el-pagination background @current-change="handleCurrentChange" layout="prev, pager, next" :page-size="pagination.pageSize" :total="pagination.total">
                </el-pagination>
            </div>
        </div>

        <!-- 编辑弹出框 -->
        <el-dialog title="编辑" :visible.sync="editVisible" width="30%">
            <el-form ref="form" :model="form" label-width="50px">
                <el-form-item label="标题">
                    <el-input v-model="form.title"></el-input>
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
    import { getDesireIndex,getDesireDelete,postDesireSave,uploadUrl } from '../../apis/api';

    export default {
        name: 'basetable',
        data() {
            return {
                tableData: [],
                cur_page: 0,
                select_cate: '',
                select_word: '',
                is_search: false,
                editVisible: false,
                delVisible: false,
                form: {
                    title: '',
                },
                pagination: {
                    total : 0,
                    pageSize : 15
                },
                idx: -1
            }
        },
        mounted() {
            this.getData();
        },
        computed: {
            data() {
                return this.tableData.filter((d) => {
                    let is_del = false;
                    for (let i = 0; i < this.del_list.length; i++) {
                        if (d.name === this.del_list[i].name) {
                            is_del = true;
                            break;
                        }
                    }
                    if (!is_del) {
                        if (d.address.indexOf(this.select_cate) > -1 &&
                            (d.name.indexOf(this.select_word) > -1 ||
                                d.address.indexOf(this.select_word) > -1)
                        ) {
                            return d;
                        }
                    }
                })
            }
        },
        methods: {
            // 分页导航
            handleCurrentChange(val) {
                this.cur_page = val - 1;
                this.getData();
            },
            // 获取 easy-mock 的模拟数据
            getData() {
                var form = {
                    page : this.cur_page
                };

                getDesireIndex(form).then(res => {
                    if (res.data.status == 200) {
                        this.tableData = res.data.data.data;
                        this.pagination.total = res.data.data.page.total;
                        this.pagination.pageSize = res.data.data.page.per_page;
                    } else {
                        this.$message.error(res.data.message);
                    }

                });
            },
            search() {
                this.is_search = true;
            },
            filterTag(value, row) {
                return row.tag === value;
            },
            handleCreate() {
                this.form = {
                    title : '',
                    id : null,
                };

                this.editVisible = true;
            },
            handleEdit(index, row) {
                this.idx = index;
                const item = this.tableData[index];

                this.form = {
                    title : item.title,
                    id : item.id,
                };

                this.editVisible = true;
            },
            handleDelete(index, row) {
                this.idx = index;
                this.delVisible = true;
            },
            // 保存编辑
            saveEdit() {
                postDesireSave(this.form).then(res => {
                    if (res.data.status == 200) {
                        this.$message.success('提交成功！');

                        if (this.form.id) {
                            this.$set(this.tableData, this.idx, this.form);
                        } else {
                            this.tableData.push(res.data.data);
                        }
                        this.editVisible = false;
                    } else {
                        this.$message.error(res.data.message);
                    }
                });
            },
            // 确定删除
            deleteRow(){
                var form = {
                    id : this.tableData[this.idx].id
                };

                getDesireDelete(form).then(res => {
                    if (res.data.status == 200) {
                        this.$message.success('删除成功');

                        this.tableData.splice(this.idx, 1);
                        this.delVisible = false;
                        this.$router.push('/desire/index');
                    } else {
                        this.$message.error(res.data.message);
                    }
                });

            }
        }
    }

</script>

<style scoped>
    .handle-box {
        margin-bottom: 20px;
    }

    .handle-select {
        width: 120px;
    }

    .handle-input {
        width: 300px;
        display: inline-block;
    }
    .del-dialog-cnt{
        font-size: 16px;
        text-align: center
    }
    .table{
        width: 100%;
        font-size: 14px;
    }
    .red{
        color: #ff0000;
    }
</style>
