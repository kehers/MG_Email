# MG_Email

Quick class to validate email using mailgun's API.

```php
<?php
include_once 'MG_Email.php';
$mailgun_public_api_key = 'your_mailgun_public_key';
$mg_email = new MG_Email($mailgun_public_api_key);
$email = 'someemail@yhoo.com';
if ($mg_email->is_valid($email)) {
    echo $email.' is valid';
}
else {
    echo $email.' is invalid.';
    if ($mg_email->spell_check)
        echo ' Do you mean '.$mg_email->spell_check.'?';
}
?>
```
