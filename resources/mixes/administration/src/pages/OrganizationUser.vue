<script>
    export default {
        beforeRouteEnter(to, from, next) {
            next(() => {
            });
        },
        data() {
            return {
                columns: [
                    {
                        align: 'center',
                        type: 'selection',
                        width: 60,
                    },
                    {
                        align: 'center',
                        key: 'name',
                        title: '用户名',
                    },
                    {
                        align: 'center',
                        key: 'id',
                        title: 'ID',
                    },
                    {
                        align: 'center',
                        key: 'sex',
                        render(h, data) {
                            if (data.row.sex === '1') {
                                data.row.sex = '男';
                            } else {
                                data.row.sex = '女';
                            }
                            return '';
                        },
                        title: '性别',
                    },
                    {
                        key: 'email',
                        title: '邮箱',
                    },
                    {
                        key: 'phone',
                        title: '手机',
                    },
                    {
                        align: 'center',
                        key: 'action',
                        render(h, data) {
                            return h('div', [
                                h('i-button', {
                                    on: {
                                        click() {},
                                    },
                                    props: {
                                        size: 'small',
                                        type: 'ghost',
                                    },
                                }, '查看'),
                                h('i-button', {
                                    on: {
                                        click() {
                                            window.console.log(data);
                                        },
                                    },
                                    props: {
                                        size: 'small',
                                        type: 'ghost',
                                    },
                                    style: {
                                        marginLeft: '10px',
                                    },
                                }, '移除'),
                            ]);
                        },
                        title: '操作',
                        width: 280,
                    },
                ],
                departmentList: [
                    {
                        expand: true,
                        title: 'parent 1',
                        children: [
                            {
                                expand: false,
                                title: 'parent 1-1',
                                children: [
                                    {
                                        expand: false,
                                        title: 'leaf 1-1-1',
                                        children: [
                                            {
                                                title: 'leaf 1-1-1-1',
                                            },
                                            {
                                                title: 'leaf 1-1-1-2',
                                            },
                                        ],
                                    },
                                    {
                                        title: 'leaf 1-1-2',
                                    },
                                ],
                            },
                            {
                                expand: false,
                                title: 'parent 1-2',
                                children: [
                                    {
                                        title: 'leaf 1-2-1',
                                    },
                                    {
                                        title: 'leaf 1-2-1',
                                    },
                                ],
                            },
                        ],
                    },
                ],
                filterWord: '1',
                list: [
                    {
                        email: '226458751@qq.com',
                        id: '5435',
                        name: 'gdeyf',
                        phone: '1876534576',
                        sex: '1',
                    },
                    {
                        email: '226458751@qq.com',
                        id: '5435',
                        name: 'gdeyf',
                        phone: '1876534576',
                        sex: '2',
                    },
                    {
                        email: '226458751@qq.com',
                        id: '5435',
                        name: 'gdeyf',
                        phone: '1876534576',
                        sex: '1',
                    },
                    {
                        email: '226458751@qq.com',
                        id: '5435',
                        name: 'gdeyf',
                        phone: '1876534576',
                        sex: '1',
                    },
                    {
                        email: '226458751@qq.com',
                        id: '5435',
                        name: 'gdeyf',
                        phone: '1876534576',
                        sex: '1',
                    },
                    {
                        email: '226458751@qq.com',
                        id: '5435',
                        name: 'gdeyf',
                        phone: '1876534576',
                        sex: '1',
                    },
                    {
                        email: '226458751@qq.com',
                        id: '5435',
                        name: 'gdeyf',
                        phone: '1876534576',
                        sex: '1',
                    },
                    {
                        email: '226458751@qq.com',
                        id: '5435',
                        name: 'gdeyf',
                        phone: '1876534576',
                        sex: '1',
                    },
                    {
                        email: '226458751@qq.com',
                        id: '5435',
                        name: 'gdeyf',
                        phone: '1876534576',
                        sex: '1',
                    },
                ],
                pagination: {
                    count: 3,
                    current: 1,
                    paginate: 2,
                },
                searchList: [
                    {
                        label: '用户名称',
                        value: '1',
                    },
                    {
                        label: '用户ID',
                        value: '2',
                    },
                ],
                searchValue: '',
                selection: [],
            };
        },
        methods: {
            batchRemove: {},
            createDepartment: {},
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="organization-user">
            <tabs value="name1">
                <tab-pane label="部门用户" name="name1">
                    <card :bordered="false">
                        <row>
                            <i-col span="12">
                                <div class="depart-expand-tree">
                                    <h5>部门名称</h5>
                                    <tree :data="departmentList"></tree>
                                </div>
                            </i-col>
                            <i-col span="12">
                                <div class="top-btn-action">
                                    <i-button class="btn-action" @click.native="createDepartment"
                                              type="ghost">+新增部门</i-button>
                                    <i-button class="btn-action" @click.native="batchRemove"
                                              type="ghost">批量删除</i-button>
                                    <div class="goods-body-header-right">
                                        <i-input v-model="searchValue" placeholder="请输入关键词进行搜索">
                                            <i-select v-model="filterWord" slot="prepend" style="width: 100px;">
                                                <i-option v-for="item in searchList"
                                                          :value="item.value">{{ item.label }}</i-option>
                                            </i-select>
                                            <i-button slot="append" type="primary">搜索</i-button>
                                        </i-input>
                                    </div>
                                </div>
                                <i-table :columns="columns"
                                         :data="list"
                                         @on-selection-change="selection"
                                         ref="list"
                                         highlight-row>
                                </i-table>
                                <div class="ivu-page-wrap">
                                    <page :current="pagination.current"
                                          :page-size="pagination.paginate"
                                          :total="pagination.count"
                                          @on-change="changePage1"
                                          show-elevator></page>
                                </div>
                            </i-col>
                        </row>
                    </card>
                </tab-pane>
            </tabs>
        </div>
    </div>
</template>