<script>
    export default {
        beforeRouteEnter(to, from, next) {
            next(vm => {
                vm.parent.tab_name = to.query.tab_name;
                vm.parent.fun_name = to.query.fun_name;
            });
        },
        data() {
            return {
                columns: [
                    {
                        align: 'center',
                        key: 'id',
                        title: 'ID',
                        width: 160,
                    },
                    {
                        key: 'name',
                        title: '功能名称',
                    },
                    {
                        align: 'center',
                        key: 'action',
                        render(h, data) {
                            return h('div', [
                                h('i-button', {
                                    on: {
                                        click() {
                                            self.$router.push({
                                                path: '/member/function/manager/look',
                                                query: {
                                                    tab_name: self.tab_name,
                                                    fun_name: data.row.name,
                                                },
                                            });
                                        },
                                    },
                                    props: {
                                        size: 'small',
                                        type: 'ghost',
                                    },
                                }, '查看'),
                                h('i-button', {
                                    on: {
                                        click() {
                                            self.$router.push({
                                                path: '/member/function/manager/set',
                                                query: {
                                                    tab_name: self.tab_name,
                                                    fun_name: data.row.name,
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
                                }, '设置'),
                                h('i-button', {
                                    on: {
                                        click() {
                                            self.deleteModal.name = data.row.name;
                                            self.modal = true;
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
                        id: 1323,
                        name: '商品管理',
                    },
                    {
                        id: 5677,
                        name: 'benchu2',
                    },
                    {
                        id: 8684,
                        name: 'benchu3',
                    },
                ],
                pagination: {
                    count: 3,
                    current: 1,
                    paginate: 2,
                },
                parent: {
                    fun_name: '',
                    tab_name: '',
                },
            };
        },
        methods: {
            changePage() {},
            goBack() {
                const self = this;
                self.$router.go(-1);
            },
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="function-manager-look">
            <div class="return-link-title">
                <i-button type="text" @click.native="goBack">
                    <icon type="chevron-left"></icon>
                </i-button>
                <span>查看"{{ parent.tab_name}}-{{ parent.fun_name }}"功能</span>
            </div>
            <card :bordered="false">
                <i-table :columns="columns"
                         :data="list"
                         ref="list"
                         highlight-row>
                </i-table>
                <div class="ivu-page-wrap">
                    <page :current="pagination.current"
                          :page-size="pagination.paginate"
                          :total="pagination.count"
                          @on-change="changePage"
                          show-elevator></page>
                </div>
            </card>
        </div>
    </div>
</template>