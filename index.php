<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Dev App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
      .cursor {
          cursor: pointer;
      }
    </style>
    <link href="/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/img/favicon.ico">
    <link rel="apple-touch-icon" href="/img/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/apple-touch-icon-114x114.png">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    
  </head>

  <body>
    <div id="fb-root"></div>

	<script>
      // Load the SDK Asynchronously
      (function(d){
         var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         ref.parentNode.insertBefore(js, ref);
       }(document));

      // Init the SDK upon load
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '349351001818181', // App ID
          channelUrl : '//'+window.location.hostname+'/channel', // Path to your Channel File
          status     : true, // check login status
          cookie     : true, // enable cookies to allow the server to access the session
          xfbml      : true,  // parse XFBML
          oauth      : true
        });

        // listen for and handle auth.statusChange events
        FB.Event.subscribe('auth.statusChange', function(response) {
          if (response.authResponse) {
            // user has auth'd your app and is logged into Facebook

          } else {
              var oauth_url = 'https://www.facebook.com/dialog/oauth/';
              oauth_url += '?client_id=349351001818181';
              oauth_url += '&redirect_uri=' + encodeURIComponent('http://apps.facebook.com/storygenerator/');
              oauth_url += '&scope=publish_actions'
              window.top.location = oauth_url;
          }
        });
      } 
    </script>

    <div class="container">

      <hr>
      
      <h1>FB OG Stories</h1>
      
      <label>Message</label>
      <textarea rows="3" id="message" style="width:100%"></textarea>
      <p>Example: Im make a pact to eat more cookies and @[http://www.facebook.com/elina.stuzo] is holding me to it.</p>
      <p>Do not use special characters</p>

      <label>Action Tag</label>
      <input id="actionTag" />
      <p>Enter a FB Id. 100002563635938 for Joe</p>
      
      <label>Story Url</label>
      <input id="url" />
      <p>Enter the story URL.  Example: 200</p>
      <p>If you want a new story send <a href="mailto:Jonathan.Belcher@stuzo.com">Jon</a> or <a href="mailto:josh.skaroff@stuzo.com">Josh</a> an image and the following tags:</p>
      <ul>
        <li>Description</li>
        <li>Title</li>
      </ul>
      
      
      <button id="poststory" class="btn-success">Post OG Story</button></br></br>
      <button id="poststoryusergenerated" class="btn-success">Post OG User Generated PhotoStory</button></br></br>
      <button id="postimage" class="btn-success">Post Photo to Timeline</button>
      <p>Mention/Action tags do not work with post photo</p>
      
      <button id="postimagefromfb" class="btn-success">Post Photo to Timeline</button></br></br>

      <button id="postflashapp" class="btn-success">Post Flash App to Timeline</button>
      
      <h3>Current Story URLs</h3>
      <a href="userimages/200.html">200</a><br />
      <a href="userimages/201.html">201</a><br />
      <a href="userimages/202.html">202 For use with Flash App</a><br />
      <a href="userimages/203.html">203 For use with Flash App</a><br />
      <a href="userimages/300.html">300 A Venus POME postcard</a><br />
      <script type="text/javascript">
        $(function(){ 
            $("#poststory").on("click", function(event) {
            //Post Story
            FB.api('/me/storygenerator:created?',
                'post', 
                { 
                  story : 'http://floating-reaches-3088.herokuapp.com/userimages/'+$('#url').attr("value")+'.html', 
                  message : $('#message').attr("value"),
                  picture : 'http://floating-reaches-3088.herokuapp.com/userimages/'+$('#url').attr("value")+'.jpg',
                  tags : $('#actionTag').attr("value"),
                  explicitly_shared : "true"
                }, function(response) {
                      if (!response || response.error) {
                          alert(response.error.message);
                      } 
                      else {
                          alert('Post was successful! Action ID: ' + response.id);
                      } 
                  }
              );
            });
        });
        
        
        $(function(){ 
            $("#poststoryusergenerated").on("click", function(event) {

            FB.api('/me/storygenerator:created?',
                'post', 
                { 
                  story : 'http://floating-reaches-3088.herokuapp.com/userimages/'+$('#url').attr("value")+'.html', 
                  message : $('#message').attr("value"),
                  "image:url" : 'http://floating-reaches-3088.herokuapp.com/userimages/'+$('#url').attr("value")+'.jpg',
                  "image:user_generated" : 'true',
                  tags : $('#actionTag').attr("value")
                }, function(response) {
                      if (!response || response.error) {
                          alert(response.error.message);
                      } 
                      else {
                          alert('Post was successful! Action ID: ' + response.id);
                      } 
                  }
              );

            });
        });
        
        $(function(){ 
            $("#postimage").on("click", function(event) {
              FB.api('/me/photos',
                  'post', 
                  { 
                    message : $('#message').attr("value"),
                    url: 'http://floating-reaches-3088.herokuapp.com/userimages/'+$('#url').attr("value")+'.jpg',
                    fb: "explicitly_shared=true"
                  }, function(response) {
                        if (!response || response.error) {
                            alert(response.error.message);
                        }
                        else {
                          alert('Post was successful! Action ID: ' + response.id);
//                          var postId = response.id;
//                          FB.api(postId+'/tags?to='+"100002105259418", 'post', function(response){
//                            if (!response || response.error) {
//                              alert(response.error.message);
//                            }else {
//                              alert('Post was successful! Action ID: ' + response.id);
//                            }
//                          });
                        }
                    }
                );
            });
        });
        
        
        $(function(){ 
            $("#postimagefromfb").on("click", function(event) {
              FB.api('/me/feed',
                  'post', 
                  { 
                    message : $('#message').attr("value"),
                    link: 'http://www.facebook.com/photo.php?fbid=115085188629321&set=a.115084628629377.17000.100003835211964&type=1',
                    object_attachment: "115085188629321"
                  }, function(response) {
                        if (!response || response.error) {
                            alert(response.error.message);
                        }
                        else {
                          alert('Post was successful! Action ID: ' + response.id);
//                          var postId = response.id;
//                          FB.api(postId+'/tags?to='+"100002105259418", 'post', function(response){
//                            if (!response || response.error) {
//                              alert(response.error.message);
//                            }else {
//                              alert('Post was successful! Action ID: ' + response.id);
//                            }
//                          });
                        }
                    }
                );
            });
        });

        $(function(){
            $("#postflashapp").on("click", function(event) {
                var obj = {
                     method: 'feed',
                     link: 'http://floating-reaches-3088.herokuapp.com/userimages/'+$('#url').attr("value")+'.html'
                   };

                   function callback(response) {
                     console.log(response);
                   }

                   FB.ui(obj, callback);
          });
        });

</script>
      <hr>
      <footer>
        
      </footer>

    </div><!--/.fluid-container-->
    
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="/app/app.js"></script>

  </body>
</html>