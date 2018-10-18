<template>
    <div class="table">
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item><i class="el-icon-lx-cascades"></i> 用户列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <div class="container">

            <el-table :data="tableData" border class="table" ref="multipleTable" @selection-change="handleSelectionChange">
                <el-table-column prop="id" label="id" width="120">
                </el-table-column>
                <el-table-column prop="avatar" label="用户" >
                    <template slot-scope="scope">
                        <img style="width: 50px;height: 50px; vertical-align: middle;" :src="scope.row.avatar"/>
                        <span >{{scope.row.nickname}}</span>
                    </template>
                </el-table-column>
                <el-table-column prop="sex" label="性别" >
                </el-table-column>
                <el-table-column prop="created_at" label="创建时间" sortable >
                </el-table-column>
                <el-table-column label="操作" width="180" align="center">
                    <template slot-scope="scope">
                        <el-button type="text" icon="el-icon-delete" disabled class="red" @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                    </template>
                </el-table-column>
            </el-table>
            <div class="pagination">
                <el-pagination background @current-change="handleCurrentChange" layout="prev, pager, next" :page-size="pagination.pageSize" :total="pagination.total">
                </el-pagination>
            </div>
        </div>


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
    import { getUserIndex,uploadUrl } from '../../apis/api';

    export default {
        name: 'basetable',
        data() {
            return {
                url: './static/vuetable.json',
                tableData: [],
                cur_page: 0,
                select_cate: '',
                select_word: '',
                is_search: false,
                editVisible: false,
                delVisible: false,
                form: {
                    title: '',
                    desc: '',
                    cover: ''
                },
                pagination: {
                    total : 0,
                    pageSize : 15
                },
                idx: -1,
                upload : {
                    action : uploadUrl,
                    headers : {
                        'X-Request-Token' : localStorage.getItem("access_token")
                    },
                    dialogImageUrl: '',
                    dialogVisible: false,
                    filelist : null
                }
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

                getUserIndex(form).then(res => {
                    this.tableData = res.data.data.data;
                    this.pagination.total = res.data.data.page.total;
                    this.pagination.pageSize = res.data.data.page.per_page;

                    for (let k in this.tableData) {
                        if (this.tableData[k].sex == 1) {
                            this.tableData[k].sex = '男';
                        } else if (this.tableData[k].sex == 2) {
                            this.tableData[k].sex = '女';
                        }
                    }
                });
            },
            search() {
                this.is_search = true;
            },
            filterTag(value, row) {
                return row.tag === value;
            },
            toQuestions(index, row) {
                this.idx = index;
                const item = this.tableData[index];

                this.$router.push({
                    path: '/question/index',
                    query: {
                        id: item.id
                    }
                });
            },
            handleEdit(index, row) {
                this.idx = index;
                const item = this.tableData[index];

                this.form = {
                    title : item.title,
                    desc : item.desc,
                    id : item.id,
                    cover: item.cover
                };

                this.editVisible = true;

                this.upload.dialogImageUrl = this.form.cover;
                this.upload.filelist = [{name: 'cover.jpg', url: this.form.cover}];

            },
            handleDelete(index, row) {
                this.idx = index;
                this.delVisible = true;
            },
            handleSelectionChange(val) {
                this.multipleSelection = val;
            },
            // 保存编辑
            saveEdit() {
                postTestSave(this.form).then(res => {
                    if (res.data.status == 200) {
                        this.$message.success('提交成功！');

                        this.$set(this.tableData, this.idx, this.form);
                        this.editVisible = false;
                        this.$message.success(`修改第 ${this.idx+1} 行成功`);
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

                getTestDelete(form).then(res => {
                    if (res.data.status == 200) {
                        this.$message.success('删除成功');

                        this.tableData.splice(this.idx, 1);
                        this.delVisible = false;
                        this.$router.push('/test/index');
                    } else {
                        this.$message.error(res.data.message);
                    }
                });

            },
            uploadSuccess(response, file, fileList) {
                this.form.cover = response.data.url;
            },
            uploadRemove(file, fileList) {
                console.log(file, fileList);
            },
            uploadPictureCardPreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
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
