<template>
    <div class="modal slide-up" role="dialog">
    <div class="modal-background" @click="hideSelf()"></div>
      <v-scrollbar class="modal-content" :style="sizeStyle">
        <div v-if="$props.showHeader" class="modal-card-head">
          <button type="button" class="modal-close" @click.prevent="hideSelf">
            <i class="ti ti-close"></i>
          </button>
          <h4 class="modal-card-title">
            <slot name="modal-title"></slot>
          </h4>
        </div>
        <div class="modal-card-body">
          <button v-if="!$props.showHeader" type="button" class="modal-close" @click.prevent="hideSelf">
            <i class="ti ti-close"></i>
          </button>
          <slot name="modal-image"></slot>
          <slot></slot>
        </div>
        <div v-if="$slots['modal-footer']" class="modal-card-foot">
          <slot name="modal-footer">
           </slot>
        </div>
      </v-scrollbar>
    </div>
</template>

<script>
  import vScrollbar from 'vue-perfect-scrollbar';

  export default {
    name: 'Modal',
    components: {vScrollbar},
    props: ['show', 'showHeader', 'size'],
    data () {
      return {
      };
    },
    computed: {
      sizeStyle() {
        const {size} = this.$props;
        return {
          width: (size == "sm" ? 300 + 'px' : ''),
        }
      }
    },
    watch : {
       show() {
          this.show ? this.showSelf() : this.hideSelf();
       }
    },
    methods: {
      showSelf () {
          // $('.modal').modal({backdrop: 'static'});
          $(this.$el).addClass('is-active');
          $('body, html').addClass('is-clipped');
      },
      toggleSelf() {
          $(this.$el).toggleClass('is-active');
          $('body, html').toggleClass('is-clipped');
      },
      hideSelf() {
        $(this.$el).removeClass('is-active');
        $('body, html').removeClass('is-clipped');
        
        this.$emit('closed');
      }
    }
  };
</script>
