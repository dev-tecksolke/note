<?php


namespace Note;


use Note\Models\Notification;

class Note
{
    /**
     * --------------------------
     * Read a notification here
     * --------------------------
     * @param string $notification_id
     * @param string $guard
     * @return
     */
    public static function readNotification(string $notification_id, string $guard)
    {
        $fetchMail = auth($guard)->user()->load('notification')
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
     * @param string $guard
     * @return
     */
    public static function readTrashedNotification(string $notification_id, string $guard)
    {
        $fetchMail = auth($guard)->user()->load('notification')
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
     * @param string $guard
     * @return bool
     */
    public static function deleteSingleNotification(string $notification_id, string $guard)
    {
        $fetchMail = auth($guard)->user()->load('notification')
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
     * @param string $guard
     * @return bool
     */
    public static function deleteTrashNotification(string $notification_id, string $guard)
    {
        $fetchMail = auth($guard)->user()->load('notification')
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
     * @param string $guard
     * @return bool
     */
    public static function deleteAllNotifications(string $guard)
    {
        $mails = auth($guard)->user()->load('notification')
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
     * @param string $guard
     * @param bool $withPagination
     * @return
     */
    public static function trashedNotifications(string $guard, bool $withPagination = true)
    {
        if ($withPagination)
            return auth($guard)->user()->load('notification')
                ->notification()
                ->onlyTrashed()
                ->orderByDesc('updated_at')
                ->paginate(config('note.paginate'));

        return auth($guard)->user()->load('notification')
            ->notification()
            ->onlyTrashed()
            ->orderByDesc('updated_at')
            ->get();
    }


    /**
     * ------------------------------
     * delete a all trashed messages
     * ------------------------------
     * @param string $guard
     * @return bool
     */
    public static function clearTrashedNotifications(string $guard)
    {
        $mails = auth($guard)->user()->load('notification')
            ->notification()->onlyTrashed();

        if ($mails->forceDelete())
            return true;
        return false;
    }

    /**
     * --------------------------
     * fete latest notifications
     * --------------------------
     * @param string|null $guard
     * @param bool $withPagination
     * @return
     */
    public static function latestNotifications(string $guard, bool $withPagination = true)
    {
        if ($withPagination)
            return auth($guard)->user()->load('notification')
                ->notification()
                ->whereDate('created_at', today())
                ->where('status', false)
                ->orderByDesc('created_at')
                ->paginate(config('note.paginate'));

        return auth($guard)->user()->load('notification')
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
     * @param string|null $guard
     * @param bool $withPagination
     * @return
     */
    public static function allNotifications(string $guard, bool $withPagination = true)
    {
        if ($withPagination)
            return auth($guard)->user()->load('notification')
                ->notification()
                ->orderByDesc('created_at')
                ->paginate(config('note.paginate'));

        return auth($guard)->user()->load('notification')
            ->notification()
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * -------------------------------
     * create system notifications
     * here
     * -------------------------------
     * @param string $user_id
     * @param string $modelClass
     * @param string $subject
     * @param string $description
     * @return bool
     */
    public static function createSystemNotification(string $user_id, string $modelClass, string $subject, string $description)
    {
        $notification = Notification::query()->create([
            'notification_id' => $user_id,
            'notification_type' => $modelClass,
            'subject' => $subject,
            'description' => $description,
        ]);

        if ($notification)
            return true;
        return false;
    }
}
