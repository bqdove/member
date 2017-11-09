<script>
    export default {
        beforeRouteEnter(to, from, next) {
            if (to.query.type === '1') {
                next(vm => {
                    vm.parent.type = to.query.type;
                    vm.parent.name = to.query.name;
                });
            } else if (to.query.type === '0') {
                next(vm => {
                    vm.parent.type = to.query.type;
                });
            }
        },
        data() {
            return {
                action: `${window.api}/zn/admin/upload`,
                form: {
                    image: '',
                    name: '',
                    sex: '1',
                },
                loading: false,
                parent: {
                    name: '',
                    type: '',
                },
                rules: {
                    email: [
                        {
                            message: '邮箱格式不正确',
                            trigger: 'blur',
                            type: 'email',
                        },
                    ],
                },
            };
        },
        methods: {
            goBack() {
                const self = this;
                self.$router.go(-1);
            },
            submit() {},
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="user-manager-create">
            <div class="return-link-title">
                <i-button type="text" @click.native="goBack">
                    <icon type="chevron-left"></icon>
                </i-button>
                <span v-if="parent.type === '0'">信息管理-新增</span>
                <span v-if="parent.type === '1'">信息管理-编辑"{{ parent.name }}"</span>
            </div>
            <card :bordered="false">
                <i-form ref="form" :model="form" :rules="rules" :label-width="200">
                    <row>
                        <i-col span="12">
                            <form-item label="信息项名称" prop="name">
                                <i-input v-model="form.name"></i-input>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="信息项介绍" prop="intro">
                                <i-input v-model="form.intro"></i-input>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="信息项类型" prop="type">
                                <i-input v-model="form.intro"></i-input>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="必填项" prop="status">
                                <i-switch size="large" v-model="form.status">
                                    <span slot="open">开启</span>
                                    <span slot="close">关闭</span>
                                </i-switch>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="排序" prop="sort">
                                <i-input v-model="form.sort"></i-input>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item>
                                <i-button :loading="loading" @click.native="submit"
                                          class="btn-group" type="primary">
                                    <span v-if="!loading">确认提交</span>
                                    <span v-else>正在提交…</span>
                                </i-button>
                            </form-item>
                        </i-col>
                    </row>
                </i-form>
            </card>
        </div>
    </div>
</template>
