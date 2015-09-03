<html>
<?php  
      require './vendor/voxbone/webrtc-token/token.php';
?>
  <head>
    <title></title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://webrtc.voxbone.com/js/voxbone-0.0.2.js" type="text/javascript"></script>
    <script src="https://webrtc.voxbone.com/js/jssip-0.3.0.js" type="text/javascript"></script>
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      var eventHandlers = {
      'progress':   function(e){ document.getElementById("status_message").innerHTML="Calling " + document.getElementById('number').value;},
      'failed':     function(e){ document.getElementById("status_message").innerHTML="<b><font color='red'>Failed to connect: " + e.data.cause + "</font></b>"},
      'started':    function(e){ document.getElementById("status_message").innerHTML="<b><font color='green'>In Call</font></b>"; },
      'ended':      function(e){ document.getElementById("status_message").innerHTML="<b><font color='red'>Call Ended</font></b>"; }
      };
      /** This part is required as it handle Voxbone WebRTC initialization **/
      function init(){
      // Set the webrtc auth server url (url below it the default one)
      voxbone.WebRTC.authServerURL = "https://webrtc.voxbone.com/rest/authentication/createToken";
      //If this is not set, a ping to each pop will be issued to determine which is the most optimal for the user
      //Default is to use the ping mechanism to determine the preferedPop.
      //voxbone.WebRTC.preferedPop = 'BE';
      // set custom event handlers
      voxbone.WebRTC.customEventHandler = eventHandlers;
      //Set the caller-id, domain name gets automatically stripped off
      //Note that It must be a valid sip uri.
      //Default value is: voxrtc@voxbone.com
      //voxbone.WebRTC.configuration.uri = "caller-id@voxbone.com";
      //Add a display name
      //voxbone.WebRTC.configuration.display_name = "";
      //Add an object or string in the X-Voxbone-Context SIP header
      //voxbone.WebRTC.context = "Here's a context string";
      //Bootstrap Voxbone WebRTC javascript object
      voxbone.WebRTC.init(<?php echo json_encode($output); ?>);
      }
      /** Optional part, only use to play with mute **/
      function toggleMute(){
      var button = document.getElementById("mute");
      if( voxbone.WebRTC.isMuted ){
      voxbone.WebRTC.unmute();
      button.innerHTML = "Mute";
      }else{
      voxbone.WebRTC.mute();
      button.innerHTML = "Unmute";
      }
      }
    </script>
  </head>
  <!--invoke init() method when page is initializing
  -->
  <body onload="init();" style="text-align: center;">
    <h1>Click2Call Demo</h1>
    <div style="width:200px; margin-top:10%;" class="container">
      <form>
        <!--input text which holds the number to dial
        -->
        <input id="number" type="tel" placeholder="Enter your VoxDID" style="text-align:center" class="btn-block form-control input-lg"/>
        <!--place a call using voxbone webrtc js lib
        -->
        <button type="button" onclick="voxbone.WebRTC.call(document.getElementById('number').value);" class="btn btn-success btn-lg btn-block">Dial<span class="glyphicon glyphicon-earphone pull-left"></span></button>
        <!--hangup the current call in progress
        -->
        <button type="button" onclick="voxbone.WebRTC.hangup();" class="btn btn-danger btn-lg btn-block">Hangup<span class="glyphicon glyphicon-remove pull-left"></span></button>
        <!--toggle mute ON/OFF
        -->
        <button id="mute" type="button" onclick="toggleMute()" class="btn btn-link btn-block">Mute</button><br/>
        <div id="status_message">
          <p>Initializing configuration</p>
        </div>
      </form>
    </div>
  </body>
</html>