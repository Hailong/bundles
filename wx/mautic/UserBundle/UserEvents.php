<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\UserBundle;

/**
 * Class UserEvents
 *
 * Events available for UserBundle
 */
final class UserEvents
{

    /**
     * The mautic.user_pre_save event is thrown right before a user is persisted.
     *
     * The event listener receives a Mautic\UserBundle\Event\UserEvent instance.
     *
     * @var string
     */
    const USER_PRE_SAVE = 'mautic.user_pre_save';

    /**
     * The mautic.user_post_save event is thrown right after a user is persisted.
     *
     * The event listener receives a Mautic\UserBundle\Event\UserEvent instance.
     *
     * @var string
     */
    const USER_POST_SAVE = 'mautic.user_post_save';

    /**
     * The mautic.user_pre_delete event is thrown prior to when a user is deleted.
     *
     * The event listener receives a Mautic\UserBundle\Event\UserEvent instance.
     *
     * @var string
     */
    const USER_PRE_DELETE = 'mautic.user_pre_delete';

    /**
     * The mautic.user_post_delete event is thrown after a user is deleted.
     *
     * The event listener receives a Mautic\UserBundle\Event\UserEvent instance.
     *
     * @var string
     */
    const USER_POST_DELETE = 'mautic.user_post_delete';

    /**
     * The mautic.role_pre_save event is thrown right before a role is persisted.
     *
     * The event listener receives a Mautic\UserBundle\Event\RoleEvent instance.
     *
     * @var string
     */
    const ROLE_PRE_SAVE = 'mautic.role_pre_save';

    /**
     * The mautic.role_post_save event is thrown right after a role is persisted.
     *
     * The event listener receives a Mautic\UserBundle\Event\RoleEvent instance.
     *
     * @var string
     */
    const ROLE_POST_SAVE = 'mautic.role_post_save';

    /**
     * The mautic.role_pre_delete event is thrown prior a role being deleted.
     *
     * The event listener receives a Mautic\UserBundle\Event\RoleEvent instance.
     *
     * @var string
     */
    const ROLE_PRE_DELETE = 'mautic.role_pre_delete';

    /**
     * The mautic.role_post_delete event is thrown after a role is deleted.
     *
     * The event listener receives a Mautic\UserBundle\Event\RoleEvent instance.
     *
     * @var string
     */
    const ROLE_POST_DELETE = 'mautic.role_post_delete';

    /**
     * The mautic.user_logout event is thrown during the logout routine giving a chance to carry out tasks before
     * the session is lost
     *
     * The event listener receives a Mautic\UserBundle\Event\LogoutEvent instance.
     *
     * @var string
     */
    const USER_LOGOUT = 'mautic.user_logout';

    /**
     * The mautic.user_login event is thrown right after a user logs in
     *
     * The event listener receives a Mautic\UserBundle\Event\LoginEvent instance.
     *
     * @var string
     */
    const USER_LOGIN = 'mautic.user_login';

    /**
     * The mautic.user_status_change event is thrown when a user's online status is changed
     *
     * The event listener receives a Mautic\UserBundle\Event\StatusChangeEvent instance.
     *
     * @var string
     */
    const STATUS_CHANGE = 'mautic.user_status_change';
}