# dynamicIPBot
Bot for dynamic IP server for telegram

You have orange pi or smth like this, but dynamic ip doesn't let you use it from the Net? 
It's not problem any more.

Just use this telegram bot:
1) create telegram-bot page
2) edit config.php
3) edit hookies/getip.php
4) run it on your microcontroller
5) Enjoy

So, if you wanna to connect your server from far away, just write "/getip" to your bot and it would send you the current ip.
Also, if your telegram id would be in mailing.txt - so bot would signal you imidiatly, if the ip has been changed.

### use your own commands

To create your own command:
1) Create new file in "hookies" directory
2) It's name must be the same as the name of the command you wanna use
3) Write the code
4) Enjoy calling your own command

If you use it - perfect - I'm not alone. There's a lot of things, which can be improved... just do it)))


