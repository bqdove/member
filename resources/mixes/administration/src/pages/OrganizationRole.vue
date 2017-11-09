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
                        key: 'id',
                        title: 'ID',
                    },
                    {
                        align: 'center',
                        key: 'name',
                        title: '角色名称',
                    },
                    {
                        align: 'center',
                        key: 'authority',
                        title: '权限值',
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
                        title: '功能1',
                        children: [
                            {
                                expand: false,
                                title: '功能 1-1',
                                children: [
                                    {
                                        expand: false,
                                        title: '功能 1-1-1',
                                        children: [
                                            {
                                                title: '功能 1-1-1-1',
                                            },
                                            {
                                                title: '功能 1-1-1-2',
                                            },
                                        ],
                                    },
                                    {
                                        title: '功能 1-1-2',
                                    },
                                ],
                            },
                            {
                                expand: false,
                                title: '功能 1-2',
                                children: [
                                    {
                                        title: '功能 1-2-1',
                                    },
                                    {
                                        title: '功能 1-2-1',
                                    },
                                ],
                            },
                        ],
                    },
                ],
                filterWord: '1',
                form: {
                    email: '532462837@qq.com',
                    e_mail: '5376@qiye.com',
                    name: '姓名',
                    phone: 1352637247,
                    user_name: 'hsfdius',
                },
                list: [
                    {
                        authority: 111,
                        id: '5435',
                        name: '角色1-1',
                    },
                    {
                        authority: 110,
                        id: '5436',
                        name: '角色1-2',
                    },
                    {
                        authority: 119,
                        id: '5437',
                        name: '角色1-3',
                    },
                    {
                        authority: 118,
                        id: '5438',
                        name: '角色1-4',
                    },
                    {
                        authority: 117,
                        id: '5439',
                        name: '角色1-5',
                    },
                    {
                        authority: 116,
                        id: '5430',
                        name: '角色1-6',
                    },
                    {
                        authority: 115,
                        id: '5431',
                        name: '角色1-7',
                    },
                    {
                        authority: 114,
                        id: '54351',
                        name: '角色1-1',
                    },
                    {
                        authority: 113,
                        id: '54352',
                        name: '角色1-1',
                    },
                    {
                        authority: 111,
                        id: '54353',
                        name: '角色1-1',
                    },
                ],
                modal1: false,
                modal2: false,
                modalLook: false,
                organizationName: '',
                selection: [],
            };
        },
        methods: {
            changeTreeSelect(data) {
                this.organizationName = data[0].title;
            },
            selectionChange(selection) {
                const self = this;
                self.selection = selection;
            },
            submitCancel(data) {
                if (data === 1) {
                    this.modal1 = false;
                }
                if (data === 2) {
                    this.modal2 = false;
                }
            },
        },
        mounted() {
            this.organizationName = this.departmentList[0].title;
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="organization-user show-checkbox">
            <tabs value="name1">
                <tab-pane label="角色管理" name="name1">
                    <card :bordered="false">
                        <div class="top-btn-action">
                            <router-link to="/member/organization/user/create">
                                <i-button class="btn-action" type="ghost">+新增角色</i-button>
                            </router-link>
                            <i-button class="btn-action" type="ghost">编辑</i-button>
                            <i-button class="btn-action" type="ghost">删除</i-button>
                        </div>
                        <row>
                            <i-col span="12" class="left-col-span">
                                <i-table :columns="columns"
                                         class="table-list"
                                         :data="list"
                                         height="518"
                                         ref="list"
                                         highlight-row>
                                </i-table>
                            </i-col>
                            <i-col span="12">
                                <div class="depart-expand-tree">
                                    <h5>权限设置</h5>
                                    <tree :data="departmentList"
                                          show-checkbox
                                          @on-select-change="changeTreeSelect"></tree>
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
        <modal
                v-model="modalLook"
                title="查看详细信息" class="setting-modal-delete user-detail-message">
            <div>
                <i-form ref="form" :model="form" :label-width="160">
                    <row>
                        <i-col>
                            <form-item label="用户名">
                                <span>{{ form.user_name }}</span>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col>
                            <form-item label="姓名">
                                <span>{{ form.name }}</span>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col>
                            <form-item label="个人邮箱">
                                <span>{{ form.email }}</span>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col>
                            <form-item label="企业邮箱">
                                <span>{{ form.e_mail }}</span>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col>
                            <form-item label="手机">
                                <span>{{ form.phone }}</span>
                            </form-item>
                        </i-col>
                    </row>
                </i-form>
            </div>
        </modal>
    </div>
</template>