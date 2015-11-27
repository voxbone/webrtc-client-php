<html>
<?php
      require './vendor/voxbone/webrtc-token/token.php';
?>
  <head>
    <title></title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://webrtc.voxbone.com/js/jssip-0.7.9-vox.js" type="text/javascript"></script>
    <script src="https://webrtc.voxbone.com/js/voxbone-0.0.3.js" type="text/javascript"></script>
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      /** This part is required as it handle Voxbone WebRTC initialization **/
      function init(){
      // Set the webrtc auth server url (url below it the default one)
      //voxbone.WebRTC.authServerURL = "https://webrtc.voxbone.com/rest/authentication/createToken";
      //If this is not set, a ping to each pop will be issued to determine which is the most optimal for the user
      //Default is to use the ping mechanism to determine the preferedPop.
      //voxbone.WebRTC.preferedPop = 'BE';
      // set custom event handlers
      voxbone.WebRTC.customEventHandler.progress=   function(e){ document.getElementById("status_message").innerHTML="Calling " + document.getElementById('number').value;};
      voxbone.WebRTC.customEventHandler.failed=     function(e){ document.getElementById("status_message").innerHTML="<b><font color='red'>Failed to connect: " + e.data.cause + "</font></b>"};
      voxbone.WebRTC.customEventHandler.accepted=    function(e){ document.getElementById("status_message").innerHTML="<b><font color='green'>In Call</font></b>"; };
      voxbone.WebRTC.customEventHandler.ended=      function(e){ document.getElementById("status_message").innerHTML="<b><font color='red'>Call Ended</font></b>"; };
      voxbone.WebRTC.customEventHandler.localMediaVolume =      function(e){ document.getElementById("volume").value = e.localVolume; };
      //Set the caller-id, domain name gets automatically stripped off
      //Note that It must be a valid sip uri.
      //Default value is: voxrtc@voxbone.com
      //voxbone.WebRTC.configuration.uri = "caller-id@voxbone.com";
      //Add a display name
      //voxbone.WebRTC.configuration.display_name = "";
      //Add an object or string in the X-Voxbone-Context SIP header
      //voxbone.WebRTC.context = "Here's a context string";

      /**
        * dialer_string
        * Digits to dial after call is established
        * dialer string is comma separated, to define a specific pause between digits,
        * we add another entry like 1,2,3,1200ms,4,.. this will add a 1200ms of pause between
        * digits 3 & 4.
        * Example = '1,2,3,1200ms,4,5,900ms,6,#'
      **/
      //voxbone.WebRTC.configuration.dialer_string = "1,2,3,1200ms,4,5,900ms,6,#";

      /**
        * digit duration (in milliseconds)
        * It defines the duration of digits sent by the web application.
        * By default, default digit duration is 100 ms.
      **/
      //voxbone.WebRTC.configuration.digit_duration = 1000;

      /**
        * gap can be set between all digits in milliseconds
      **/
      //voxbone.WebRTC.configuration.digit_gap = 1400;

      /**
        * This configuration option if enabled allows voxbone webrtc sdk to push
        * all the call logs to a voxbone defined backend, where they can be used
        * for troubleshooting. By default, this option is disabled.
        * Set this option to true to allow voxbone to collect call logs
      **/
      //voxbone.WebRTC.configuration.post_logs = true;

      //Bootstrap Voxbone WebRTC javascript object
      voxbone.WebRTC.init(<?php echo json_encode($output); ?>);
      }

      //Basic Authentication can also be used instead of using the token in voxbone.WebRTC.init()
      //voxbone.WebRTC.basicAuthInit(your_username, your_secret_key)

      /** Optional part, only use to play with mute **/
      function toggleMute(){
      if( voxbone.WebRTC.isMuted ){
      voxbone.WebRTC.unmute();
      $("#mute").text("Mute");
      $("#mute_icon").removeClass("glyphicon-volume-off").addClass("glyphicon-volume-up");
      }else{
      voxbone.WebRTC.mute();
      $("#mute").text("Unute");
      $("#mute_icon").removeClass("glyphicon-volume-up").addClass("glyphicon-volume-off");
      }
      }
    </script>
  </head>
  <!--invoke init() method when page is initializing
  -->
  <body onload="init();"  onbeforeunload='voxbone.WebRTC.unloadHandler();' style="text-align: center;">
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
        <button type="button" onclick="toggleMute()" class="btn btn-info btn-lg btn-block"><span id="mute_icon" class="glyphicon glyphicon-volume-up pull-left"></span><span id="mute">Mute</span></button><br/>
	<div>
		Local Volume
		<meter id="volume" low=0 high=0.15 max=1/>
	</div>
        <div id="status_message">
          <p>Initializing configuration</p>
        </div>
      </form>
    </div>
  </body>
</html>
