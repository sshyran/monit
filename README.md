## Monit

`Monit` is a small PHP script for monitoring webpages. With e-mail notifcations and response validation.


### Install

* Open `config.json` in editor
* Change settings, set target webpages
* Save and upload to your webspace
* Run `Monit` (`index.php`) from `crontab`


### config.json

#### app

| key | value |
|:---:|-------|
| cache  | Cache folder          |
| sender | Sender e-mail address |


#### sites

| key | value |
|:---:|-------|
| url        | Page URL                   |
| name       | Page name                  |
| active     | (De)Activate monitoring    |
| timeout    | Timeout value              |
| identifier | Response validation string |
| receiver   | Receiver e-mail addresses  |


### Notes

* [PHP:mail](http://php.net/manual/de/function.mail.php) serve the messages
* The `cache` folder must be writable
