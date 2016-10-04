## Monit

`Monit` is a small PHP library for monitoring web pages. With e-mail notifications and response validation.

`Monit` uses [multi_curl](http://php.net/manual/en/function.curl-multi-init.php) functionality for fast, asynchronous processing of multiple requests. [PHP:mail](http://php.net/manual/de/function.mail.php) serve the notifications.


### Install

* Open `config.json` in editor
* Change settings, set target webpages
* Save and upload to your webspace
* Run `Monit` (`index.php`) from `crontab`


### Test

* Run `Monit` (`index.php`) in browser


### config.json

#### app

| key | value | type  |
|:---:|-------|-------|
| `cache`  | Writable cache folder | string |
| `sender` | Sender e-mail address | string |


#### sites

| key | value | type  |
|:---:|-------|-------|
| `url`        | Page URL                   | string  |
| `name`       | Page name                  | string  |
| `active`     | (De)Activate monitoring    | boolean |
| `timeout`    | Timeout value              | integer |
| `identifier` | Response validation string | string  |
| `receiver`   | Receiver e-mail addresses  | array   |

`Monit` will search for `identifier` string in response body.


### Notifications

Any notification contains the reason of current failure. In general it is the error message determined by [curl_error](http://php.net/manual/de/function.curl-error.php). Some custom error messages are also available:

* Status code `%d` received
* SSL verify code `%d` received
* Redirect count is `%d`