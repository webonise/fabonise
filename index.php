<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Fabonise: KickEm</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <style>
            a.kickAss {
                background: url("kickEm.png") no-repeat scroll 0 0 transparent;
                cursor: pointer;
                display: block;
                /*float: left;*/
                height: 20px;
                margin: 5px 0;
                text-indent: -9999px;
                width: 80px;

            }

            .nameWrapper {
               /*display: block;
               text-align: left;
               float: left;*/
               height: 150px;
            }
            
            .fb_link {
                 /*float: left;*/
                 outline: none;
                 
            }
            
        </style>
    </head>
    <body>
        <div id="fb-root"></div>

        <script src="http://connect.facebook.net/en_US/all.js"></script>
        <script>

            //var appId = "133576213366250";
            var appId = '181813861833867';//'181813861833867;
            var checkLogin = true;
            var enableCookie = true;
            var useXFBML = true;

            //FB.Canvas.setSize({ width: 640, height: 20000 }); // Live in the past

            function WeboCheckFBLoginWithPermissions(){
                
                FB.login(function(response) {
                    
                    if (response.session) {
                        
                        if (response.perms) {
                            
                            // user is logged in and granted some permissions.
                            // perms is a comma separated list of granted permissions
                            // publishStreamWithFBPopUp('Fabonise', 'Webonise app interacting FB', 'Webo App', 'http://www.weboniselab.com');
                            //publishStreamToFB('awesome evening with geeks coding.debugging.testing.oh.yes.itsworking -> apps -> :)');
                            //postOnFriendWall();
                            
                            WeboShowMyFriends();

                            getUserInfo();                            
                        } else {
                            // user is logged in, but did not grant any permissions
                            
                        }
                    } else {
                        // user is not logged in
                    }
                }, {perms:'read_stream,publish_stream,offline_access,sms'});


            }

            /*function WeboAskForLogin(){
                
                FB.login(function(response) {
                    if (response.session) {
                        // alert(response.session); // user successfully logged in
                        //publishStreamToFB('awesome evening with geeks coding.debugging.testing.oh.yes.itsworking -> apps -> :)');
                        WeboInviteMyFriends();
                    } else {
                        alert("not logged in");
                        // user cancelled login
                    }
                });

            }*/

            function WeboLogoutMe(){
                FB.logout(function(response){alert(response)});
            }

            function publishStreamWithFBPopUp(AppName,captionText,describeApp, AppLink){//alert('ok');
                FB.ui(
                {
                    method: 'stream.publish',
                    attachment: {
                        name: AppName,
                        caption: captionText,
                        description: (
                        describeApp
                    ),
                        href: AppLink
                    },
                    action_links: [
                        { text: AppName, href:AppLink }
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

            function getUserInfo(){

                FB.api('/me/', function(response) {
                    //alert(response.name);

                    document.getElementById('userName').innerHTML = response.name;
                });
            }

            function WeboPublishStreamToFB(text){

                var body = text;
                
                FB.api('/me/feed', 'post', { message: body }, function(response) {
                    if (!response || response.error) {
                        //alert('Error occured'+response.error);
                    } else {
                        //alert('Post ID: ' + response.id);
                        alert('You just kicked your friend.');
                    }
                });

            }

            function WeboShowMyFriends(){
                FB.api('/me/friends/', function(response) {
                    //alert(response);
                    
                    var outstring = '<p><b>Your Friends :</b></p><p>&nbsp;</p><table><tr>';
                    var j = 1;
                    
                    for (var i=0, l=response.data.length; i<l; i++) {
                        
                        var friend = response.data[i];                        
                        
                        outstring = outstring + '<td class = "nameWrapper" align="left" nowrap ><fb:profile-pic uid="' + friend.id + '"/></fb:profile-pic>\n\
                                                 <div id ="imageCSS"><a href="javascript:;" class ="kickAss" onclick = "javascript:postMsgOnWall('+friend.id+');">&nbsp;</a></div>   <br/>\n\
                                                <fb:name uid="' + friend.id + '" /></fb:name><br/><br/><br/></td>'

                        if(j%3 == '0'){
                                                    
                            outstring = outstring + "</tr><tr>";
                        }
                        j++;
                    }
                    outstring = outstring + '</tr></table>';
                    
                    //alert(outstring);
                    
                    document.getElementById('myFriendList').innerHTML = outstring;
                    
                    FB.XFBML.parse(document.getElementById('myFriendList'));
                    //alert(friendsList);
                });

            }


            function WeboInitSyncronously(){
                FB.init({
                    appId  : appId,
                    status : checkLogin, // check login status
                    cookie : enableCookie, // enable cookies to allow the server to access the session
                    xfbml  : useXFBML  // parse XFBML
                });

                if(checkLogin == true){
                    // checkFBLogin();
                    WeboCheckFBLoginWithPermissions();
                    
                }
            }

            function postOnFriendWall(friendId, msg){
                //var body = text;

                FB.api('/'+friendId+'/feed', 'post', { message: msg }, function(response) {
                    if (!response || response.error) {
                        //alert('Error occured'+response.error);
                    } else {
                        //alert('Post ID: ' + response.id);
                        alert('You just kicked your friend.');
                    }
                });
            }

            function postMsgOnWall(friendId){

                var msg = 'has just kicked you. Wanna  kick emm back..?';
                
                postOnFriendWall(friendId, msg);
            }

            /*function WeboInitAsyncronosly(){
                window.fbAsyncInit = function() {
                    FB.init({appId: appId, status: checkLogin, cookie: enableCookie,
                        xfbml: useXFBML});
                };
                (function() {
                    var e = document.createElement('script'); e.async = true;
                    e.src = document.location.protocol +
                        '//connect.facebook.net/en_US/all.js';
                    document.getElementById('fb-root').appendChild(e);
                }());

            }*/

            WeboInitSyncronously();
        </script>

        <table>
            <tr>
                <td colspan="4">
                    Hello <span id="userName"></span>,<br/><br/>
                    <b>Welcome to KickEmm.</b>
                </td>
            </tr>
        </table>


        <div id="myFriendList"></div>
    </body>
</html>
