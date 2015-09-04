Voxbone WebRTC Client PHP
=================

#####1. Download the dependency

`````
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
composer require --dev  voxbone/webrtc-token
`````

#####2. Change your credentials in /vendor/voxbone/webrtc-token/token.php

`````
$username = 'your_username'; // Voxbone account name
$secret = 'your_secret'; // Voxbone webrtc password
`````

#####3. Start the application using LAMP/MAMP or any other server


#####4. Structure

`````
project
│   README.md      (this exact file)
│   composer.json  (all the required app dependencies, including voxbone-webrtc-token for auth key generation)
|   index.html     (App front-end, contains webRTC logic and where call settings/config, eg: caller-ID, context-header, etc..)
`````
