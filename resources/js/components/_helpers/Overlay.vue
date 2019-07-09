<template>
    <div class="loading-container" :style="compact ? 'position: absolute;' : ''">
        <div class="loading-backdrop" :style="compact ? 'position: relative;' : ''"></div>
        <div class="loading" :style="compact ? 'position: absolute;' : ''">
            <div class="loading-icon">
                <img src="@/assets/loader.gif" v-if="!url && !html" />
                <img :src="url" v-if="url" />
                <div v-if="!url && html" v-html="html"></div>
            </div>
            <div class="loading-label">{{message}}</div>
        </div>
    </div>
</template>

<script>
export default {
  name: 'Overlay',
  props: ['message', 'url', 'html', 'compact']
}
</script>

<style lang="scss" scoped>
.loading-container {
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    width: 100%;
    height: 100%;

    min-height: 200px;

    text-align: center;

    .loading-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: dimgrey;
        opacity: 0.5;
        z-index: 9998;
    }

    .loading {
        z-index: 9999;
        position: fixed;
        display: inline-block;
        /*background-color: white;*/
        padding: 20px 50px;
        /*border-radius: 12px;*/
        /*box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);*/
        left: 50%;
        top: 50%;
        -ms-transform: translate(-50%,-50%);
        -moz-transform: translate(-50%,-50%);
        -webkit-transform: translate(-50%,-50%);
        transform: translate(-50%,-50%);

        .loading-icon {
            margin-bottom: 8px;
        }
    }
}
</style>
