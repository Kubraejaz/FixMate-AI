<?php

namespace App\Support;

use App\Models\User;

class Permissions
{
    // Admin specific permissions
    public const ADMIN_ACCESS = 'admin.access';
    public const USERS_VIEW = 'users.view';
    public const USERS_MANAGE = 'users.manage';
    public const USERS_DELETE = 'users.delete';
    public const TECHNICIANS_VIEW = 'technicians.view';
    public const TECHNICIANS_VERIFY = 'technicians.verify';
    public const TECHNICIANS_MANAGE = 'technicians.manage';
    public const TECHNICIANS_DELETE = 'technicians.delete';
    public const BOOKINGS_VIEW_ALL = 'bookings.view_all';
    public const BOOKINGS_MANAGE = 'bookings.manage';
    public const SERVICES_MANAGE = 'services.manage';
    public const INQUIRIES_MANAGE = 'inquiries.manage';
    public const FAQS_MANAGE = 'faqs.manage';
    public const COMMUNITY_MODERATE = 'community.moderate';
    public const COMMUNITY_DELETE = 'community.delete';
    public const CMS_MANAGE = 'cms.manage';
    public const SETTINGS_MANAGE = 'settings.manage';
    public const ANALYTICS_VIEW = 'analytics.view';

    // Customer permissions
    public const CUSTOMER_ACCESS = 'customer.access';
    public const BOOKINGS_CREATE = 'bookings.create';
    public const BOOKINGS_VIEW_OWN = 'bookings.view_own';
    public const BOOKINGS_CANCEL_OWN = 'bookings.cancel_own';
    public const BOOKINGS_TRACK = 'bookings.track';
    public const BOOKINGS_PAY = 'bookings.pay';
    public const REVIEWS_CREATE = 'reviews.create';
    public const COMPLAINTS_CREATE = 'complaints.create';
    public const COMMUNITY_REPORT = 'community.report';
    public const COMMUNITY_UPVOTE = 'community.upvote';
    public const VIP_SUBSCRIBE = 'vip.subscribe';

    // Technician permissions
    public const TECHNICIAN_ACCESS = 'technician.access';
    public const KYC_SUBMIT = 'kyc.submit';
    public const KYC_VIEW = 'kyc.view';
    public const JOBS_VIEW = 'jobs.view';
    public const JOBS_ACCEPT = 'jobs.accept';
    public const JOBS_START_ROUTE = 'jobs.start_route';
    public const JOBS_UPDATE_LOCATION = 'jobs.update_location';
    public const JOBS_VERIFY_OTP = 'jobs.verify_otp';
    public const JOBS_COMPLETE = 'jobs.complete';
    public const EARNINGS_VIEW = 'earnings.view';
    public const SCHEDULE_MANAGE = 'schedule.manage';
    public const SKILLS_MANAGE = 'skills.manage';
    public const REVIEWS_REPLY = 'reviews.reply';
    public const PRO_SUBSCRIBE = 'pro.subscribe';

    // Shared permissions
    public const CHAT_SEND = 'chat.send';
    public const CHAT_VIEW = 'chat.view';
    public const MEETINGS_JOIN = 'meetings.join';
    public const PROFILE_UPDATE = 'profile.update';

    /**
     * Map of roles to their default permissions.
     */
    public static function rolePermissions(): array
    {
        return [
            User::TYPE_ADMIN => [
                self::ADMIN_ACCESS,
                self::USERS_VIEW,
                self::USERS_MANAGE,
                self::USERS_DELETE,
                self::TECHNICIANS_VIEW,
                self::TECHNICIANS_VERIFY,
                self::TECHNICIANS_MANAGE,
                self::TECHNICIANS_DELETE,
                self::BOOKINGS_VIEW_ALL,
                self::BOOKINGS_MANAGE,
                self::SERVICES_MANAGE,
                self::INQUIRIES_MANAGE,
                self::FAQS_MANAGE,
                self::COMMUNITY_MODERATE,
                self::COMMUNITY_DELETE,
                self::CMS_MANAGE,
                self::SETTINGS_MANAGE,
                self::ANALYTICS_VIEW,
                self::CHAT_SEND,
                self::CHAT_VIEW,
                self::MEETINGS_JOIN,
                self::PROFILE_UPDATE,
            ],

            User::TYPE_CUSTOMER => [
                self::CUSTOMER_ACCESS,
                self::BOOKINGS_CREATE,
                self::BOOKINGS_VIEW_OWN,
                self::BOOKINGS_CANCEL_OWN,
                self::BOOKINGS_TRACK,
                self::BOOKINGS_PAY,
                self::REVIEWS_CREATE,
                self::COMPLAINTS_CREATE,
                self::COMMUNITY_REPORT,
                self::COMMUNITY_UPVOTE,
                self::VIP_SUBSCRIBE,
                self::CHAT_SEND,
                self::CHAT_VIEW,
                self::MEETINGS_JOIN,
                self::PROFILE_UPDATE,
            ],

            User::TYPE_TECHNICIAN => [
                self::TECHNICIAN_ACCESS,
                self::KYC_SUBMIT,
                self::KYC_VIEW,
                self::JOBS_VIEW,
                self::JOBS_ACCEPT,
                self::JOBS_START_ROUTE,
                self::JOBS_UPDATE_LOCATION,
                self::JOBS_VERIFY_OTP,
                self::JOBS_COMPLETE,
                self::EARNINGS_VIEW,
                self::SCHEDULE_MANAGE,
                self::SKILLS_MANAGE,
                self::REVIEWS_REPLY,
                self::PRO_SUBSCRIBE,
                self::CHAT_SEND,
                self::CHAT_VIEW,
                self::MEETINGS_JOIN,
                self::PROFILE_UPDATE,
            ],
        ];
    }

    /**
     * Get all permissions granted to a given role.
     */
    public static function forRole(int|string $role): array
    {
        $roleId = is_numeric($role) ? (int) $role : match (strtolower((string) $role)) {
            'admin' => User::TYPE_ADMIN,
            'customer' => User::TYPE_CUSTOMER,
            'technician' => User::TYPE_TECHNICIAN,
            default => User::TYPE_CUSTOMER,
        };

        return self::rolePermissions()[$roleId] ?? [];
    }

    /**
     * Check if a role possesses a permission.
     */
    public static function roleHas(int|string $role, string $permission): bool
    {
        $perms = self::forRole($role);
        return in_array($permission, $perms, true);
    }
}
