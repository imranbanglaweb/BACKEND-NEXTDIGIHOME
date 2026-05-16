# গাড়িবন্ধু ৩৬০ - Feature Documentation

## Table of Contents
1. [Fleet Management](#fleet-management)
2. [Driver Management](#driver-management)
3. [Transport Requisition System](#transport-requisition-system)
4. [Maintenance Management](#maintenance-management)
5. [Organization Management](#organization-management)
6. [HR Module](#hr-module)
7. [Subscription & Payment System](#subscription--payment-system)
8. [Reports & Analytics](#reports--analytics)
9. [Multi-Language System](#multi-language-system)
10. [Email System](#email-system)
11. [Notification System](#notification-system)
12. [Multi-Level Approval System](#multi-level-approval-system)

---

## Fleet Management

### Vehicle Fleet Overview
- Complete vehicle fleet management with detailed records
- Vehicle type categorization and classification
- Real-time vehicle availability tracking
- Vehicle document management (insurance, registration, etc.)
- Vehicle maintenance history and records
- Vehicle meter reading tracking (opening/closing meter)
- Vehicle assignment status management

### Key Features
- **Vehicle Registration**: Add new vehicles with comprehensive details
- **Vehicle Types**: Categorize vehicles (Sedan, SUV, Truck, Bus, etc.)
- **Document Management**: Track insurance, registration, permits
- **Availability Status**: Real-time tracking (Available, Assigned, Under Maintenance)
- **Meter Tracking**: Opening and closing meter readings for trips

---

## Driver Management

### Driver Profiles
- Comprehensive driver profiles and documentation
- License type tracking and expiry alerts
- Driver availability status management
- Performance tracking and evaluation
- Driver-document management
- Driver assignment tracking

### Key Features
- **Driver Registration**: Complete profile with personal details
- **License Management**: Track license types and expiry dates
- **Document Upload**: Driving license, ID, certification documents
- **Availability Status**: Available, On Trip, On Leave, Unavailable
- **Performance Metrics**: Trip count, rating, compliance

---

## Transport Requisition System

### Requisition Workflow
- Online requisition submission with approval workflow
- Multi-level approval process
- Trip sheet creation and tracking
- Vehicle and driver assignment
- Passenger management for transport requisitions
- Real-time status tracking
- Requisition history and audit trail
- Pending Transport Approval status for better workflow

### Requisition Statuses
1. **Pending** - Initial submission
2. **Pending Department Approval** - Waiting for Department Head
3. **Pending Transport Approval** - Waiting for Transport Admin
4. **Approved** - Confirmed and assigned
5. **Rejected** - Not approved
6. **Completed** - Trip completed

---

## Maintenance Management

### Maintenance Features
- Scheduled maintenance planning
- Maintenance requisition system
- Maintenance vendor management
- Complete maintenance history
- Cost tracking and reporting
- Maintenance categories
- Maintenance approval workflow (Department Head & Transport Admin)
- Charge bear by selection

### Maintenance Types
- Preventive Maintenance
- Corrective Maintenance
- Periodic Service
- Emergency Repair
- Inspection

### Approval Workflow
1. Employee submits maintenance requisition
2. Department Head approves/rejects
3. Transport Admin assigns vendor and approves
4. Maintenance performed
5. Record updated with cost details

---

## Organization Management

### Structure
- Department and unit management
- Employee management
- Role-based access control (RBAC)
- Multi-company support
- Location tracking
- Department Head assignment for approval workflows
- Employee-Transport linking for requisition system

### Key Entities
- **Companies**: Multiple company support
- **Departments**: Organizational departments
- **Units**: Sub-department units
- **Locations**: Physical locations/offices
- **Designations**: Job titles and positions

---

## HR Module

### Employee Management
- Comprehensive employee management with detailed profiles
- Department management and organizational hierarchy
- Designation and position tracking
- Department Head assignment for approval workflows
- Employee-Transport linking for requisition system
- Employee self-service portal

### Employee Features
- Profile management
- Department assignment
- Transport eligibility
- Contact information
- Emergency contacts

---

## Subscription & Payment System

### Subscription Management
- Subscription plan management
- Subscription tracking and history
- Manual payment processing
- Payment history and records
- Plan-based access control

### Payment Features
- Manual payment entry
- Payment history
- Invoice generation
- Payment verification

---

## Reports & Analytics

### Available Reports
1. **Requisition Reports**
   - Total requisitions by status
   - Department-wise analysis
   - Time-based trends
   
2. **Maintenance Reports**
   - Maintenance cost analysis
   - Frequency of maintenance
   - Vendor performance
   
3. **Trip Fuel Reports**
   - Fuel consumption per trip
   - Vehicle fuel efficiency
   - Cost analysis
   
4. **Vehicle Utilization Reports**
   - Vehicle usage patterns
   - Idle time analysis
   - Distance covered
   
5. **Driver Performance Reports**
   - Trip completion rate
   - Safety records
   - Efficiency metrics

### Export Options
- PDF export
- Excel/CSV export
- Print functionality

---

## Multi-Language System

### Translation Features
- Multi-language support with complete translation management
- Customizable language settings
- Dynamic content translation
- User language preference selection
- Admin-configurable language options

### Supported Languages
- English (Default)
- Additional languages configurable via admin panel

---

## Email System

### Email Features
- Customizable email templates management
- Email logging and history tracking
- Email resend functionality
- Error message tracking for failed emails
- SMTP configuration support

### Template Types
- Requisition submitted
- Requisition approved
- Requisition rejected
- Trip assigned to driver
- Maintenance request
- Custom notifications

---

## Notification System

### Notification Types
- **Push Notifications**: Real-time alerts for requisition status, approvals, trip assignments
- **Email Notifications**: Configurable email alerts
- **In-App Notifications**: System notifications dashboard
- **Email Templates**: Customizable templates for requisitions, approvals, driver assignments
- **Email Log History**: Complete audit trail of all sent emails
- **Notification Settings**: Configure channels, recipients, and preferences
- **Push Subscribers Management**: Track and manage notification subscriptions

### WebSocket Support
- Real-time updates
- Live notification delivery
- Pusher integration

---

## Multi-Level Approval System

### User Roles
1. **Employee**: Submit requisitions, view status, track trips
2. **Driver**: View assigned trips, manage availability, log fuel
3. **Department Head**: Approve/reject department requisitions (first approval level)
4. **Transport Admin**: Final approval authority, vehicle/driver assignment
5. **Admin**: Full system access

### Approval Flow
```
Employee submits requisition
    ↓
Department Head reviews (Level 1)
    ↓
Transport Admin final approval (Level 2)
    ↓
Vehicle & Driver assigned
    ↓
Trip executed
    ↓
Requisition completed
```

### Audit Trail
- Complete approval history
- Rejection reasons
- Timestamp tracking
- User identification

---

## Technology Stack

- **Backend**: Laravel 9.x / 10.x
- **Frontend**: Bootstrap 5, jQuery, DataTables
- **Database**: MySQL 8.0+ / MariaDB 10.2+
- **Authentication**: Laravel Sanctum, JWT
- **Real-time**: Pusher / WebSockets
- **PDF Generation**: DomPDF
- **Excel Export**: Maatwebsite Excel
- **QR Codes**: Simple QRCode
- **Translation**: Laravel Translation Manager

---

## API Endpoints

The system provides RESTful APIs for:
- Vehicle management
- Driver management
- Requisition workflows
- Trip sheet operations
- Maintenance tracking
- Employee management
- Notification management
- Subscription management
- Payment processing
- Report generation
- Language & translation management
- Email template management

---

*Last Updated: April 2026*
*Version: 1.2.0*
