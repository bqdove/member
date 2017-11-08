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
                            } else if (data.row.sex === '0') {
                                data.row.sex = '女';
                            }
                            return data.row.sex;
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
                                }, '移除'),
                            ]);
                        },
                        title: '操作',
                        width: 180,
                    },
                ],
                deleteModal: {
                    name: '',
                    num: 1,
                    org_name: '',
                },
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
                modal1: false,
                modal2: false,
                organizationName: '',
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
            batchRemove() {
                const self = this;
                self.deleteModal.org_name = self.organizationName;
                self.modal2 = true;
            },
            createDepartment: {},
            submitCancel(data) {
                if (data === 1) {
                    this.modal1 = false;
                }
                if (data === 2) {
                    this.modal2 = false;
                }
            },
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
                                    <router-link to="/member/organization/user/create">
                                        <i-button class="btn-action" type="ghost">+添加用户</i-button>
                                    </router-link>
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
        <modal
                v-model="modal1"
                title="移除" class="setting-modal-delete">
            <div>
                <i-form ref="deleteModal" :model="deleteModal" :label-width="120">
                    <row>
                        <i-col class="first-row-title delete-file-tip">
                            <span>确定将"{{ deleteModal.name }}"从部门移除吗？</span>
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
        <modal
                v-model="modal2"
                title="批量移除" class="setting-modal-delete">
            <div>
                <i-form ref="deleteModal" :model="deleteModal" :label-width="120">
                    <row>
                        <i-col class="first-row-title delete-file-tip">
                            <span>确定移除部门"{{ deleteModal.org_name }}下的{{ deleteModal.num }}位用户吗"？</span>
                        </i-col>
                    </row>
                    <row>
                        <i-col class="btn-group">
                            <i-button type="ghost" class="cancel-btn"
                                      @click.native="submitCancel(2)">取消</i-button>
                            <i-button :loading="loading" type="primary" class="cancel-btn"
                                      @click.native="batchRemovesure">
                                <span v-if="!loading">确认</span>
                                <span v-else>正在删除…</span>
                            </i-button>
                        </i-col>
                    </row>
                </i-form>
            </div>
        </modal>
    </div>
</template>