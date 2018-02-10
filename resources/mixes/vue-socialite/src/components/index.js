import scan from './scan'
import QrcodeItem from './qrcode-item'

const components = [
  QrcodeItem,
  scan
]
const install = function (Vue, opts = {}) {
  components.map(component => {
    Vue.component(component.name, component)
  })
}

export default install
