# wowlogger
Process World of Warcraft logs and generate reports. Uses Laravel (PHP). Still in development.

While this project will parse logs and generate reports of WoW fishing data, programmers can expand upon it to create their own reports, and parse their own game data (these will require making a WoW plugin to log game data-- see wowlogger-plugins for the fishing example).

The project works with two other applications:
1.  WoW plugins for saving game data. An example for logging fish data (which is used by this project) are in [wowlogger-plugins](https://github.com/lacma2011/wowlogger-plugins)
2.  An uploader for users to upload their logs: [wowlogger-uploads](https://github.com/lacma2011/wowlogger-uploader)

