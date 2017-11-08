<script>
    export default {
        beforeRouteEnter(to, from, next) {
            next(() => {
            });
        },
        data() {
            return {
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

                            </i-col>
                            <i-col span="12"></i-col>
                        </row>
                    </card>
                </tab-pane>
            </tabs>
        </div>
    </div>
</template>