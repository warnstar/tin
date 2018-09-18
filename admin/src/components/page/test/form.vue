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

                    <el-form-item>
                        <el-button type="primary" @click="onSubmit">表单提交</el-button>
                        <el-button>取消</el-button>
                    </el-form-item>
                </el-form>
            </div>
        </div>

    </div>
</template>

<script>
    import { postTestSave } from '../../apis/api';

    export default {
        name: 'baseform',
        data: function(){
            return {
                form: {
                    title: '',
                    desc: '',
                }
            }
        },
        methods: {
            onSubmit() {
                postTestSave(this.form).then(res => {
                    if (res.data.status == 200) {
                        this.$message.success('提交成功！');
                        this.$router.push('/test/index');
                    } else {
                        this.$message.error(res.data.message);
                    }
                });
            }
        }
    }
</script>