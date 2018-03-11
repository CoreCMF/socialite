import QrcodeItem from './qrcode-item'
import scan from './scan'
import scanLogin from './scanLogin'

const components = [
  QrcodeItem,
  scan,
  scanLogin
]
const install = function (Vue, opts = {}) {
  components.map(component => {
    Vue.component(component.name, component)
  })
}

export default install
