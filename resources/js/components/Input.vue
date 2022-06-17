<template>
    <div style="position: relative; align-items: center; display: flex;">
        <input class="form-control form-control-lg outline-text"
               :class="[
                   { 'input-error': errorInfoText !== '' },
                   { 'input-error-little': little === true },
               ]"
               v-model="value"
               :maxlength="maxlength"
               :type="type"
               :oninput="oninput"
               @focus="errorInfoText = ''; visible = false;">
        <svg v-if="errorInfoText !== ''" @click="visible ^= true;" viewBox="0 0 32 32" style="position: absolute; right: 5px;" width="22" height="32" xmlns="http://www.w3.org/2000/svg"><path fill="#E64825" d="M28.83,24.45l-12-18a1,1,0,0,0-1.66,0l-12,18a1,1,0,0,0,0,1A1,1,0,0,0,4,26H28a1,1,0,0,0,.88-.53A1,1,0,0,0,28.83,24.45Z"/><path fill="white" d="M16,20a1,1,0,0,1-1-1V13a1,1,0,0,1,2,0v6A1,1,0,0,1,16,20Z"/><path fill="white" d="M16,23a1,1,0,0,1-1-1,1,1,0,0,1,2,0A1,1,0,0,1,16,23Z"/></svg>
        <div class="error-info" v-if="visible && errorInfoText !== ''">
            <span>{{ errorInfoText }}</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "Input",

    props: ['maxlength', 'type', 'oninput', 'little'],

    data: () => ({
        visible: false,
        errorInfoText: '',
        value: ''
    }),
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

.input-error-little {
    min-height: 0;
    max-height: 30px;
}

.outline-text:focus {
    border-color: #5374D1;
}

.input-error {
    border-color: #E64825;
    padding-right: 32px;
}

.error-info {
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

