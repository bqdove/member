<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/member/administration/notification/list`, {
                with: [
                    'notifiable',
                ],
            }).then(response => {
                const { data, pagination } = response.data;
                next(vm => {
                    data.forEach(item => {
                        item.loading = false;
                        item.title = item.data.title;
                        item.user = item.notifiable.name;
                    });
                    vm.list = data;
                    vm.pagination = pagination;
                    injection.loading.finish();
                });
            }).catch(() => {
                injection.loading.error();
            });
        },
        data() {
            const self = this;
            return {
                columns: [
                    {
                        key: 'title',
                        title: '通知标题',
                    },
                    {
                        key: 'user',
                        title: '用户名',
                        width: 200,
                    },
                    {
                        key: 'created_at',
                        title: '发送时间',
                        width: 200,
                    },
                    {
                        key: 'handle',
                        render(h, data) {
                            let text;
                            if (self.list[data.index].loading) {
                                text = injection.trans('content.global.delete.loading');
                            } else {
                                text = injection.trans('content.global.delete.submit');
                            }
                            return h('i-button', {
                                on: {
                                    click() {
                                        self.remove(data.index);
                                    },
                                },
                                props: {
                                    size: 'small',
                                    type: 'error',
                                },
                            }, [
                                h('span', text),
                            ]);
                        },
                        title: '操作',
                        width: 200,
                    },
                ],
                list: [],
                pagination: {
                    count: 1,
                },
                self: this,
            };
        },
        methods: {
            remove(index) {
                const self = this;
                const notification = self.list[index];
                notification.loading = true;
                self.$http.post(`${window.api}/member/administration/notification/remove`, {
                    id: notification.id,
                }).then(() => {
                    self.$notice.open({
                        title: '删除通知消息成功！',
                    });
                    self.$notice.open({
                        title: '正在刷新数据...',
                    });
                    self.$loading.start();
                    self.$http.post(`${window.api}/member/administration/notification/list`, {
                        with: [
                            'notifiable',
                        ],
                    }).then(response => {
                        const { data, pagination } = response.data;
                        data.forEach(item => {
                            item.loading = false;
                            item.title = item.data.title;
                            item.user = item.notifiable.name;
                        });
                        self.$loading.finish();
                        self.$notice.open({
                            title: '刷新数据成功！',
                        });
                        self.list = data;
                        self.pagination = pagination;
                    }).catch(() => {
                        self.$loading.error();
                    });
                }).finally(() => {
                    notification.loading = false;
                });
            },
        },
    };
</script>
<template>
    <div class="member-wrap">
        <div class="user-notification">
            <card :bordered="false">
                <template slot="title">
                    <span class="text">通知消息</span>
                </template>
                <i-table :columns="columns" :context="self" :data="list" @on-selection-change="selection"></i-table>
                <div class="ivu-page-wrap">
                    <page :current="pagination.current"
                          :page-size="pagination.paginate"
                          :total="pagination.total"
                          @on-change="paginator"></page>
                </div>
            </card>
        </div>
    </div>
</template>