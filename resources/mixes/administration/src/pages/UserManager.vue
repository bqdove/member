<script>
    export default {
        beforeRouteEnter(to, from, next) {
            next(() => {
            });
        },
        data() {
            const self = this;
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
                        title: '姓名',
                    },
                    {
                        align: 'center',
                        key: 'user_name',
                        title: '用户名',
                    },
                    {
                        align: 'center',
                        key: 'id',
                        title: 'ID',
                    },
                    {
                        align: 'center',
                        key: 'status',
                        render(h, data) {
                            if (data.row.status) {
                                return h('span', [
                                    h('icon', {
                                        props: {
                                            type: 'checkmark-circled',
                                            color: '#02a845',
                                        },
                                    }),
                                ]);
                            }
                            return h('span', [
                                h('icon', {
                                    props: {
                                        type: 'close-circled',
                                        color: '#ff3300',
                                        size: '16px',
                                    },
                                }),
                            ]);
                        },
                        title: '状态',
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
                                }, '封禁'),
                                h('i-button', {
                                    on: {
                                        click() {
                                            self.$router.push({
                                                path: '/user/manager/create',
                                                query: {
                                                    type: '1',
                                                    name: data.row.name,
                                                },
                                            });
                                        },
                                    },
                                    props: {
                                        size: 'small',
                                        type: 'ghost',
                                    },
                                    style: {
                                        marginLeft: '10px',
                                    },
                                }, '编辑'),
                                h('i-button', {
                                    on: {
                                        click() {
                                            self.list.splice(data.index, 1);
                                        },
                                    },
                                    props: {
                                        size: 'small',
                                        type: 'ghost',
                                    },
                                    style: {
                                        marginLeft: '10px',
                                    },
                                }, '删除'),
                            ]);
                        },
                        title: '操作',
                        width: 280,
                    },
                ],
                list: [
                    {
                        email: '3265256564@ibenchu.com',
                        id: 1323,
                        name: 'benchu',
                        phone: 3137264,
                        status: true,
                        user_name: 'admin',
                    },
                    {
                        email: '3265256564@ibenchu.com',
                        id: 1323,
                        name: 'benchu',
                        phone: 3137264,
                        status: true,
                        user_name: 'admin',
                    },
                    {
                        email: '3265256564@ibenchu.com',
                        id: 1323,
                        name: 'benchu',
                        phone: 3137264,
                        status: false,
                        user_name: 'admin',
                    },
                ],
                page: {
                    count: 3,
                    current: 1,
                    paginate: 2,
                },
                pagination: {
                    count: 3,
                    current: 1,
                    paginate: 2,
                },
                recycling: [
                    {
                        align: 'center',
                        type: 'selection',
                        width: 60,
                    },
                    {
                        align: 'center',
                        key: 'name',
                        title: '姓名',
                        width: 120,
                    },
                    {
                        align: 'center',
                        key: 'user_name',
                        title: '用户名',
                        width: 140,
                    },
                    {
                        align: 'center',
                        key: 'id',
                        title: 'ID',
                        width: 140,
                    },
                    {
                        key: 'email',
                        title: '邮箱',
                        width: 240,
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
                                }, '还原'),
                                h('i-button', {
                                    on: {
                                        click() {
                                            self.recyclingData.splice(data.index, 1);
                                        },
                                    },
                                    props: {
                                        size: 'small',
                                        type: 'ghost',
                                    },
                                    style: {
                                        marginLeft: '10px',
                                    },
                                }, '删除'),
                            ]);
                        },
                        title: '操作',
                        width: 180,
                    },
                ],
                recyclingData: [
                    {
                        email: '3265256564@ibenchu.com',
                        id: 1323,
                        name: 'benchu',
                        phone: 3137264,
                        user_name: 'admin',
                    },
                    {
                        email: '3265256564@ibenchu.com',
                        id: 1323,
                        name: 'benchu',
                        phone: 3137264,
                        user_name: 'admin',
                    },
                    {
                        email: '3265256564@ibenchu.com',
                        id: 1323,
                        name: 'benchu',
                        phone: 3137264,
                        user_name: 'admin',
                    },
                ],
                selection1: [],
                selection2: [],
            };
        },
        methods: {
            changePage1() {},
            changePage2() {},
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="user-manager">
            <tabs value="name1">
                <tab-pane label="用户管理" name="name1">
                    <card :bordered="false">
                        <div class="top-btn-action">
                            <router-link :to="{
                                path: '/user/manager/create',
                                query: {
                                    type: '0',
                                },
                            }">
                                <i-button class="btn-action" type="ghost">+新增角色</i-button>
                            </router-link>
                            <i-button class="btn-action" type="ghost">批量删除</i-button>
                            <i-button class="btn-action" type="ghost">刷新</i-button>
                        </div>
                        <i-table :columns="columns"
                                 :data="list"
                                 @on-selection-change="selection1"
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
                    </card>
                </tab-pane>
                <tab-pane label="回收站" name="name2">
                    <card :bordered="false">
                        <div class="top-btn-action">
                            <i-button class="btn-action" type="ghost">批量还原</i-button>
                            <i-button class="btn-action" type="ghost">批量删除</i-button>
                            <i-button class="btn-action" type="ghost">刷新</i-button>
                        </div>
                        <i-table :columns="recycling"
                                 :data="recyclingData"
                                 @on-selection-change="selection2"
                                 ref="recycling"
                                 highlight-row>
                        </i-table>
                        <div class="ivu-page-wrap">
                            <page :current="page.current"
                                  :page-size="page.paginate"
                                  :total="page.count"
                                  @on-change="changePage2"
                                  show-elevator></page>
                        </div>
                    </card>
                </tab-pane>
            </tabs>
        </div>
    </div>
</template>