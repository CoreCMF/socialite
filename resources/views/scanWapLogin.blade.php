
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
</head>
<body>
    <div id=app class="scanqWap">
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
    <script type=text/javascript src={{ asset('/js/vue.js') }}></script>
    <script type=text/javascript src={{ asset('/vendor/socialite/js/iconfont.js') }}></script>
    <script type="text/javascript">
        var Main = {
            data() {
              return {
                  socialite: {
                      @if (!empty($socialite))
                        @foreach ($socialite as $service => $url)
                                {{ $service }}: "{{ $url }}",
                        @endforeach
                      @endif
                  },
              };
            },
            mounted() {
                this.init()
            },
            methods: {
              init() {
                  console.log(this.socialite);
              }
            }
          };
        var Ctor = Vue.extend(Main)
        new Ctor().$mount('#app')
    </script>

</body>
</html>
