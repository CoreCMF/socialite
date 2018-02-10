<template>
<div id=app class="qrcode">
    <div class="main">
        <div id="qrcode" class="qrcode"></div>

        <div class="state">
            使用手机扫码登录
        </div>
    </div>
</div>
</template>

<script>
export default {
  name: 'socialite-scan',
  computed: {
    apiUrl () {
      return this.$route.meta.apiUrl
    }
  },
  methods: {
    initData () {
      let apiUrl = this.apiUrl
      let thenFunction = (Response) => {
        console.log(Response)
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
body{
  margin: 0;
}
.qrcode {
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
	background-color: #909399;
	position: absolute;
	width: 100%;
	height: 100%;
    >.main {
    	border-radius: 4px;
    	background-color: #FFF;
    	padding: 30px
    }
    >.state {
    	margin-top: 15px;
    	border-radius: 4px;
    	background-color: #F56C6C;
    	color: #FFF;
    	padding: 20px;
    	border: 1px solid #E4E7ED;
    	text-align: center
    }
}

</style>
