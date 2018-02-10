import scan from './scan'

const components = [
  scan
]
const install = function (Vue, opts = {}) {
  components.map(component => {
    Vue.component(component.name, component)
  })
}

export default install
