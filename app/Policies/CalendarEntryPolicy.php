<?php

namespace App\Policies;

use App\Meal;
use App\User;
use App\CalendarEntry;
use Illuminate\Auth\Access\HandlesAuthorization;

class CalendarEntryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the calendarEntry.
     *
     * @param  \App\User  $user
     * @param  \App\CalendarEntry  $calendarEntry
     * @return mixed
     */
    public function view(User $user, CalendarEntry $calendarEntry)
    {
        return $user->id === $calendarEntry->user_id;
    }



    /**
     * Determine whether the user can store a particular meal on the calendarEntry
     *
     * @param  \App\User  $user
     * @param  \App\CalendarEntry  $calendarEntry
     * @return mixed
     */
    public function storeMeal(User $user, CalendarEntry $calendarEntry, Meal $meal)
    {
        return $user->id === $calendarEntry->user_id
            && $user->id === $meal->user_id;
    }


    /**
     * Determine whether the user can remove a particular meal on their calendarEntry
     *
     * @param  \App\User  $user
     * @param  \App\CalendarEntry  $calendarEntry
     * @return mixed
     */
    public function removeMeal(User $user, CalendarEntry $calendarEntry)
    {
        return $user->id === $calendarEntry->user_id;
    }

    /**
     * Determine whether the user can create calendarEntries.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the calendarEntry.
     *
     * @param  \App\User  $user
     * @param  \App\CalendarEntry  $calendarEntry
     * @return mixed
     */
    public function update(User $user, CalendarEntry $calendarEntry)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the calendarEntry.
     *
     * @param  \App\User  $user
     * @param  \App\CalendarEntry  $calendarEntry
     * @return mixed
     */
    public function delete(User $user, CalendarEntry $calendarEntry)
    {
        return false;
    }
}
