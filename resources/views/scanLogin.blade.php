
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LaravelVue</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ config('website.icon') }}">
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href={{ asset('/vendor/socialite/other/css/app.css') }} rel=stylesheet>
</head>
<body>
    <div id=app class="qrcode">
        <div class="main">
            <div
              v-if="state"
              class="scanSuccess"
            >
                <i class="fa fa-check-circle"></i>
                <span>扫描成功</span>
            </div>
            <div
             v-else
             id="qrcode"
            >
            </div>
            <div class="state">
                使用手机扫码登录
            </div>
        </div>
    </div>
    <script type=text/javascript src={{ asset('/js/webpackJsonp.js') }}></script>
    <script type=text/javascript src={{ asset('/js/vue.js') }}></script>
    <script type=text/javascript src={{ asset('/js/qrcode.js') }}></script>
    <script type=text/javascript src={{ asset('/js/echo.js') }}></script>
    <script type=text/javascript src={{ asset('/vendor/socialite/other/js/iconfont.js') }}></script>
    <script type="text/javascript">
        var Main = {
            data() {
              return {
                  QRcode: "{{$QRcode}}",
                  state: false
              };
            },
            mounted() {
                this.init()
            },
            methods: {
              init() {
                new QRCode(document.getElementById("qrcode"), {
                	text: this.QRcode,
                	width: 320,
                	height: 320
                })
              }
            }
          };
        var Ctor = Vue.extend(Main)
        new Ctor().$mount('#app')
    </script>

</body>
</html>
