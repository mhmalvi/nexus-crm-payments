# Nexus CRM Payments

The payment processing microservice for the **Nexus CRM** platform. This Laravel-based API manages payment gateways, transaction history, invoicing, subscription billing, and financial analytics with Docker support for containerized deployment.

## Features

- **Multi-Gateway Support** — Integrated with Stripe, PayPal, and eWAY payment processors
- **Payment Processing** — Secure charge creation and payment confirmation workflows
- **Transaction History** — Full payment history with per-lead and per-company filtering
- **Invoice Management** — Generate and list invoices with PDF export via DomPDF
- **Subscription Billing** — Create and manage recurring subscriptions with plan tiers
- **Card Management** — Securely store, update, and remove payment card details
- **Product & Pricing** — Manage product catalogs and dynamic pricing plans
- **Campaign Revenue Tracking** — Analyze payments attributed to specific marketing campaigns
- **Monthly & Weekly Reports** — Aggregated payment analytics by time period
- **Payment Settings** — Configurable payment gateway settings per company
- **Docker Support** — Multi-version PHP Docker configurations (7.4, 8.0, 8.1, 8.2)

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Framework | Laravel 10 |
| Language | PHP 8.1+ |
| Authentication | Laravel Sanctum |
| Payments | Stripe PHP SDK, PayPal, eWAY |
| PDF Generation | barryvdh/laravel-dompdf |
| Database | MySQL |
| DB Migrations | Doctrine DBAL |
| HTTP Client | Guzzle |
| Containerization | Docker |
| Testing | PHPUnit 10 |
| Code Style | StyleCI |

## Prerequisites

- PHP >= 8.1 (or Docker)
- Composer
- MySQL 5.7+ or MariaDB 10.3+
- Stripe API keys

## Getting Started

### Standard Setup

1. **Clone the repository**

   ```bash
   git clone https://github.com/mhmalvi/nexus-crm-payments.git
   cd nexus-crm-payments
   ```

2. **Install dependencies**

   ```bash
   composer install
   ```

3. **Configure environment**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Update `.env` with database credentials, Stripe/PayPal API keys, and service URLs.

4. **Run database migrations**

   ```bash
   php artisan migrate
   ```

   Alternatively, import the provided `crm_payment.sql` schema file.

5. **Start the development server**

   ```bash
   php artisan serve
   ```

### Docker Setup

```bash
./vendor/bin/sail up -d
```

Docker configurations are provided in the `docker/` directory for PHP versions 7.4, 8.0, 8.1, and 8.2.

## API Overview

| Endpoint Group | Description |
|---------------|-------------|
| `POST /api/stripe` | Process a Stripe payment |
| `POST /api/charge` | Execute a direct charge |
| `POST /api/payment/list` | List payment history |
| `POST /api/invoice/list` | List invoices |
| `GET /api/payment/{lead_id}/details` | Payment details for a lead |
| `POST /api/card-details-save` | Store card information |
| `POST /api/create-subscriptions` | Create a new subscription |
| `GET /api/subscriptions` | List all subscriptions |
| `POST /api/create-prices` | Define pricing plans |
| `POST /api/prices` | Retrieve available prices |
| `POST /api/campaign-wise-payment` | Revenue by campaign |
| `POST /api/monthly-payment` | Monthly payment analytics |

## Microservices Integration

| Service | Interaction |
|---------|------------|
| nexus-crm-users | Validates authentication and retrieves customer data |
| nexus-crm-leads | Links payments to specific leads |
| nexus-crm-orgs | Retrieves company context for multi-tenant billing |
| nexus-crm-client | Frontend consumes payment and invoice APIs |

## License

This project is proprietary software. All rights reserved.
