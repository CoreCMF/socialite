
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
    <link href={{ asset('/vendor/socialite/css/app.css') }} rel=stylesheet>
    <script>
        window.config = {
            userId: {{ empty(Auth::id())? 0: Auth::id()  }},
@if (!empty($resources['config']))
  @foreach ($resources['config'] as $key => $config)
          {{ $key }}: {!! json_encode($config) !!},
  @endforeach
@endif
        }
    </script>
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
            <div v-else>
                <div id="qrcode"></div>
            </div>
            <div class="state">
                使用手机扫码登录
            </div>
        </div>
    </div>
    <!-- 渲染插件Js Begin -->
@if (!empty($resources['js']))
  @foreach ($resources['js'] as $js)
  <script type=text/javascript src={{ $js }}></script>
  @endforeach
@endif
  <!-- 渲染插件Js End -->
    <script type=text/javascript src={{ asset('/js/vue.js') }}></script>
    <script type=text/javascript src={{ asset('/js/qrcode.js') }}></script>
    <script type=text/javascript src={{ asset('/js/echo.js') }}></script>
    <script type=text/javascript src={{ asset('/js/lodash.js') }}></script>
    <script type="text/javascript">
        var Main = {
            data() {
              return {
                  QRcode: null,
                  state: false,
                  echo:null
              };
            },
            mounted() {
                this.init()
            },
            methods: {
              init() {
                  this.qrcode()
                  this.initEcho()
                  this.broadcastHandler()
              },
              qrcode() {
                  new QRCode(document.getElementById("qrcode"), {
                      text: window.config.QRcode,
                      width: 320,
                      height: 320
                  })
              },
              initEcho() {
                  let options = {
                    broadcaster: window.config.broadcast.broadcaster,
                    host: window.config.broadcast.host
                  }
                  this.echo = new Echo(options)
              },
              getEventHandlers () {
                return {
                  'CoreCMF\\Socialite\\App\\Events\\LoginBroadcasting': response => {
                    if (response.state) {
                      _.forIn(response.token, (value, name) => {
                        localStorage.setItem(name, value)
                      })
                      location.href = window.config.redirect
                    } else {
                      this.state = true
                    }
                  }
                }
              },
              broadcastHandler () {
                let broadcast = window.config.broadcastOptions
                let Echo
                switch (broadcast.type) {
                  case 'channel':
                    Echo = this.echo.channel(broadcast.channel)
                    break
                  case 'private':
                    Echo = this.echo.private(broadcast.channel)
                    break
                }
                _.forIn(this.getEventHandlers(), (handler, eventName) => {
                  Echo.listen(`.${eventName}`, response => handler(response))
                })
              }
            }
          };
        var Ctor = Vue.extend(Main)
        new Ctor().$mount('#app')
    </script>

</body>
</html>
