# Hipster Discount Package

A reusable Laravel package for user-level discounts with deterministic stacking, usage caps, and full audit logging.

---

## Features

- Assign / revoke discounts to users
- Deterministic stacking
- Per-user usage cap
- Configurable stacking order and rounding
- Events: `DiscountAssigned`, `DiscountRevoked`, `DiscountApplied`
- Fully tested with unit tests
- Safe concurrent discount application

---

## Installation

### 1. Clone Laravel Project (if needed)

If you don’t have a Laravel project yet:

```bash
composer create-project laravel/laravel laravel-project
cd laravel-project

```bash
# Create folders for the package
mkdir -p packages/Hipster
cd packages/Hipster

# Clone your discount package
git clone https://github.com/shavi1993/hipster-discount.git Discount

### 2. Update Laravel Project `composer.json`

After cloning the package into `packages/Hipster/Discount`, update your Laravel project `composer.json` so Composer can autoload it:

```json
"repositories": [
    {
        "type": "path",
        "url": "packages/Hipster/Discount"
    }
],
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Hipster\\Discount\\": "packages/Hipster/Discount/src/"
    }
}

