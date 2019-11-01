<?php 

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Repositories\NotificationRepository;


class NotificationComposer
{
    public $notificationList = [];
    /**
     * Create a notification composer.
     *
     *  @param NotificationRepository $notification
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