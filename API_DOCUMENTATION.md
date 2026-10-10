# FixMate AI — Complete REST API Documentation (v1)

FixMate AI provides a production-grade, Sanctum-secured REST API designed for mobile applications (iOS / Android) and third-party integrations.

- **Base URL**: `https://your-domain.com/api/v1` (Local: `http://localhost:8000/api/v1`)
- **Authentication**: Laravel Sanctum Bearer Tokens
- **Default Format**: `application/json`
- **Total Endpoints**: 128 registered routes across 6 core domains

---

## Standard Response Envelopes

Every API response follows a consistent envelope:

### Successful Response
```json
{
  "success": true,
  "message": "Operation completed successfully.",
  "data": { ... },
  "meta": {
    "current_page": 1,
    "per_page": 10,
    "total": 45,
    "last_page": 5
  }
}
```

### Validation Error Response (HTTP 422)
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": [
      "The email field must be a valid email address."
    ]
  }
}
```

### Authorization Error Response (HTTP 401 / 403)
```json
{
  "success": false,
  "message": "Unauthenticated.",
  "data": null
}
```

---

## 1. Authentication API (`/api/v1/auth`)

Rate limited with `api-auth` throttle middleware (10 req/min for auth actions).

| Method | Endpoint | Description | Auth Required |
|---|---|---|---|
| `POST` | `/api/v1/auth/register/customer` | Register a new customer account | No |
| `POST` | `/api/v1/auth/register/technician` | Register a new technician account | No |
| `POST` | `/api/v1/auth/login` | Login with email or phone + password | No |
| `POST` | `/api/v1/auth/verify-otp` | Verify OTP for registration or password reset | No |
| `POST` | `/api/v1/auth/resend-otp` | Resend 6-digit OTP code | No |
| `POST` | `/api/v1/auth/forgot-password` | Request password reset code via phone/email | No |
| `POST` | `/api/v1/auth/reset-password` | Set new password using verified OTP | No |
| `GET` | `/api/v1/auth/me` | Fetch authenticated user profile and roles | Bearer Token |
| `POST` | `/api/v1/auth/logout` | Revoke current access token | Bearer Token |
| `POST` | `/api/v1/auth/logout-all` | Revoke all active sessions and tokens | Bearer Token |

---

## 2. Public & Discovery API (`/api/v1`)

Public content, directory lookups, and civic hazard reporting.

| Method | Endpoint | Description | Auth Required |
|---|---|---|---|
| `GET` | `/api/v1/home` | Landing page data (hero, stats, categories, featured techs) | No |
| `GET` | `/api/v1/about` | About page overview and operational coverage | No |
| `GET` | `/api/v1/how-it-works` | Step-by-step workflow guide | No |
| `GET` | `/api/v1/privacy-policy` | Platform privacy policies and warranty terms | No |
| `GET` | `/api/v1/terms` | Terms of service | No |
| `GET` | `/api/v1/services` | Service categories with search and filters (`?search=`, `?category=`) | No |
| `GET` | `/api/v1/services/{slug}` | Service category details with available technicians | No |
| `GET` | `/api/v1/technicians` | Technician directory with search, city, and profession filters | No |
| `GET` | `/api/v1/technicians/{id}` | Detailed technician public profile and verified reviews | No |
| `GET` | `/api/v1/faqs` | FAQs categorized by topic with search | No |
| `GET` | `/api/v1/community` | Public feed of approved civic issues and hazards | No |
| `GET` | `/api/v1/community/{issue}` | Details of a civic hazard report | No |
| `POST` | `/api/v1/community/report` | Report a civic hazard (with photo upload) | No |
| `POST` | `/api/v1/community/{issue}/upvote`| Upvote / downvote a community hazard report | No |
| `POST` | `/api/v1/contact` | Submit a general customer support message | No |
| `GET` | `/api/v1/contact/track` | Track contact inquiry status by reference number | No |
| `POST` | `/api/v1/become-technician` | Submit initial technician onboarding interest form | No |

---

## 3. Customer Portal API (`/api/v1/customer`)

Requires `auth:sanctum` and `api.role:customer`.

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/v1/customer/dashboard` | Active booking, metrics, recent bookings, unread notifications |
| `GET` | `/api/v1/customer/bookings` | Bookings history (`?status=active|completed|cancelled`, `?search=`) |
| `POST` | `/api/v1/customer/bookings` | Create new repair booking (date, time slot, address, photo, notes) |
| `GET` | `/api/v1/customer/bookings/{booking}` | Inspect single booking details |
| `POST` | `/api/v1/customer/bookings/{booking}/cancel` | Cancel an upcoming booking with reason |
| `GET` | `/api/v1/customer/bookings/{booking}/tracking` | Real-time GPS coordinates, ETA, route state |
| `POST` | `/api/v1/customer/bookings/{booking}/payment` | Submit payment (JazzCash, EasyPaisa, Card, COD escrow) |
| `GET` | `/api/v1/customer/reviews` | Reviews submitted by this customer |
| `POST` | `/api/v1/customer/bookings/{booking}/review` | Rate and review a completed booking |
| `GET` | `/api/v1/customer/complaints` | Customer dispute / complaints history |
| `POST` | `/api/v1/customer/complaints` | File complaint or dispute against a booking |
| `GET` | `/api/v1/customer/chat/threads` | Active chat conversation threads |
| `GET` | `/api/v1/customer/chat/{technician}/messages` | Message history with specific technician |
| `POST` | `/api/v1/customer/chat/messages` | Send message to technician |
| `GET` | `/api/v1/customer/notifications` | Notifications list with unread counter |
| `POST` | `/api/v1/customer/notifications/{notification}/read` | Mark single notification as read |
| `POST` | `/api/v1/customer/notifications/read-all` | Mark all customer notifications as read |
| `GET` | `/api/v1/customer/profile` | Customer profile information |
| `PUT/PATCH` | `/api/v1/customer/profile` | Update name, phone, city, address |
| `POST` | `/api/v1/customer/password` | Change account password |
| `POST` | `/api/v1/customer/notification-settings` | Toggle push/SMS/email preferences |
| `POST` | `/api/v1/customer/ai/diagnose` | AI defect scanner (multimodal defect image + text description) |

