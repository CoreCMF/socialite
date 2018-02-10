// 引入依赖
import builderVue from 'builder-vue'
// 引用
import Socialite from './components'
import BuilderVueElement from 'builder-vue-element'

builderVue.Vue.use(Socialite)
builderVue.Vue.use(BuilderVueElement)

// 启动自动构建
builderVue.start()
