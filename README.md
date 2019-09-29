#PB BOT ASSISTANT
This is a simple bot assistant for working with customer directly via **Telegram bot**

You can registry own bot with help **BotFather**
![BotFather](https://cdn1.telesco.pe/file/saSarlPYml7OX11-vpcflE3ETt946fiqOJNQleSfWMxtBOfsXUiLA2lCMf_J4PQLbJzCQ10Es8U-KhscMDtetlF3ozknP_MTo-_R8JoSYwkMPQkAMmwyidjQOQ3JnDc4Ry5X7AnPwQTwukoouOD-CFalHecU7M8J1wntxr-xDVFoRxf9tJmcaKwiaJnmmLBj4U5QoJnXioBdTJ8yXV3VoiWTlr4fiSNid9iyjnNSUbO3LHdGBLchtAsRPZSiY2J6u7Qyd1o64HFrnnMQTW1FWSvZg--tJN_4KY2M9t3IxwZFpTFuShZNuGQduOfWomqTj8tjKqZkBmyJm-FEA574Bg.jpg)

The enter point is index.php file

You can run application in cli or in your browser 

In CLI
```php
php index.php -m sendMessage -c 10 -t lorem
```
#####Where params are: 
**-m** - name of method
**-c** - chat ID
**-t** - send text

In browser

You can use built web server
```php
php -S 127.0.0.1
```
*127.0.0.1/?method=sendMessage&chat_id=10&text=lorem*

Parameters can be set using GET and POST requests

Enjoy):rocket:
