<script>
    export default {
        beforeRouteEnter(to, from, next) {
            next(() => {
            });
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="organization-manager">
            <tabs value="name1">
                <tab-pane label="组织管理" name="name1">
                    <card :bordered="false">

                    </card>
                </tab-pane>
            </tabs>
        </div>
    </div>
</template>