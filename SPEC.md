# VMS Driver App - Specification Document

## 1. Project Overview

**Project Name:** VMS Driver  
**Type:** Cross-platform Mobile Application (Flutter)  
**Core Functionality:** A mobile app for drivers to manage their trips, update trip status, log fuel consumption, view assigned vehicles, and manage availability.  
**Target Users:** Drivers who are assigned to the VMS (Vehicle Management System)

---

## 2. Technology Stack & Choices

### Framework & Language
- **Framework:** Flutter 3.x
- **Language:** Dart 3.x
- **Minimum SDK:** Android 21 (Lollipop), iOS 12

### Key Libraries/Dependencies
| Package | Purpose |
|---------|---------|
| `flutter_bloc` | State management (BLoC pattern) |
| `dio` | HTTP client for API calls |
| `get_it` | Dependency injection |
| `shared_preferences` | Local storage for tokens |
| `intl` | Date/time formatting |
| `flutter_secure_storage` | Secure token storage |
| `image_picker` | Photo capture for fuel receipts |
| `cached_network_image` | Image caching |
| `google_fonts` | Typography |
| `flutter_local_notifications` | Push notifications |

### State Management
- **BLoC Pattern** with `flutter_bloc` for predictable state management and separation of concerns

### Architecture Pattern
- **Clean Architecture** with three layers:
  - **Presentation Layer:** UI widgets, BLoC
  - **Domain Layer:** Use cases, entities
  - **Data Layer:** Repositories, data sources, models

---

## 3. Feature List

### Authentication
- [ ] Driver login with email/password
- [ ] Secure token storage
- [ ] Auto-login with stored token
- [ ] Logout functionality

### Dashboard
- [ ] Today's trips overview
- [ ] Active (In Transit) trip display
- [ ] Upcoming trips (next 5)
- [ ] Recent completed trips
- [ ] Quick stats (pending, active, completed)

### Trip Management
- [ ] View assigned trips list (paginated)
- [ ] Trip details view
- [ ] Update trip status (Start Trip, Finish Trip, End Trip)
- [ ] View passengers list for trip
- [ ] View trip route (from/to)

### Schedule
- [ ] Calendar/list view of upcoming trips
- [ ] Filter by date range

### Fuel Log
- [ ] Submit new fuel entry
- [ ] Select vehicle from assigned vehicles
- [ ] Enter fuel details (date, quantity, cost, odometer, station)
- [ ] Capture receipt photo (camera/gallery)
- [ ] View fuel log history

### Vehicle
- [ ] View assigned vehicle details
- [ ] View vehicle specifications
- [ ] View maintenance records

### Availability
- [ ] Update availability status (available, on leave, unavailable)
- [ ] Set leave dates
- [ ] Add notes

### Profile
- [ ] View driver profile
- [ ] View license information

---

## 4. UI/UX Design Direction

### Overall Visual Style
- **Material Design 3** with modern, clean aesthetics
- Professional appearance suitable for enterprise use

### Color Scheme
- **Primary:** Deep Blue (#1E3A8A) - Trust and professionalism
- **Secondary:** Amber (#F59E0B) - Action and attention
- **Success:** Green (#10B981) - Completed states
- **Warning:** Orange (#F97316) - Pending states
- **Error:** Red (#EF4444) - Error states
- **Background:** Light Gray (#F8FAFC)
- **Surface:** White (#FFFFFF)

### Layout Approach
- **Bottom Navigation** with 4 main tabs:
  1. Dashboard (Home)
  2. Trips
  3. Fuel Log
  4. Profile
- Drawer for additional options (Schedule, Vehicle, Availability, Settings)

### Typography
- **Font Family:** Google Fonts (Roboto)
- **Headlines:** Bold, larger sizes
- **Body:** Regular weight, comfortable reading size

### Key UI Components
- Cards for trip items
- Status badges with color coding
- Progress indicators for trip status
- Form inputs with validation feedback
- Pull-to-refresh for lists
- Loading states with skeleton loaders

---

## 5. API Integration

### Base URL
- Configurable, default: `https://your-domain.com/api`

### Authentication Endpoints
- `POST /api/login` - Driver login

### Driver Endpoints (existing Laravel methods)
- `GET /api/driver/dashboard` - Driver dashboard data
- `GET /api/driver/trips` - List trips
- `GET /api/driver/trips/{id}` - Trip details
- `POST /api/driver/trips/{id}/start` - Start trip
- `POST /api/driver/trips/{id}/finish` - Finish trip
- `POST /api/driver/trips/{id}/end` - End trip
- `GET /api/driver/schedule` - Get schedule
- `POST /api/driver/fuel-log` - Submit fuel log
- `GET /api/driver/fuel-log` - Get fuel logs
- `GET /api/driver/vehicle` - Get assigned vehicle
- `POST /api/driver/availability` - Update availability
- `GET /api/driver/profile` - Get profile

### Notes
- All driver endpoints require authentication token in headers
- Token format: `Bearer {token}`
- API responses follow standard JSON format

---

## 6. Project Structure

```
lib/
├── main.dart
├── app.dart
├── core/
│   ├── constants/
│   ├── theme/
│   ├── utils/
│   └── di/ (dependency injection)
├── data/
│   ├── datasources/
│   ├── models/
│   └── repositories/
├── domain/
│   ├── entities/
│   ├── repositories/
│   └── usecases/
└── presentation/
    ├── blocs/
    ├── pages/
    └── widgets/
```