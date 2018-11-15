<template>
    <button class="wg-hrb" @mouseover="mouseover" @mouseout="mouseleave" 
        @click="$emit('click', isOpen)" :style="{width: `${width}px`}">
        <span class="hrb__wrap">
            <span class="hrb__icon">
                <slot name="icon"></slot>
            </span>
            <span class="hrb__text">
                <slot name="text"></slot>
            </span>
        </span>
    </button>
</template>

<style scoped>
    .wg-hrb {
        height: 40px;
        width: 40px;
        overflow: hidden;
        padding: 0;
        white-space: nowrap;
        line-height: 30px;
        background: #e9e9e9;
        border-radius: 30px;
        border: none;
    }
    
    * {
        transition: all .3s cubic-bezier(0.01, 0.78, 0.49, 0.96);
    }
    
    .wg-hrb:hover .hrb__text {
        opacity: 1;
        transform: translateX(0);
    }

    /* ICON selector */
    .wg-hrb .hrb__icon {
        width: 30px;
        display: inline-block;
        line-height: inherit;
        height: 30px;
        text-align: center;
        margin-left: 5px;
        border-radius: 30px;
    }
    .wg-hrb .hrb__text {
        opacity: 0;
        padding-right: 10px;
        transform: translateX(50%);
    }
</style>

<script>
export default {
    name: 'HoverRevealButton',
    /**
     * @type <Array['string', toggleIcons: {open, close}]>
     */
    props: ['text'],
    data() {return {
        isOpen: false,
        width: 40,
    }},
    methods: {
        mouseover() {
            const {elm: button} = this.$vnode;
            this.$set(this, 'width', button.querySelector('.hrb__wrap').offsetWidth);
        },
        mouseleave() {
            const {elm: button} = this.$vnode;            
            this.width = 40;
        }
    },
    computed: {
        show() { 
            const {toggleIcons} = this.$props;
            this.isOpen ? toggleIcons.open : toggleIcons.close ;
        }
    } 
}
</script>

