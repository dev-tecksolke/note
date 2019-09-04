<?php


namespace Note;


use App\Admin;

class Note {
    /**
     * --------------------------
     * Read a notification here
     * --------------------------
     * @param $notification_id
     * @param string $guard
     * @return
     */
    public static function readNotification($notification_id, string $guard = null) {
        if (!empty($guard)) {
            $fetchMail = auth($guard)->user()->load('notification')
                ->notification()
                ->findOrFail($notification_id);

            //change status
            $fetchMail->update([
                'status' => true,
            ]);

            return $fetchMail;
        }

        $fetchMail = auth()->user()->load('notification')
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
     * @param $notification_id
     * @param string $guard
     * @return bool
     */
    public static function deleteSingleNotification($notification_id, string $guard = null) {
        if (!empty($guard)) {
            $fetchMail = auth($guard)->user()->load('notification')
                ->notification()
                ->findOrFail($notification_id);
        } else {
            $fetchMail = auth()->user()->load('notification')
                ->notification()
                ->findOrFail($notification_id);
        }

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
    public static function deleteAllNotifications(string $guard = null) {
        if (!empty($guard)) {
            $mails = auth($guard)->user()->load('notification')
                ->notification();
        } else {
            $mails = auth()->user()->load('notification')
                ->notification();
        }

        if ($mails->delete())
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
    public static function latestNotifications(string $guard = null) {
        if (!empty($guard))
            return auth($guard)->user()->load('notification')
                ->notification()
                ->whereDate('created_at', today())
                ->where('status', false)
                ->orderByDesc('created_at')
                ->paginate(config('note.paginate'));

        return auth()->user()->load('notification')
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
    public static function allNotifications(string $guard = null) {
        if (!empty($guard))
            return auth($guard)->user()->load('notification')
                ->notification()
                ->orderByDesc('created_at')
                ->paginate(config('note.paginate'));

        return auth()->user()->load('notification')
            ->notification()
            ->orderByDesc('created_at')
            ->paginate(config('note.paginate'));
    }

    /**
     * -------------------------------
     * create system notifications
     * here
     * -------------------------------
     * @param string $subject
     * @param string $description
     * @param bool $admin
     * @return bool
     */
    public static function createSystemNotification(string $subject, string $description, bool $admin = false) {
        $status = false;
        $saveNotif = null;
        if ($admin) {
            foreach (Admin::all() as $admin) {
                if (auth('admin')->id() === $admin->id) {
                    Notification::query()->create([
                        'admin_id' => $admin->id,
                        'subject' => $subject,
                        'description' => $description,
                    ]);

                    return true;
                }

                Notification::query()->create([
                    'admin_id' => $admin->id,
                    'subject' => $subject,
                    'description' => $description,
                ]);

                $status = true;
            }
        } else {
            Notification::query()->create([
                'user_id' => auth()->id(),
                'subject' => $subject,
                'description' => $description,
            ]);
        }

        if ($saveNotif) {
            $status = true;
        }

        return $status;
    }
}
