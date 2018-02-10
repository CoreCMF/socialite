<script>
import QRious from 'qrious'
export default {
  name: 'qrcode-item',
  props: {
    /*
     * The value of the qrcode.
     */
    value: {
      type: String,
      required: true
    },
    /*
     * The options for the qrcode generator.
     * {@link https://github.com/lindell/JsQrcode#options}
     */
    config: {
      type: Object
    },

    /*
     * The tag of the component root element.
     */
    tag: {
      type: String,
      default: 'canvas'
    }
  },
  render (createElement) {
    return createElement(this.tag, this.$slots.default)
  },
  watch: {
    /*
     * Update qrcode when value change
     */
    value () {
      this.generate()
    },
    /*
     * Update qrcode when config change
     */
    config () {
      this.generate()
    }
  },
  mounted () {
    this.generate()
  },
  methods: {
    /**
     * Generate qrcode
     */
    generate () {
      let qr = new QRious({element: this.$el})
      qr.set(Object.assign({
        value: this.value
      }, this.config))
    }
  }
}
</script>
