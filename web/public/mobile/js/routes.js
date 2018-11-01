
routes = [
  {
    path: '/',
    url: './index.html',
  },
  {
    path: '/info/:id/',
    templateUrl: './pages/info.html',
    async: function (routeTo, routeFrom, resolve, reject) {
        var router = this;
        var app = router.app;
        var zoneId = routeTo.params.id;
        app.preloader.show('green');

        app.request.json(baseUrl + 'session/list/' + zoneId, function (data) {
            var zone = {
             title : data['zone'].title,
             capacity : data['zone'].capacity,
             sessions: data['sessions']
         };
         app.preloader.hide();
         resolve(
                 {
                     componentUrl: './pages/info.html'
                 },
                 {
                     context: {
                         zone: zone
                     }
                 }
            );
        });
    },
  },
  {
    path: '/form/:id/',
    templateUrl: './pages/form.html',
    async: function (routeTo, routeFrom, resolve, reject) {
        var router = this;
        var app = router.app;
        var zoneId = routeTo.params.id;

        app.preloader.show('green');

        app.request({
            url: baseUrl + 'session/create/' + zoneId,
            dataType: 'json',
            //async: false,
            beforeSend : function(xhr){
                xhr.setRequestHeader('token', localStorage.getItem("user_token"));
            },
            success: function (data) {
                var zone = data['zone'];
                var session = data['session'];
                app.preloader.hide();

                resolve(
                    {
                        componentUrl: './pages/form.html',
                    },
                    {
                        context: {
                            zone: zone,
                            session : session
                        }
                    }
                );
            },
            error: function (xhr, status){
                alert(status);
            }
        });



    },
  },

  {
    path: '(.*)',
    url: './pages/404.html',
  },
];
