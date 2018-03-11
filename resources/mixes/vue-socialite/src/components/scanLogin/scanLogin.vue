<template>
<div class="scanqWap">
    <div class="main">
        <a v-for="(url,service) in socialite" :href="url">
            <svg class="icon" aria-hidden="true">
                <use :xlink:href="'#icon-' + service"></use>
            </svg>
        </a>
        <div class="state">
            请选择登录方式
        </div>
    </div>
</div>
</template>

<script>
export default {
  name: 'socialite-scanLogin',
  data () {
    return {
      socialite: null
    }
  },
  computed: {
    apiUrl () {
      return this.$route.meta.apiUrl
    }
  },
  methods: {
    initData () {
      let apiUrl = this.apiUrl
      let thenFunction = (Response) => {
        this.socialite = Response.data.config.socialite
      }
      this.$store.dispatch('getData', {apiUrl, thenFunction})
    }
  },
  mounted () {
    this.initData()
  }
}
</script>
<style lang="scss">
.scanqWap {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: #fff;
    position: absolute;
    width: 100%;
    height: 100%
}
.scanqWap .main {
	border-radius: 4px;
	background-color: #FFF;
	padding: 30px
}
.scanqWap .main svg{
	width: 21vw;
    height: 21vw;
}
.scanqWap .state {
	margin-top: 15px;
	border-radius: 4px;
	background-color: #F56C6C;
	color: #FFF;
	padding: 20px;
	border: 1px solid #E4E7ED;
	text-align: center
}
</style>
