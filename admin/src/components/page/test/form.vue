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

                    <el-form-item label="封面">
                        <el-upload
                                :action="upload.action"
                                :headers="upload.headers"
                                list-type="picture-card"
                                :on-success="uploadSuccess"
                                :on-preview="uploadPictureCardPreview"
                                :on-remove="uploadRemove"
                                :multiple=false
                                :limit=1
                        >
                            <i class="el-icon-plus"></i>
                        </el-upload>
                        <el-dialog :visible.sync="upload.dialogVisible">
                            <img width="100%" :src="upload.dialogImageUrl" alt="">
                        </el-dialog>
                    </el-form-item>

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
    import { postTestSave, uploadUrl } from '../../apis/api';

    export default {
        name: 'baseform',
        data: function(){
            return {
                form: {
                    title: '',
                    desc: '',
                    cover : ''
                },
                upload : {
                    action : uploadUrl,
                    headers : {
                        'X-Request-Token' : localStorage.getItem("access_token")
                    },
                    dialogImageUrl: '',
                    dialogVisible: false,
                }
            }
        },
        methods: {
            onSubmit() {
                postTestSave(this.form).then(res => {
                    if (res.data.status == 200) {
                        this.$message.success('提交成功！');
                        this.$router.replace('/test/index');
                    } else {
                        this.$message.error(res.data.message);
                    }
                });
            },
            cancel() {
                this.$router.replace('/test/index');
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