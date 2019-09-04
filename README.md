# <p align="center"><a href="#" target="_blank"><img src="https://tecksol.co.ke/image/logo.png"></a></p>

<p align="center">
  <b>Makes Laravel Notification a Breeze...</b><br>
  <a href="https://github.com/dev-tecksolke/note/issues">
  <img src="https://img.shields.io/github/issues/dev-tecksolke/note">
  </a>
  <a href="https://github.com/dev-tecksolke/note/network/members">
  <img src="https://img.shields.io/github/forks/dev-tecksolke/note">
  </a>
  <a href="https://github.com/dev-tecksolke/note/stargazers">
  <img src="https://img.shields.io/github/stars/dev-tecksolke/note">
  </a>
  <br><br>
</p>

This package is custom notify for both admins and users, so instead of using laravel notification. I built this custom notification package for my projects, so if you want to try it out read through the documentation. 

## Installing

The recommended way to install *tecksolke/note* is through
[Composer](http://getcomposer.org).

```bash
# Install package via composer
composer require tecksolke/note
```

Next, run the Composer command to install the latest stable version of *tecksolke/note*:

```bash
# Update package via composer
 composer require tecksolke/note --lock
```

After installing, the package will be auto discovered, But if need you may run:

```php
# run for auto discovery <-- If the package is not detected automatically -->
composer dump-autoload
```

Then run this, to get the *config/note.php* for configurations:

```php
# run this to get the configuartion file at config/note.php <-- read through it -->
php artisan vendor:publish --provider="Note\NoteServiceProvider"
```

You will have to provide this in the *.env* for the api configurations:

```php
# This is the pagination number you want to paginate with <-- default(10) -->
NOTE_NOTIFICATION_PAGINATE=
```
## Usage
Follow the steps below on how to use the package:

```php
  /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //The instance should be either this
        $this->middleware('auth:admin');//for your admin controller
        //or
        $this->middleware('auth');//for your user Controller
    }

    /**
     * ---------------------------------
     * Fetch Latest Notification Here
     * --------------------------------
     * Passing bool - true - to the function will query admin notification only
     * @return void
     */
    public function latestNotifications() {
        Note::latestNotifications();//Fetching latest notification for user
        Note::latestNotifications(PassTheGuardName);//Fetching latest notification for admin
    }

    /**
     * --------------------------------
     * Fetching all notifications
     * -------------------------------
     * Passing bool - true - to the function will query admin notification only
     * @return void
     */
    public function allNotifications() {
        Note::allNotifications();//Fetching all notifications for user
        Note::allNotifications(PassTheGuardName);//Fetching all notifications for admin
    }

    /**
     * =-------------------------------
     * Deleting a single notification
     * --------------------------------
     * Passing bool - true - to the function will query admin notification only
     * ------------------------------------------------------------------------------
     * To achieve single notification create a route that receives a (string) notification_id
     * Note that this package uses uuids so the notification_id has to be a string
     * ----------------------------------------------------------------------------------------
     * Passing bool - true - to the function will query admin notification only
     * -----------------------------------------------------------------------------------------------
     * @param string $notification_id
     * @return void
     */
    public function deleteSingleNotification(string $notification_id) {
        Note::deleteSingleNotification($notification_id);//For user
        Note::deleteSingleNotification($notification_id, PassTheGuardName);//For admin
    }

    /**
     * =-------------------------------
     * Deleting a all notification
     * --------------------------------
     * Passing bool - true - to the function will query admin notification only
     * ------------------------------------------------------------------------------
     * Passing bool - true - to the function will query admin notification only
     * ----------------------------------------------------------------------------------
     * @return void
     */
    public function deleteAllNotifications() {
        Note::deleteAllNotifications();//For user
        Note::deleteAllNotifications(PassTheGuardName);//For admin
    }

    /**
     * --------------------------------
     * Creating new notification here
     * --------------------------------
     * In creating notification we need 3 parameters of which 1 is optional that is for bool admin
     * -------------------------------------------------------------------------------------------------------
     * Also you can have your function that receives the parameters and passes them to Note::createSystemNotification
     * --------------------------------------------------------------------------------------------------------------
     * @return void
     */
    public function createSystemNotification() {
        //This is for creating user notifications
        Note::createSystemNotification('My Notification Subject', 'My Notification Message');

        //This is for creating admin notifications
        Note::createSystemNotification('My Notification Subject', 'My Notification Message',true);
    }


    /**
     * ---------------------------
     * TODO SIMPLE PACKAGE NOTES
     * -----------------------------------------------------------------------------------------
     * For the functions used above can be changed to your own names to call the package names
     * -----------------------------------------------------------------------------------------
     */


```

## Version Guidance

| Version | Status     | Packagist           | Namespace    | Repo                |
|---------|------------|---------------------|--------------|---------------------|
| 1.x     | Latest     | `tecksolke/note` | `Note/NoteServiceProvider` | [v1.0.0](https://github.com/dev-tecksolke/note/tree/1.0)|

[tecksolke/note-1-repo]: https://github.com/dev-tecksolke/note.git

## Security Vulnerabilities
 For any security vulnerabilities, please email to [TecksolKE](mailto:client@tecksol.co.ke).
 
## License
 This package is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