---

## 4. Technician Portal API (`/api/v1/technician`)

Requires `auth:sanctum` and `api.role:technician`. Operational endpoints require `api.verified`.

| Method | Endpoint | Description | Verification Required |
|---|---|---|---|
| `GET` | `/api/v1/technician/verification` | Current KYC verification status & submitted docs | No |
| `POST` | `/api/v1/technician/verification` | Submit CNIC front/back, selfie, license & certificates | No |
| `GET` | `/api/v1/technician/dashboard` | Daily summary, active job, earnings snapshot | Yes |
| `GET` | `/api/v1/technician/jobs` | Dispatched & claimed jobs (`?tab=pending|active|completed`) | Yes |
| `GET` | `/api/v1/technician/jobs/{booking}` | Inspect job requirements, customer address, payout share | Yes |
| `POST` | `/api/v1/technician/jobs/{booking}/accept` | Accept an available job dispatch | Yes |
| `POST` | `/api/v1/technician/jobs/{booking}/start-route` | Mark status "En Route" to notify customer with ETA | Yes |
| `GET` | `/api/v1/technician/active-job` | Quick access to current in-progress job | Yes |
| `POST` | `/api/v1/technician/jobs/{booking}/location` | Broadcast technician GPS coordinates (lat, lng, eta) | Yes |
| `POST` | `/api/v1/technician/jobs/{booking}/verify-otp` | Verify 4-digit customer arrival handshake OTP | Yes |
| `POST` | `/api/v1/technician/jobs/{booking}/complete` | Mark job completed and release escrow payout | Yes |
| `GET` | `/api/v1/technician/earnings` | Complete earnings ledger, platform fee deductions, balance | Yes |
| `GET` | `/api/v1/technician/schedule` | Scheduled appointments and calendar jobs | Yes |
| `GET` | `/api/v1/technician/subscription` | Current VIP status, plan benefits, available tiers | Yes |
| `POST` | `/api/v1/technician/subscription/upgrade` | Upgrade to FixMate Pro VIP (0% commission perk) | Yes |
| `POST` | `/api/v1/technician/subscription/cancel` | Cancel Pro subscription and revert to free tier | Yes |
| `GET` | `/api/v1/technician/skills` | Active trade category and sub-skills | Yes |
| `POST` | `/api/v1/technician/skills` | Update trade category and specialized skills | Yes |
| `GET` | `/api/v1/technician/profile` | Technician bio, contact, and profile info | Yes |
| `PUT/PATCH`| `/api/v1/technician/profile` | Update profile information | Yes |
| `GET` | `/api/v1/technician/reviews` | Reviews received from customers with average rating | Yes |
| `POST` | `/api/v1/technician/reviews/{review}/reply` | Publish official reply to customer review | Yes |
| `GET` | `/api/v1/technician/chat/threads` | Active chat threads with customers | Yes |
| `GET` | `/api/v1/technician/chat/{customer}/messages` | Message history with specific customer | Yes |
| `POST` | `/api/v1/technician/chat/messages` | Send message to customer | Yes |
| `GET` | `/api/v1/technician/notifications` | Technician notifications with unread counter | Yes |
| `POST` | `/api/v1/technician/notifications/{notification}/read` | Mark single notification as read | Yes |
| `POST` | `/api/v1/technician/notifications/read-all` | Mark all technician notifications as read | Yes |

---

## 5. Video Consultations API (`/api/v1/video-meetings`)

Requires `auth:sanctum`. Real-time WebRTC tele-consultations between customers and technicians.

