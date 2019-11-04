<?php


namespace Note;


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
     * @return
     */
    public static function trashedNotifications(string $guard)
    {
        return auth($guard)->user()->load('notification')
            ->notification()
            ->withTrashed()
            ->orderByDesc('updated_at')
            ->paginate(config('note.paginate'));
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
            ->notification();

        if ($mails->forceDelete())
            return true;
        return false;
    }

    /**
     * --------------------------
     * fete latest notifications
     * --------------------------
     * @param string|null $guard
     * @return
     */
    public static function latestNotifications(string $guard)
    {
        return auth($guard)->user()->load('notification')
            ->notification()
            ->whereDate('created_at', today())
            ->where('status', false)
            ->orderByDesc('created_at')
            ->paginate(config('note.paginate'));
    }

    /**
     * --------------------------------
     * Fetch all notifications here
     * --------------------------------
     * @param string|null $guard
     * @return
     */
    public static function allNotifications(string $guard)
    {
        return auth($guard)->user()->load('notification')
            ->notification()
            ->orderByDesc('created_at')
            ->paginate(config('note.paginate'));
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