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
            const reg = /^[0-9]*$/;
            const validatorSort = (rule, value, callback) => {
                if (!reg.test(value)) {
                    callback(new Error('权限值为数字'));
                } else {
                    callback();
                }
            };
            return {
                action: `${window.api}/zn/admin/upload`,
                form: {
                    intro: '',
                    name: '',
                    sort: null,
                    status: true,
                    type: 0,
                },
                loading: false,
                parent: {
                    name: '',
                    type: '',
                },
                rules: {
                    name: [
                        {
                            message: '名称不能为空',
                            required: true,
                            trigger: 'blur',
                        },
                    ],
                    type: [
                        {
                            message: '类型不能为空',
                            required: true,
                            trigger: 'blur',
                        },
                    ],
                    sort: [
                        {
                            trigger: 'blur',
                            validator: validatorSort,
                        },
                    ],
                },
                timeTypes: [
                    {
                        label: '选日期及时间',
                        value: 0,
                    },
                    {
                        label: '选年月日',
                        value: 1,
                    },
                    {
                        label: '选年月',
                        value: 2,
                    },
                    {
                        label: '仅选年',
                        value: 3,
                    },
                    {
                        label: '仅选时间',
                        value: 4,
                    },
                ],
                timeTypesArea: [
                    {
                        label: '选日期及时间',
                        value: 0,
                    },
                    {
                        label: '选年月日',
                        value: 1,
                    },
                    {
                        label: '仅选时间',
                        value: 2,
                    },
                ],
                types: [
                    {
                        label: '请选择信息类型',
                        value: 0,
                    },
                    {
                        label: '单行文本框',
                        value: 1,
                    },
                    {
                        label: '多行文本框',
                        value: 2,
                    },
                    {
                        label: '单选框',
                        value: 3,
                    },
                    {
                        label: '多选框',
                        value: 4,
                    },
                    {
                        label: '复选框',
                        value: 5,
                    },
                    {
                        label: '日期时间选择',
                        value: 6,
                    },
                    {
                        label: '日期时间范围选择',
                        value: 7,
                    },
                    {
                        label: '下拉菜单',
                        value: 8,
                    },
                    {
                        label: '上传图片',
                        value: 9,
                    },
                    {
                        label: '上传文件',
                        value: 10,
                    },
                ],
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
                                <i-select v-model="form.type">
                                    <i-option v-for="item in types"
                                              :disabled="item.value === 0"
                                              :value="item.value"
                                              :key="item">{{ item.label }}</i-option>
                                </i-select>
                            </form-item>
                            <form-item label="字符限定" prop="num"
                                       v-if="form.type === 1 || form.type === 2">
                                <i-input number v-model="form.num"></i-input>
                                <p class="tip">最多可填写的字符数</p>
                            </form-item>
                            <form-item label="可选值" prop="check_value"
                                       v-if="form.type === 3 || form.type === 4 || form.type === 7">
                                <i-input :autosize="{minRows: 3,maxRows: 5}"
                                         number
                                         type="textarea"
                                         v-model="form.check_value"></i-input>
                                <p class="tip">每行输入一个可选值，使用回车键换行</p>
                            </form-item>
                            <form-item label="可选数量" prop="check_num"
                                       v-if="form.type === 4">
                                <i-input number v-model="form.check_num"></i-input>
                            </form-item>
                            <form-item label="时间组件类型" prop="check_time" v-if="form.type === 5">
                                <i-select v-model="form.check_time">
                                    <i-option v-for="item in timeTypes"
                                              :value="item.value">
                                        {{ item.label }}</i-option>
                                </i-select>
                            </form-item>
                            <form-item label="时间组件类型" prop="time_area" v-if="form.type === 6">
                                <i-select v-model="form.time_area">
                                    <i-option v-for="item in timeTypesArea"
                                              :value="item.value">
                                        {{ item.label }}</i-option>
                                </i-select>
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
                                <i-input number v-model="form.sort"></i-input>
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
