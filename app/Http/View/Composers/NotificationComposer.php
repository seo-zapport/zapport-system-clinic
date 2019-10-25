<?php 

namespace App\Http\View\Composers;

use Illuminate\View\View;


class NotificationComposer
{
    public $notificationList = [];
    /**
     * Create a movie composer.
     *
     *  @param NotificationRepository $movie
     *
     * @return void
     */
    public function __construct(NotificationRepository $notification)
    {
        $this->notificationList = $notification->getNotificationList();
    }
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('count', $this->notificationList);
    }
}