# Trigger Api for updating c:geo F-Droid mirror

We maintain two branch of c:geo.
 * `mainline` aka `release` (stable)
 * `nightly`


## The Api

The Api has a single URL: `https://fdroid.cgeo.org/update-fdroid.php`

It accept a `POST` request with two parameters:

 * `SECRET_KEY` to authenticate
 * `REPO` to indicate which branch to update.

The `REPO` must be '`mainline`' or '`nightly`'.

If all tests passed, the update is triggered, and response delayed until the end of the command.


## Response

Response are in `JSON` format.

```
{
    "status": 0,
    "message": "Command complete."
}
```

Other return code are as follow:
 * 0 => 'Command complete.'
 * 1 => 'No SECRET_KEY found in POST parameters.'
 * 2 => 'No REPO found in POST parameters. Value: mainline or nightly'
 * 3 => 'Bad SECRET_KEY.'
 * 4 => 'Bad REPO. Must be mainline or nightly'
 * 5 => 'Failed to update the repo.'

