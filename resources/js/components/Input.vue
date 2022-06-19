<template>
    <div style="position: relative; align-items: center; display: flex;">
        <input
            class="form-control form-control-lg outline-text"
            :class="[
               { 'input-error': errorInfoText !== '' }
            ]"
            @input="changePageTitle($event.target.value)"
            :value="title == null ? value : title"
            @change="$emit('change', $event.target.value)"
            :maxlength="maxlength"
            :type="type"
            :oninput="oninput"
            @focus="errorInfoText = ''; visible = false;"
            ref="input">
        <svg v-if="errorInfoText !== ''" @click="visible ^= true;" viewBox="0 0 32 32" style="position: absolute; right: 5px;" width="22" height="32" xmlns="http://www.w3.org/2000/svg"><path fill="#E64825" d="M28.83,24.45l-12-18a1,1,0,0,0-1.66,0l-12,18a1,1,0,0,0,0,1A1,1,0,0,0,4,26H28a1,1,0,0,0,.88-.53A1,1,0,0,0,28.83,24.45Z"/><path fill="white" d="M16,20a1,1,0,0,1-1-1V13a1,1,0,0,1,2,0v6A1,1,0,0,1,16,20Z"/><path fill="white" d="M16,23a1,1,0,0,1-1-1,1,1,0,0,1,2,0A1,1,0,0,1,16,23Z"/></svg>
        <div class="error-info" ref="errorInfo" v-show="visible && errorInfoText !== ''">
            <span>{{ errorInfoText }}</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "Input",

    data: () => ({
        value: '',
        visible: false,
        errorInfoText: '',
    }),

    props: {
        height: {default: 40},
        maxlength: String,
        type: String,
        oninput: String,
        title: String
    },

    methods: {
        changePageTitle(title) {
            this.$emit('update:title', title);
            this.value = title;
        }
    },

    mounted() {
        this.$refs.input.style.minHeight = this.height + 'px';
        this.$refs.input.style.height = this.height + 'px';
        this.$refs.errorInfo.style.top = (this.height / 2 + 16) + 'px';
    },

}
</script>

<style lang="scss" scoped>
strong {
    font-weight: 600;
}

input:focus {
    border-color: #5374D1;
    box-shadow: inherit;
}

.outline-text {
    font-size: 16px;
    height: 35px;
}

.outline-text:focus {
    border-color: #5374D1;
}

.input-error {
    border-color: #E64825;
    padding-right: 32px;
}

.error-info {
    z-index: 1;
    max-width: 180px;
    font-size: 12px;
    padding: 8px;
    position: absolute;
    right: 5px;
    top: 37px;
    background-color: white;
    color: #E64825;
    border-radius: 2px;
    box-shadow: 0 0 5px #B2B2B2;
    display: flex;
    align-items: center;
}
.error-info:after {
    width: 0;
    height: 0;
    right: 7px;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-bottom: 8px solid white;
    position: absolute;
    content: '';
    top: -8px;
}
</style>

