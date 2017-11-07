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
                                                path: '/member/user/manager/create',
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
                                            self.deleteModal.name = data.row.name;
                                            self.modal1 = true;
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
                deleteModal: {
                    name: 'ibenchu',
                    num: 2,
                },
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
                modal1: false,
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
                selection1: [],
                selection2: [],
            };
        },
        methods: {
            changePage1() {},
            changePage2() {},
            batchDelete() {
                this.modal2 = true;
            },
            batchRemove() {
                this.modal2 = true;
            },
            submitCancel(data) {
                if (data === 1) {
                    this.modal1 = false;
                }
                if (data === 2) {
                    this.modal2 = false;
                }
            },
            submitDelete() {},
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="function-manager">
            <tabs value="name1">
                <tab-pane label="商城" name="name1">
                    <card :bordered="false">
                        <div class="top-btn-action">
                            <i-button class="btn-action" type="ghost">+新增功能</i-button>
                            <i-button class="btn-action" type="ghost">刷新</i-button>
                        </div>
                        <i-table :columns="columns"
                                 :data="list"
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
                <tab-pane label="商家" name="name2">
                    <card :bordered="false">
                        <div class="top-btn-action">
                            <i-button class="btn-action" type="ghost">+新增功能</i-button>
                            <i-button class="btn-action" type="ghost">刷新</i-button>
                        </div>
                        <i-table :columns="columns"
                                 :data="list"
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
                <tab-pane label="论坛" name="name3">
                    <card :bordered="false">
                        <div class="top-btn-action">
                            <i-button class="btn-action" type="ghost">+新增功能</i-button>
                            <i-button class="btn-action" type="ghost">刷新</i-button>
                        </div>
                        <i-table :columns="columns"
                                 :data="list"
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
            </tabs>
            <modal
                    v-model="modal1"
                    title="删除" class="setting-modal-delete">
                <div>
                    <i-form ref="deleteModal" :model="deleteModal" :label-width="120">
                        <row>
                            <i-col class="first-row-title delete-file-tip">
                                <span>确定要删除用户"{{ deleteModal.name }}"吗？</span>
                            </i-col>
                        </row>
                        <row>
                            <i-col class="btn-group">
                                <i-button type="ghost" class="cancel-btn"
                                          @click.native="submitCancel(1)">取消</i-button>
                                <i-button :loading="loading" type="primary" class="cancel-btn"
                                          @click.native="submitDelete">
                                    <span v-if="!loading">确认</span>
                                    <span v-else>正在删除…</span>
                                </i-button>
                            </i-col>
                        </row>
                    </i-form>
                </div>
            </modal>
        </div>
    </div>
</template>