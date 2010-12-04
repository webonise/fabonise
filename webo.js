var appId = "133576213366250";
var checkLogin = true;
var enableCookie = true;
var useXFBML = true;


function initSyncronously(){
    FB.init({
        appId  : appId,
        status : checkLogin, // check login status
        cookie : enableCookie, // enable cookies to allow the server to access the session
        xfbml  : useXFBML  // parse XFBML
    });

    if(checkLogin == true){
        // checkFBLogin();
        checkFBLoginWithPermissions();
    }
}

function initAsyncronosly(){
    window.fbAsyncInit = function() {
        FB.init({
            appId: appId,
            status: checkLogin,
            cookie: enableCookie,
            xfbml: useXFBML
        });
    };
    (function() {
        var e = document.createElement('script');
        e.async = true;
        e.src = document.location.protocol +
        '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
    }());

}

function checkFBLogin(){
    
    FB.getLoginStatus(function(response) {
        if (response.session) {
            
            publishStreamToFB();
        } else {
            alert('no user session available, someone you dont know');
            askForLogin();
        }
    });

}

function checkFBLoginWithPermissions(){
    

    FB.login(function(response) {
        if (response.session) {
            if (response.perms) {
                // user is logged in and granted some permissions.
                // perms is a comma separated list of granted permissions
                publishStreamToFB();
            } else {
        // user is logged in, but did not grant any permissions
        }
        } else {
    // user is not logged in
    }
    }, {
        perms:'read_stream,publish_stream,offline_access,sms'
    });


}

function askForLogin(){
    FB.login(function(response) {
        if (response.session) {
            // alert(response.session); // user successfully logged in
            publishStreamToFB();

        } else {
            alert("not logged in");
        // user cancelled login
        }
    });

}

function logoutMe(){
    FB.logout(function(response){
        alert(response)
    });
}

function publishStreamWithFBPopUp(){
    alert('ok');
    FB.ui(
    {
        method: 'stream.publish',
        attachment: {
            name: 'MyApp',
            caption: 'My app posting on FB',
            description: (
                'Just test the app'
                ),
            href: 'http://weboniselab.com/'
        },
        action_links: [
        {
            text: 'weboniselab',
            href: 'http://weboniselab.com/'
        }
        ]
    },
    function(response) {
        if (response && response.post_id) {
            alert('Post was published.');
        } else {
            alert('Post was not published.');
        }
    }
    );

}

function publishStreamToFB(){

    var body = 'GEEK HOURS... With some apps->code & code->apps & code & apps & code ........ .';

    FB.api('/me/feed', 'post', {
        message: body
    }, function(response) {
        if (!response || response.error) {
            alert('Error occured'+response.error);
        } else {
            alert('Post ID: ' + response.id);
        }
    });

}
