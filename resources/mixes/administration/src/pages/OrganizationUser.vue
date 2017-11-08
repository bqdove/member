<script>
    export default {
        beforeRouteEnter(to, from, next) {
            next(() => {
            });
        },
        data() {
            return {
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
            };
        },
        methods: {},
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
                                222
                            </i-col>
                        </row>
                    </card>
                </tab-pane>
            </tabs>
        </div>
    </div>
</template>