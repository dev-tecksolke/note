<?php


namespace Note;


use LaravelMultipleGuards\Traits\FindGuard;
use Note\Models\Notification;

class Note
{
    use FindGuard;

    /**
     * --------------------------
     * Read a notification here
     * --------------------------
     * @param string $notification_id
     * @return
     */
    public static function readNotification(string $notification_id)
    {
        $fetchMail = (new Note())->findGuardType()->user()->load('notification')
            ->notification()
            ->findOrFail($notification_id);

        //change status
        $fetchMail->update([
            'status' => true,
        ]);

        return $fetchMail;
    }

    /**
     * --------------------------
     * Read a trashed notification here
     * --------------------------
     * @param string $notification_id
     * @return
     */
    public static function readTrashedNotification(string $notification_id)
    {
        $fetchMail = (new Note())->findGuardType()->user()->load('notification')
            ->notification()
            ->onlyTrashed()
            ->findOrFail($notification_id);

        //change status
        $fetchMail->update([
            'status' => true,
        ]);

        return $fetchMail;
    }

    /**
     * --------------------------------
     * delete single notification here
     * --------------------------------
     * @param string $notification_id
     * @return bool
     */
    public static function deleteSingleNotification(string $notification_id)
    {
        $fetchMail = (new Note())->findGuardType()->user()->load('notification')
            ->notification()
            ->findOrFail($notification_id);

        //delete
        if ($fetchMail->delete())
            return true;
        return false;
    }

    /**
     * --------------------------------
     * delete trashed notification here
     * --------------------------------
     * @param string $notification_id
     * @return bool
     */
    public static function deleteTrashNotification(string $notification_id)
    {
        $fetchMail = (new Note())->findGuardType()->user()->load('notification')
            ->notification()
            ->onlyTrashed()
            ->findOrFail($notification_id);

        //delete
        if ($fetchMail->forceDelete())
            return true;
        return false;
    }

    /**
     * -------------------------------
     * delete all notifications here
     * --------------------------------
     * @return bool
     */
    public static function deleteAllNotifications()
    {
        $mails = (new Note())->findGuardType()->user()->load('notification')
            ->notification();

        if ($mails->delete())
            return true;
        return false;
    }


    /**
     * ------------------------------
     * Fetch the soft deleted data
     * here
     * -------------------------------
     * @param bool $withPagination
     * @return
     */
    public static function trashedNotifications(bool $withPagination = true)
    {
        if ($withPagination)
            return (new Note())->findGuardType()->user()->load('notification')
                ->notification()
                ->onlyTrashed()
                ->orderByDesc('updated_at')
                ->paginate(config('note.paginate'));

        return (new Note())->findGuardType()->user()->load('notification')
            ->notification()
            ->onlyTrashed()
            ->orderByDesc('updated_at')
            ->get();
    }


    /**
     * ------------------------------
     * delete a all trashed messages
     * ------------------------------
     * @return bool
     */
    public static function clearTrashedNotifications()
    {
        $mails = (new Note())->findGuardType()->user()->load('notification')
            ->notification()->onlyTrashed();

        if ($mails->forceDelete())
            return true;
        return false;
    }

    /**
     * --------------------------
     * fete latest notifications
     * --------------------------
     * @param bool $withPagination
     * @return
     */
    public static function latestNotifications(bool $withPagination = true)
    {
        if ($withPagination)
            return (new Note())->findGuardType()->user()->load('notification')
                ->notification()
                ->whereDate('created_at', today())
                ->where('status', false)
                ->orderByDesc('created_at')
                ->paginate(config('note.paginate'));

        return (new Note())->findGuardType()->user()->load('notification')
            ->notification()
            ->whereDate('created_at', today())
            ->where('status', false)
            ->orderByDesc('created_at')
            ->get();

    }

    /**
     * --------------------------------
     * Fetch all notifications here
     * --------------------------------
     * @param bool $withPagination
     * @return
     */
    public static function allNotifications(bool $withPagination = true)
    {
        if ($withPagination)
            return (new Note())->findGuardType()->user()->load('notification')
                ->notification()
                ->orderByDesc('created_at')
                ->paginate(config('note.paginate'));

        return (new Note())->findGuardType()->user()->load('notification')
            ->notification()
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * --------------------------------
     * Fetch all unread notifications here
     * --------------------------------
     * @param bool $withPagination
     * @return
     */
    public static function unreadNotifications(bool $withPagination = true)
    {
        if ($withPagination)
            return (new Note())->findGuardType()->user()->load('notification')
                ->notification()
                ->where('status', false)
                ->orderByDesc('created_at')
                ->paginate(config('note.paginate'));

        return (new Note())->findGuardType()->user()->load('notification')
            ->notification()
            ->where('status', false)
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * -------------------------------
     * create system notifications
     * here
     * -------------------------------
     * @param string $modelClass
     * @param string $subject
     * @param string $description
     * @return bool
     */
    public static function createSystemNotification(string $modelClass, string $subject, string $description)
    {
        $notification = Notification::query()->create([
            'notification_id' => (new Note())->findGuardType()->id(),
            'notification_type' => $modelClass,
            'subject' => $subject,
            'description' => $description,
        ]);

        if ($notification)
            return true;
        return false;
    }
}
