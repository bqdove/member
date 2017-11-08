<script>
    export default {
        beforeRouteEnter(to, from, next) {
            const data = {};
            if (to.query.parent_id) {
                data.parent.last_id = to.query.parent_id;
            }
            next(() => {
            });
        },
        data() {
            const self = this;
            return {
                columns: [
                    {
                        align: 'center',
                        key: 'id',
                        title: 'ID',
                        width: 160,
                    },
                    {
                        align: 'center',
                        key: 'name',
                        title: '部门名称',
                        width: 200,
                    },
                    {
                        key: 'role',
                        title: '部门角色',
                    },
                    {
                        align: 'center',
                        key: 'action',
                        render(h, data) {
                            return h('div', [
                                h('i-button', {
                                    on: {
                                        click() {
                                            self.level = 2;
                                            self.$router.push({
                                                path: '/member/organization',
                                                query: {
                                                    parent_id: data.row.id,
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
                                        click() {},
                                    },
                                    props: {
                                        size: 'small',
                                        type: 'ghost',
                                    },
                                    style: {
                                        marginLeft: '10px',
                                    },
                                }, '新增下级'),
                                h('i-button', {
                                    on: {
                                        click() {},
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
                                }, '删除'),
                            ]);
                        },
                        title: '操作',
                        width: 360,
                    },
                ],
                level: 1,
                list: [
                    {
                        id: 231,
                        name: '本初',
                        role: '管理员',
                    },
                    {
                        id: 656,
                        name: '本初2',
                        role: '管理员',
                    },
                    {
                        id: 989,
                        name: '本初3',
                        role: '管理员',
                    },
                ],
                pagination: {
                    count: 3,
                    current: 1,
                    paginate: 2,
                },
                parent: {
                    last_id: '',
                    last_name: '',
                },
            };
        },
        methods: {
            goBack() {
                const self = this;
                self.$router.go(-1);
                self.level = 1;
            },
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="organization-manager">
            <div class="return-link-title tab-pane-title" v-if="level === 1">
                <span>组织部门</span>
            </div>
            <div class="return-link-title"  v-if="level === 2">
                <i-button type="text" @click.native="goBack">
                    <icon type="chevron-left"></icon>
                </i-button>
                <span>查看"{{ parent.last_name}}"部门</span>
            </div>
            <card :bordered="false">
                <div class="top-btn-action">
                    <i-button class="btn-action" type="ghost">+新增部门</i-button>
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
                          @on-change="changePage"
                          show-elevator></page>
                </div>
            </card>
        </div>
    </div>
</template>