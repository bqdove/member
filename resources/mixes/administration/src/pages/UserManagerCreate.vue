<script>
    export default {
        beforeRouteEnter(to, from, next) {
            if (to.query.type === '1') {
                next(vm => {
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
                parent: {
                    type: '',
                    name: '',
                },
                form: {
                    name: '',
                },
                loading: false,
                rules: {
                    name: [
                        {
                            message: '供应商名称不能为空',
                            required: true,
                            trigger: 'blur',
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
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="user-manager-create">
            <div class="edit-link-title">
                <i-button type="text" @click.native="goBack">
                    <icon type="chevron-left"></icon>
                </i-button>
                <span v-if="parent.type === '0'">用户管理-新增</span>
                <span v-if="parent.type === '1'">用户管理-编辑"{{ parent.name }}"</span>
            </div>
            <card :bordered="false">
                <i-form ref="form" :model="form" :rules="rules" :label-width="400">
                    <row>
                        <i-col>
                            <form-item label="供应商名称" prop="name">
                                <i-input v-model="form.name"></i-input>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col>
                            <form-item>
                                <i-button :loading="loading" @click.native="submit"
                                          class="btn-group">
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