| Method | Endpoint | Description |
|---|---|---|
| `POST` | `/api/v1/video-meetings` | Initiate a video consultation room (returns unique room code) |
| `GET` | `/api/v1/video-meetings/{code}` | Retrieve room status, participants, and session timestamps |
| `POST` | `/api/v1/video-meetings/{code}/join` | Mark participant as joined |
| `POST` | `/api/v1/video-meetings/{code}/snapshot` | Upload snapshot taken from live video stream for diagnosis |
| `POST` | `/api/v1/video-meetings/{code}/end` | Terminate video consultation session |

---

## 6. Admin Portal API (`/api/v1/admin`)

Requires `auth:sanctum` and `api.role:admin`.

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/v1/admin/dashboard` | High-level metrics, active operations, KYC queue size |
| `GET` | `/api/v1/admin/notifications` | Platform admin notifications |
| `POST` | `/api/v1/admin/notifications/{notification}/read` | Mark admin notification read |
| `POST` | `/api/v1/admin/notifications/read-all` | Mark all admin notifications read |
| `GET` | `/api/v1/admin/analytics` | Revenue charts, growth trends, category breakdowns |
| `GET` | `/api/v1/admin/bookings` | Master bookings list with filtering and search |
| `GET` | `/api/v1/admin/bookings/{booking}` | Inspect booking and escrow transaction |
| `GET` | `/api/v1/admin/technicians/verification` | Pending KYC applications queue |
| `PATCH` | `/api/v1/admin/technicians/verification/{application}/approve` | Approve KYC dossier |
| `PATCH` | `/api/v1/admin/technicians/verification/{application}/return` | Request document revision |
| `PATCH` | `/api/v1/admin/technicians/verification/{application}/reject` | Reject technician application |
| `PATCH` | `/api/v1/admin/technicians/verification/{application}/review` | Move application to under review |
| `GET` | `/api/v1/admin/technicians` | Master technician directory management |
| `PATCH` | `/api/v1/admin/technicians/{professional}/verify` | Toggle verified badge status |
| `DELETE` | `/api/v1/admin/technicians/{professional}` | Remove technician account |
| `GET` | `/api/v1/admin/customers` | Master customer directory management |
| `PATCH` | `/api/v1/admin/customers/{customer}/toggle` | Suspend or activate customer account |
| `DELETE` | `/api/v1/admin/customers/{customer}` | Delete customer account |
| `GET` | `/api/v1/admin/services` | Service categories catalog |
| `POST` | `/api/v1/admin/services` | Create new service category |
| `PUT` | `/api/v1/admin/services/{service}` | Update service details and pricing |
| `DELETE` | `/api/v1/admin/services/{service}` | Delete service category |
| `PATCH` | `/api/v1/admin/services/{service}/toggle` | Toggle service active status |
| `GET` | `/api/v1/admin/faqs` | FAQs management list |
| `POST` | `/api/v1/admin/faqs` | Create new FAQ |
| `PUT` | `/api/v1/admin/faqs/{faq}` | Update FAQ |
| `DELETE` | `/api/v1/admin/faqs/{faq}` | Delete FAQ |
| `PATCH` | `/api/v1/admin/faqs/{faq}/toggle` | Toggle FAQ publish status |
| `GET` | `/api/v1/admin/community` | Civic hazard reports list |
| `PUT` | `/api/v1/admin/community/{issue}` | Update issue resolution status |
| `PATCH` | `/api/v1/admin/community/{issue}/toggle` | Toggle public visibility of issue |
| `DELETE` | `/api/v1/admin/community/{issue}` | Delete civic hazard report |
| `GET` | `/api/v1/admin/inquiries` | Support inquiries & complaints mailbox |
| `POST` | `/api/v1/admin/inquiries` | Log administrative support inquiry |
| `PUT` | `/api/v1/admin/inquiries/{inquiry}` | Update inquiry resolution status and response |
| `DELETE` | `/api/v1/admin/inquiries/{inquiry}` | Delete support inquiry |
| `GET` | `/api/v1/admin/homepage` | Homepage CMS content structure |
| `POST` | `/api/v1/admin/homepage/hero` | Update hero banner headlines and CTA |
| `POST` | `/api/v1/admin/homepage/testimonials` | Create homepage testimonial |
| `PUT` | `/api/v1/admin/homepage/testimonials/{testimonial}` | Update testimonial |
| `DELETE` | `/api/v1/admin/homepage/testimonials/{testimonial}` | Delete testimonial |
| `POST` | `/api/v1/admin/homepage/steps` | Create workflow step |
| `PUT` | `/api/v1/admin/homepage/steps/{step}` | Update workflow step |
| `DELETE` | `/api/v1/admin/homepage/steps/{step}` | Delete workflow step |
| `GET` | `/api/v1/admin/settings` | Platform configurations (Gemini AI, Fees, Currency) |
| `POST` | `/api/v1/admin/settings` | Save platform configuration |
| `POST` | `/api/v1/admin/settings/test-gemini` | Test live Google Gemini AI API connection |
| `GET` | `/api/v1/admin/payments` | Financial ledger, escrow balances, and platform commission |
